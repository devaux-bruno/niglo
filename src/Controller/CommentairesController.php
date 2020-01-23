<?php


namespace App\Controller;


use App\Entity\Commentaires;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CommentairesController extends AbstractController
{

    /**
     * @Route("/admin/commentaires", name="commentaire_index")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $doctrine = $this->getDoctrine();

        $commentRepository = $doctrine->getRepository(Commentaires::class);
        $resultatcomment= $commentRepository->findAll();

        $pagination = $paginator->paginate(
            $resultatcomment, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            20 /*limit per page*/
        );

        return $this->render('admin/index_commentaire.html.twig', [
            'resultatcomment' => $resultatcomment,
            'pagination' => $pagination,
        ]);
    }

}