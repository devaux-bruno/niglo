<?php


namespace App\Controller;


use App\Entity\Partenaire;
use App\Form\PartenaireType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PartenaireController extends AbstractController
{
    /**
     * @Route("admin/partenaire", name="partenaire_index")
     */
    public function indexService(Request $request, PaginatorInterface $paginator)
    {
        $doctrine = $this->getDoctrine();

        $langRepository = $doctrine->getRepository(Partenaire::class);
        $resultatedit= $langRepository->findAll();

        $pagination = $paginator->paginate(
            $resultatedit, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            20 /*limit per page*/
        );

        return $this->render('admin/index_partenaire.html.twig', [
            'resultatedit' => $resultatedit,
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/admin/addPartenaire", name="partenaire_add")
     */
    public function addLang(Request $request)
    {
        $lang = new Partenaire();

        $formLang = $this->createForm(PartenaireType::Class, $lang, []);
        $formLang->handleRequest($request);

        if( $formLang->isSubmitted() && !$formLang->isEmpty() && $formLang->isValid())
        {
            if ($lang->getPhoto() != '' || $lang->getPhoto() != null) {
                //ajout d'une photo
                $file = $formLang->get('photo')->getData();
                //$file = $user->getCustomerPicture();
                $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('profil_pictures_directory'),
                        $fileName
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Un problème est survenue sur votre photo lors de l\'enregistrement!');

                    return $this->redirectToRoute('home', []);
                }


            } else {
                $fileName = '';
            }
            $lang->setPhoto($fileName);
            $lang->setDateAjout(new \DateTime()) ;
            $lang->setPublier('0');
            $doctrine = $this->getDoctrine();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($lang);
            $entityManager->flush();

            $this->addFlash('success', 'Le partenaire a bien été enregistré!');

            return $this->redirectToRoute('partenaire_index',[]);


        }
        return $this->render('admin/partenaire_add.html.twig',[
            'formAjout' => $formLang->createView(),
        ]);
    }

    /**
     * @Route("admin/partenaire/delete/{id}", name="partenaire_delete")
     */
    public function deleteService(Partenaire $id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $lang = $entityManager->getRepository(Partenaire::class)->find($id);

        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();

        if (!$lang) {
            throw $this->createNotFoundException(
                'Il n \'y a pas de Langue avec '.$id
            );
        }

        $entityManager->remove($lang);
        $entityManager->flush();

        $this->addFlash('success', 'Le Partenaire a bien été supprimé!');

        return $this->redirectToRoute('partenaire_index',[]);
    }

    /**
     * @Route("/admin/partenaire/edit/{id}", name="partenaire_edit")
     */
    public function adminEditLang(Request $request, Partenaire $id)
    {

        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();

        $form = $this->createForm(PartenaireType::class, $id, []);
        $form->handleRequest($request);

        $partenairePicture = $entityManager->getRepository(Partenaire::class)->find($id)->getphoto();

        if( $form->isSubmitted() && $form->isValid())
        {
            $file = $form->get('photo')->getData();
            if(!empty($partenairePicture) || $partenairePicture !=''){

                if( !empty($file) ){
                    //suppression de l'ancienne photo
                    $fichierSupp = $this->getParameter('profil_pictures_directory');
                    unlink($fichierSupp.$partenairePicture);
                    $fs = new Filesystem();
                    $fs->remove($fichierSupp.$id->getPhoto());

                    //update de la nouvelle photo
                    $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                    try {
                        $file->move(
                            $this->getParameter('profil_pictures_directory'),
                            $fileName
                        );
                    } catch (FileException $e) {
                        $this->addFlash('error', 'Un problème est survenue sur votre photo lors de la modification!');

                        return $this->redirectToRoute('partenaire_edit', []);
                    }
                    $id->setPhoto($fileName);
                }
                else{
                    $id->setPhoto($partenairePicture);
                }
            }
            else{
                if( !empty($file) ){
                    //ajout d'une photo
                    $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                    try {
                        $file->move(
                            $this->getParameter('profil_pictures_directory'),
                            $fileName
                        );
                    } catch (FileException $e) {
                        $this->addFlash('error', 'Un problème est survenue sur votre photo lors de l\'enregistrement!');

                        return $this->redirectToRoute('user_edit', []);
                    }
                    $id->setPhoto($fileName);
                }
                else{
                    $id->setPhoto($partenairePicture);
                }

            }


            $id->setPublier(0);
            $id->setDateAjout(new \DateTime()) ;
            $entityManager->persist($id);
            $entityManager->flush();

            $this->addFlash('success', 'Le partenaire a bien été modifié!');

            return $this->redirectToRoute('partenaire_index',[]);

        }

        return $this->render('admin/partenaire_edit.html.twig',[
            'formAdminEdit' => $form->createView(),
            'id'=>$id,
        ]);

    }




    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        // md5() reduces the similarity of the file names generated by
        // uniqid(), which is based on timestamps
        return md5(uniqid());
    }

}