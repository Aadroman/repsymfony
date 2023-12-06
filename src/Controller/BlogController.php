<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog')]
    public function index(): Response
    {
        return $this->render('blog/index.html.twig', [
            'controller_name' => 'BlogController',
            'id' => 200,
            'name' => "2cent"
        ]);
    }

    #[Route('/', name:'app_root')]
    public function root(): Response
    {
        return new Response('Hello World');
    }

    #[Route('/blog/{id}/{name}', name: 'app_blog_value', requirements: ["name"=>"[a-zA-Z]{5,50}", "id"=>"[0-9]{2,6}"])]
    public function indexWithValues(int $id, string $name): Response
    {
        return $this->render('blog/index.html.twig',[
            'id' => $id,
            'name' => $name,
            'controller_name' => 'LeRu',
        ]);
    }

    #[Route('/blog/articles', name: 'app_blog_articles')]
    public function showArticles(ArticleRepository $repoArticle, CategoryRepository $repoCategory): Response
    {
        $articles = $repoArticle->findAll();
        $categories = $repoCategory->findAll();
        //dd($articles); //dd siginifie dump and die, donc affichage "brut" et arrêt de l'éxécution
        return $this->render('blog/index.html.twig', [
            'articles' => $articles,
            'categories' => $categories,
        ]);
    }

    // #[Route('/blog/article/{id}', name: 'app_single_article_id')]
    // public function singleId(ArticleRepository $repoArticle, $id): Response
    // {
    //     $article = $repoArticle->findOneById($id); //on peut rechercher n'importe quel attribut de l'entité
    //     return $this->render('blog/single.html.twig', ['article' => $article,]);
    // }

    #[Route('/blog/article/{slug}', name: 'app_single_article')]
    public function single(ArticleRepository $repoArticle, CategoryRepository $repoCategory, string $slug): Response
    {
        $article = $repoArticle->findOneBySlug($slug); //on peut rechercher n'importe quel attribut de l'entité
        $categories = $repoCategory->findAll(); //recherche de toutes les catégories pour les afficher dans le header
        return $this->render('blog/single.html.twig', ['article' => $article,'categories'=>$categories,]);
    }


    #[Route('/blog/category/{slug}', name: 'app_single_category')]
    public function single_category(CategoryRepository $repoCategory,string $slug): Response
    {
        $categories = $repoCategory->findAll(); //recherche de toutes les catégories pour les afficher dans le header
        $category = $repoCategory->findOneBySlug($slug);
        $articles = [];
        $articles = $category->getArticles(); //on peut rechercher n'importe quel attribut de l'entité
        return $this->render('blog/articles_by_category.html.twig', ['articles' => $articles,'categories'=>$categories, 'category'=>$category]);
    }


}
