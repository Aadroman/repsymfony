<?php

namespace App\Controller;

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
}
