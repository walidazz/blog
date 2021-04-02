<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="list_article")
     */
    public function index(PaginatorInterface $paginator, Request $request, ArticleRepository $repo): Response
    {
        $em = $this->getDoctrine()->getRepository(Article::class);

        $query    = $repo->findAllQuery();
        $articles = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            9
        );
        return $this->render('article/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/article/{libelle}", name="article_category_list")
     */
    public function articlelList($libelle, PaginatorInterface $paginator, Request $request)
    {

        $query    = $this->repo->findAllByCategory($libelle);
        $articles = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            9
        );
        return $this->render('article/index.html.twig', compact('articles', 'libelle'));
    }


    /**
     * @Route("/article/{slug}", name="detail_article")
     */
    public function detail(Article $article): Response
    {
        return $this->render('article/detail.html.twig', [
            'article' => $article,
        ]);
    }
}
