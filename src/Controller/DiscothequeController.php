<?php

namespace App\Controller;

use App\Entity\Artiste;
use App\Repository\TypeRepository;
use App\Entity\Chanson;
use App\Form\ChansonType;
use App\Repository\ChansonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class DiscothequeController extends AbstractController
{
    #[Route('/discotheque', name: 'app_disco_index', methods: ['GET'])]
    public function index(ChansonRepository $repoChanson): Response
    {
        return $this->render('discotheque/index.html.twig', [
            'controller_name' => 'DiscothequeController',
            'chansons' => $repoChanson->findAll(),
        ]);
    }

    #[Route('/discotheque/type/{id}', name: 'app_single_type')]
    public function single_type(TypeRepository $repoType,int $id): Response
    {
        $types = $repoType->findAll(); //recherche de toutes les catégories pour les afficher dans le header
        $type = $repoType->findOneById($id);
        $artistes = [];
        $artistes = $type->getGenreArtiste(); //on peut rechercher n'importe quel attribut de l'entité
        return $this->render('discotheque/artistes_by_type.html.twig', ['artistes' => $artistes,'types'=>$types, 'type'=>$type]);
    }

    #[Route('/discotheque/artiste/show/{id}', name: 'app_single_artiste', methods: ['GET'])]
    public function showArtiste(Artiste $artiste): Response
    {
        // var_dump($artiste);
        return $this->render('discotheque/showArtiste.html.twig', ['artiste' => $artiste,]);
    }   

    #[Route('/discotheque/chanson/show/{id}', name: 'app_single_chanson', methods: ['GET'])]
    public function showChanson(Chanson $chanson): Response
    {
        return $this->render('discotheque/showChanson.html.twig', ['chanson' => $chanson]);
    }

    #[Route('/discotheque/chanson/new', name: 'app_chanson_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ChansonRepository $chansonRepository): Response
    {
        $chanson = new Chanson();
        $form = $this->createForm(ChansonType::class, $chanson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $date = date('d-m-Y H:i:s', time());
            // $dateSortie=new \DateTimeImmutable($date);
            // $chanson->setDateSortie($dateSortie);
            $artistes = $form->get('artistes')->getData();
            foreach($artistes as $artiste){
                $artiste->addParticiperChanson($chanson);
            }
            $chansonRepository->save($chanson, true);
            $this->addFlash('notice', 'Article ajouté !');
            return $this->redirectToRoute('app_disco_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('discotheque/new.html.twig', [
            'chanson' => $chanson,
            'form' => $form,
        ]);
    }

    #[Route('/discotheque/chanson/edit/{id}', name: 'app_chanson_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Chanson $chanson, ChansonRepository $chansonRepository): Response
    {
        $form = $this->createForm(ChansonType::class, $chanson);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // var_dump($form->getData());
            // $date = date('d-m-Y H:i:s', time());
            // $dateSortie=new \DateTimeImmutable($date);
            // $chanson->setDateSortie($dateSortie);
            $artistes = $form->get('artistes')->getData();
            foreach($artistes as $artiste){
                $artiste->addParticiperChanson($chanson);
            }
            $chansonRepository->save($chanson, true);
            $this->addFlash('notice', 'Chanson modifié !');
            return $this->redirectToRoute('app_disco_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('discotheque/edit.html.twig', [
            'chanson' => $chanson,
            'form' => $form,
        ]);
    }

    #[Route('/discotheque/chanson/{id}/delete', name: 'app_chanson_delete', methods: ['POST'])]
    public function delete(Request $request, Chanson $chanson, ChansonRepository $chansonRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$chanson->getId(), $request->request->get('_token'))) {
            $chansonRepository->remove($chanson, true);
        }

        return $this->redirectToRoute('app_disco_index', [], Response::HTTP_SEE_OTHER);
    }
}
