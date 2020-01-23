<?php


namespace App\Controller;


use App\Entity\Utilisateur;
use App\Form\newPasswordType;
use App\Form\UtilisateurEditType;
use App\Form\UtilisateurType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UtilisateurController extends AbstractController
{
    /**
     * @Route("admin/user", name="user_index")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $doctrine = $this->getDoctrine();

        $userRepository = $doctrine->getRepository(Utilisateur::class);
        $resultatedit= $userRepository->findAll();

        $pagination = $paginator->paginate(
            $resultatedit, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            6 /*limit per page*/
        );

        return $this->render('admin/index_user.html.twig', [
            'resultatedit' => $resultatedit,
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("/member/profil", name="profil_index")
     */
    public function indexProfil()
    {

        return $this->render('member/profil.html.twig', [
        ]);
    }

    /**
     * @Route("/member/edit/{id}", name="user_edit")
     */
    public function edit(Request $request, Utilisateur $id)
    {

        $idUser = $this->getUser()->getId();
        $numIdUser = $id->getId();

        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();
        $userPicture = $entityManager->getRepository(Utilisateur::class)->find($id)->getphoto();

        if($idUser != $numIdUser ) {
            $this->addFlash('error', 'Vous ne pouvez modifier que votre profil');
            return $this->redirectToRoute('home',[]);
        }

        $form = $this->createForm(UtilisateurEditType::class, $id, []);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid())
        {

            if( !empty($userPicture) ){

                $file = $form->get('photo')->getData();

                if( !empty($file) ){
                    //suppression de l'ancienne photo
                    $fichierSupp = $this->getParameter('profil_pictures_directory');
                    unlink($fichierSupp.$userPicture);
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

                        return $this->redirectToRoute('user_edit', []);
                    }
                    $id->setPhoto($fileName);
                }
                else{
                    $id->setPhoto($userPicture);
                }
            }
            else{
                $file = $form->get('photo')->getData();
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
                    $id->setPhoto($userPicture);
                }

            }

            $entityManager->persist($id);
            $entityManager->flush();

            $this->addFlash('success', 'Votre profil a bien été modifié!');

            return $this->redirectToRoute('profil_index',[]);
        }
        return $this->render('member/user_edit.html.twig',[
            'formUserEdit' => $form->createView(),
        ]);
    }

    /**
     * @Route("/member/passwordEdit/{userId}", name="password_edit")
     */
    public function editPassword(Request $request, Utilisateur $userId, UserPasswordEncoderInterface $encoder)
    {

        // require the user to log in during *this* session
        // if they were only logged in via a remember me cookie, they
        // will be redirected to the login page
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $idUser = $this->getUser()->getId();
        $numIdUser = $userId->getId();

        if($idUser != $numIdUser ) {
            $this->addFlash('error', 'Vous ne pouvez modifier que votre profil');
            return $this->redirectToRoute('home',[]);
        }

        $form = $this->createForm(newPasswordType::class, $userId, []);
        $form->handleRequest($request);

        if( $form->isSubmitted() && $form->isValid())
        {
            $dataold = $form->get('mdp')->getData();
            $datanew = $form->get('newPassword')->getData();
            $checkPassword = $encoder->isPasswordValid($userId, $dataold);

            if($checkPassword === true){

                $doctrine = $this->getDoctrine();
                $entityManager = $doctrine->getManager();

                $newPassword = $encoder->encodePassword($userId, $datanew);
                $userId->setMdp($newPassword);

                $entityManager->persist($userId);
                $entityManager->flush();

                $this->addFlash('success', 'Votre mot de passe a bien été modifié!');

                return $this->redirectToRoute('profil_index',[]);
            }
            else{
                $this->addFlash('error', 'Désolé, votre ancien mot de passe n\'est pas correct');
                return $this->redirectToRoute('password_edit', ['userId' => $idUser]);
            }
        }

        return $this->render('member/password_edit.html.twig',[
            'formUserEdit' => $form->createView(),
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