<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Repository\CommentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CommentController extends AbstractController
{
    /**
     * @Route("/comment/repplyComment/{id}", name="repply_comment" , methods={"POST"})
     */
    public function response($id, Request $request, CommentsRepository $repo, EntityManagerInterface $em): Response
    {

        $parent = $repo->find($id);

       // $request->request->get('pseudo');
        $comment = new Comments();
        $comment->setArticle($parent->getArticle())
            ->setParent($parent)
            ->setContent($request->request->get('content'))
            ->setEmail($request->request->get('email'))
            ->setPseudo($request->request->get('pseudo'))
            ->setWebsite($request->request->get('website'));
        $em->persist($comment);
        $em->flush();

        $this->addFlash('success', 'Le commentaire sera publié apres vérification auprès d\'un modérateur !');
        return $this->redirectToRoute('detail_article', ['slug' => $parent->getArticle()->getSlug()]);
    }
}
