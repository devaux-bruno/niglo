<?php


namespace App\Controller;


use App\Entity\Partenaire;
use App\Entity\Service;
use App\Form\EnleverType;
use App\Form\PartenaireEnleverType;
use App\Form\PartenairePublierType;
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

    public function partenaireRender()
    {
        $doctrine = $this->getDoctrine();

        $languagesRepository = $doctrine->getRepository(Partenaire::class);
        $resultatedit= $languagesRepository->findPublier();


        return $this->render('home/partenaire_list.html.twig', [
            'resultatshow' => $resultatedit,
        ]);
    }


    /**
     * @Route("admin/setting", name="setting")
     */
    public function setting(Request $request)
    {
        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();

        $formparam = $this->createForm(PublierType::Class);
        $formparam->handleRequest($request);
        $formparam1 = $this->createForm(EnleverType::Class);
        $formparam1->handleRequest($request);

        $formparam3 = $this->createForm(PartenairePublierType::Class);
        $formparam3->handleRequest($request);
        $formparam4 = $this->createForm(PartenaireEnleverType::Class);
        $formparam4->handleRequest($request);

        if( $formparam->isSubmitted() && !$formparam->isEmpty() && $formparam->isValid())
        {
            $data = $formparam->get('publier')->getData();
            $service = $entityManager->getRepository(Service::class)->findOneBy(['id'=>$data]);
            $service->setPublier('1');


            $entityManager->persist($service);
            $entityManager->flush();

            $this->addFlash('success', 'Leservice a bien été rajouté au menu!');
            return $this->redirectToRoute('setting');
        }
        if( $formparam1->isSubmitted() && !$formparam1->isEmpty() && $formparam1->isValid())
        {

            $data = $formparam1->get('enlever')->getData();
            $service = $entityManager->getRepository(Service::class)->findOneBy(['id'=>$data]);
            $service->setPublier('0');


            $entityManager->persist($service);
            $entityManager->flush();

            $this->addFlash('success', 'Le service a bien été enlever du menu!');
            return $this->redirectToRoute('setting');
        }
        if( $formparam3->isSubmitted() && !$formparam3->isEmpty() && $formparam3->isValid())
        {
            $data = $formparam3->get('publier')->getData();
            $service = $entityManager->getRepository(Partenaire::class)->findOneBy(['id'=>$data]);
            $service->setPublier('1');


            $entityManager->persist($service);
            $entityManager->flush();

            $this->addFlash('success', 'Le partenaire a été publié!');
            return $this->redirectToRoute('setting');
        }
        if( $formparam4->isSubmitted() && !$formparam4->isEmpty() && $formparam4->isValid())
        {

            $data = $formparam4->get('enlever')->getData();
            $service = $entityManager->getRepository(Partenaire::class)->findOneBy(['id'=>$data]);
            $service->setPublier('0');


            $entityManager->persist($service);
            $entityManager->flush();

            $this->addFlash('success', 'Le partenaire n\'est plus publié!');
            return $this->redirectToRoute('setting');
        }


        return $this->render('admin/setting.html.twig',[
            'formAdminEdit' => $formparam->createView(),
            'formAdminEdit1' => $formparam1->createView(),
            'formAdminEdit3' => $formparam3->createView(),
            'formAdminEdit4' => $formparam4->createView(),
        ]);
    }
}