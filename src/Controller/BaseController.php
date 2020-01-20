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
        $doctrine = $this->getDoctrine();
        $menuRepository = $doctrine->getRepository(Service::class);
        $resultatmenu = $menuRepository->findAll();

        $formparam = $this->createForm(PublierType::Class);
        $formparam->handleRequest($request);

        if( $formparam->isSubmitted() && !$formparam->isEmpty() && $formparam->isValid())
        {

            $serviceId = $formparam->get('publier')->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $menu = $entityManager->getRepository(Service::class)->find($serviceId);

            $menu->setPublier(1);
            $entityManager->persist($menu);
            $entityManager->flush();

            $this->addFlash('success', 'Le service a bien été ajouté au menu!');

            return $this->redirectToRoute('setting',[]);


        }
        return $this->render('admin/setting.html.twig',[
            'formAdminEdit' => $formparam->createView(),
            'resultatmenu' => $resultatmenu,
        ]);
    }
}