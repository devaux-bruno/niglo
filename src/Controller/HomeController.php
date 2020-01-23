<?php


namespace App\Controller;


use App\Entity\Articles;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {

        $doctrine = $this->getDoctrine();

        $articleRepository = $doctrine->getRepository(Articles::class);
        $resultatedit= $articleRepository->findAll();


        $pagination = $paginator->paginate(
            $resultatedit, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );

        return $this->render('home/index.html.twig',[
            'resultatedit' => $resultatedit,
            'pagination' => $pagination,
            ]);
    }
}