<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Article;
use Symfony\Component\Routing\Annotation\Route;

class ArticlePageController extends AbstractController
{
    /**
     * @Route("/article/{slug}", name="article-page")
     * @param $slug
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function show($slug, EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Article::class);
        $article = $repository->findOneBy(array('Slug' => $slug));

        return $this->render('article/article-page-1.html.twig', [
            'article' => $article,
        ]);
    }
}

