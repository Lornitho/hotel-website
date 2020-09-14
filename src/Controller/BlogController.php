<?php

namespace App\Controller;

use App\Entity\Blog;
use App\Repository\BlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(BlogRepository $blogRepository)
    {
        return $this->render('blog/index.html.twig', [
            'billets'=>$blogRepository->findAll()

        ]);
    }

    /**
     * @Route("/blog/{id}-{slug}", name="blog-detail")
     */
    public function detail(Blog $blog)
    {
        return $this->render('blog/show.html.twig', [
            'billet'=>$blog

        ]);
    }

}
