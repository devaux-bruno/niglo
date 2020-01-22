<?php


namespace App\Controller;


use App\Entity\Service;
use App\Form\PublierType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BaseController extends AbstractController
{

    public function baseRender()
    {
        $doctrine = $this->getDoctrine();

        $languagesRepository = $doctrine->getRepository(Service::class);
        $resultatedit= $languagesRepository->findPublier();


        return $this->render('home/service_list.html.twig', [
            'resultatshow' => $resultatedit,
        ]);
    }


    /**
     * @Route("admin/setting", name="setting")
     */
    public function setting(Request $request)
    {

        $formparam = $this->createForm(PublierType::Class);
        $formparam->handleRequest($request);

        if( $formparam->isSubmitted() && !$formparam->isEmpty() && $formparam->isValid())
        {

            $data = $formparam->get('publier')->getData();

            $doctrine = $this->getDoctrine();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($data);
            $entityManager->flush();

            $this->addFlash('success', 'Les paramètres ont bien étés modifiés!');
            return $this->redirectToRoute('setting',[]);
        }
        return $this->render('admin/setting.html.twig',[
            'formAdminEdit' => $formparam->createView(),
        ]);
    }
}