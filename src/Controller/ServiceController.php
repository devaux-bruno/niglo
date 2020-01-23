<?php


namespace App\Controller;


use App\Entity\Organisateur;
use App\Entity\Service;
use App\Form\AssociationType;
use App\Form\ServiceType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{

    /**
     * @Route("admin/service", name="service_index")
     */
    public function indexService(Request $request, PaginatorInterface $paginator)
    {
        $doctrine = $this->getDoctrine();

        $langRepository = $doctrine->getRepository(Service::class);
        $resultatedit= $langRepository->findAll();

        $pagination = $paginator->paginate(
            $resultatedit, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            20 /*limit per page*/
        );

        return $this->render('admin/index_service.html.twig', [
            'resultatedit' => $resultatedit,
            'pagination' => $pagination,
        ]);
    }



    /**
     * @Route("/admin/addService", name="service_add")
     */
    public function addLang(Request $request)
    {
        $lang = new Service();

        $formLang = $this->createForm(ServiceType::Class, $lang, []);
        $formLang->handleRequest($request);

        if( $formLang->isSubmitted() && !$formLang->isEmpty() && $formLang->isValid())
        {

            $lang->setDateCreation(new \DateTime()) ;
            $lang->setPublier('0');
            $doctrine = $this->getDoctrine();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($lang);
            $entityManager->flush();

            $this->addFlash('success', 'Le nouveau service a bien été enregistré!');

            return $this->redirectToRoute('service_index',[]);


        }
        return $this->render('admin/service_add.html.twig',[
            'formAjout' => $formLang->createView(),
        ]);
    }

    /**
     * @Route("admin/lang/delete/{serviceId}", name="service_delete")
     */
    public function deleteService(Service $serviceId)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $lang = $entityManager->getRepository(Service::class)->find($serviceId);

        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();

        if (!$lang) {
            throw $this->createNotFoundException(
                'Il n \'y a pas de Langue avec '.$serviceId
            );
        }

        $entityManager->remove($lang);
        $entityManager->flush();

        $this->addFlash('success', 'Le service a bien été supprimé!');

        return $this->redirectToRoute('service_index',[]);
    }

    /**
     * @Route("/admin/lang/edit/{serviceId}", name="service_edit")
     */
    public function adminEditLang(Request $request, Service $serviceId)
    {

        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();

        $form = $this->createForm(ServiceType::class, $serviceId, []);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid())
        {
            $serviceId->setPublier(0);
            $serviceId->setDateCreation(new \DateTime()) ;
            $entityManager->persist($serviceId);
            $entityManager->flush();

            $this->addFlash('success', 'Le service a bien été modifié!');

            return $this->redirectToRoute('service_index',[]);

        }

        return $this->render('admin/service_edit.html.twig',[
            'formAdminEdit' => $form->createView(),
        ]);

    }

    /**
     * @Route("/admin/associe", name="associer")
     */
    public function addAssocier(Request $request)
    {
        $orga = new Organisateur();

        $formOrga = $this->createForm(AssociationType::Class, $orga, []);
        $formOrga->handleRequest($request);

        if( $formOrga->isSubmitted() && !$formOrga->isEmpty() && $formOrga->isValid())
        {
            $orga->setDateAjout(new \DateTime()) ;
            $doctrine = $this->getDoctrine();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($orga);
            $entityManager->flush();

            $this->addFlash('success', 'Le mebre a bien été associé à ce service!');

            return $this->redirectToRoute('service_index',[]);


        }
        return $this->render('admin/organisation.html.twig',[
            'formAjout' => $formOrga->createView(),
        ]);
    }

}