<?php


namespace App\Controller;


use App\Entity\Newsletter;
use App\Form\NewsletterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class NewsletterController extends AbstractController
{

    /**
     * @Route("/newsletter", name="news" , methods={"GET","POST"})
     */
    public function baseNewsletter(Request $request)
    {
        /*$request = $this->get('request_stack')->getMasterRequest();*/
        $news= new Newsletter();
        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();
        $user = $this->getUser();

        $form = $this->createForm(NewsletterType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && !$form->isEmpty() && $form->isValid() ) {

            $dataSearch = $form['email']->getData();

            $newsletterRepository = $doctrine->getRepository(Newsletter::class);
            $emailsNews= $newsletterRepository->findOneBy(['email'=>$dataSearch]);

            if(!$emailsNews){
                $news->setEmail($dataSearch);
                $news->setDateRegistre(new \DateTime());
                $news->setActive(1);
                $news->setIdUtilisateur($user);
                $entityManager->persist($news);
                $entityManager->flush();

                $this->addFlash('success', 'Merci pour votre inscription et votre soutien!');
                return $this->redirectToRoute('home',[]);
            }else{
                $this->addFlash('error', 'Cet email est déjà inscrit à notre newsletter!');
                return $this->redirectToRoute('home',[]);
            }


        }

        return $this->render('home/newsletter.html.twig', [
            'resultatsearch' => $form->createView(),
        ]);
    }

}