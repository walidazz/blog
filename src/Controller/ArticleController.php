<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comments;
use App\Form\CommentType;
use App\Repository\ArticleRepository;
use App\Repository\CommentsRepository;
use Doctrine\ORM\EntityManagerInterface;
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
       // $em = $this->getDoctrine()->getRepository(Article::class);

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
    public function articlelList($libelle, PaginatorInterface $paginator, Request $request, ArticleRepository $repo)
    {

        $query    = $repo->findAllByCategory($libelle);
        $articles = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            9
        );
        return $this->render('article/index.html.twig', compact('articles', 'libelle'));
    }


    /**
     * @Route("/article/detail/{slug}", name="detail_article")
     */
    public function detail(Article $article, Request $request, EntityManagerInterface $em): Response
    {

        $comment = new Comments();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setArticle($article);
            $em->persist($comment);
            $em->flush();
            $this->addFlash('success', 'Commentaire posté avec succes !');
        }

        return $this->render('article/detail.html.twig', [
            'article' => $article, 'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/article/repplyComment/{id}", name="repply_comment" , methods={"POST"})
     */
    public function response($id, Request $request, CommentsRepository $repo, EntityManagerInterface $em): Response
    {

        $parent = $repo->find($id);

        $request->request->get('pseudo');
        $comment = new Comments();
        $comment->setArticle($parent->getArticle())
            ->setParent($parent)
            ->setContent($request->request->get('content'))
            ->setEmail($request->request->get('email'))
            ->setPseudo($request->request->get('pseudo'))
            ->setWebsite($request->request->get('website'));
        $em->persist($comment);
        $em->flush();


        return $this->redirectToRoute('detail_article', ['slug' => $parent->getArticle()->getSlug()]);
    }
}
