<?php


namespace App\Controller;


use App\Entity\Articles;
use App\Entity\Commentaires;
use App\Form\CommentaireAdminType;
use App\Form\CommentaireType;
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

    /**
     * @Route("/commentaires/read/{id}", name="comments_read")
     */
    public function readComment(Request $request, Articles $id)
    {
        $doctrine = $this->getDoctrine();

        $userRepository = $doctrine->getRepository(Commentaires::class);
        $resultatComment= $userRepository->findby(['idArticle'=> $id], ['datePost' => 'Desc']);

        return $this->render('home/commentaire.html.twig',
            ['resultatComment' => $resultatComment]);
    }
    /**
     * @Route("/member/comments-signaled/{id}", name="comments_signaled")
     */
    public function signaledComment(Request $request, Commentaires $id)
    {
        $idArticle = $id->getIdArticle()->getId();

        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();

        $id->setSignaler(1);

        $entityManager->persist($id);
        $entityManager->flush();

        $this->addFlash('success', 'Merci! Le commentaire a bien été signalé et sera étudié!');

        return $this->redirectToRoute('article', ['id'=> $id->getId(),]);
    }

    /**
     * @Route("/admin/changerCommentaire/{id}", name="changer_commentaire")
     */
    public function changerCommentaire(Request $request, Commentaires $id)
    {

        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();

        $status= $id->getSignaler();
        if( $status == 0){
            $id->setSignaler(1);
        }else{
            $id->setSignaler(0);
        }

        $entityManager->persist($id);
        $entityManager->flush();

        $this->addFlash('success', 'Merci! Le status du commentaire à bien été changer!');

        return $this->redirectToRoute('commentaire_index');
    }

    /**
     * @Route("admin/comment-delete/{id}", name="admin_comment_delete")
     */
    public function deleteComment(Commentaires $id)
    {
        $idUser = $this->getUser();

        $commentUserId = $id->getIdUtilisateur();
        $statusUserComment = $idUser->getStatus();

        if($idUser != $commentUserId && $statusUserComment == 'admin') {
            $this->addFlash('error', 'Tu ne peux pas supprimmer les commentaires d\'un autre Admin!');
            return $this->redirectToRoute('commentaire_index',[]);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $comment = $entityManager->getRepository(Commentaires::class)->find($id);


        if (!$comment) {
            throw $this->createNotFoundException(
                'Il n \'y a pas de commentaire n° '.$id
            );
        }
        $entityManager->remove($comment);
        $entityManager->flush();

        $this->addFlash('success', 'Le commentaire a bien été supprimé!');

        return $this->redirectToRoute('commentaire_index',[]);
    }

    /**
     * @Route("member/commentaire-delete/{id}", name="commentaire_delete")
     */
    public function deleteMemberComment(Commentaires $id)
    {
        $idUser = $this->getUser();
        $commentUserId = $id->getIdUtilisateur();

        if($idUser != $commentUserId) {

            $this->addFlash('error', 'Tu ne peux pas supprimmer les commentaires de quelqu\'un d\'autre!');
            return $this->redirectToRoute('profil_index',[]);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $comment = $entityManager->getRepository(Commentaires::class)->find($id);

        if (!$comment) {
            throw $this->createNotFoundException(
                'Il n \'y a pas de commentaire n° '.$id
            );
        }
        $entityManager->remove($comment);
        $entityManager->flush();

        $this->addFlash('success', 'Le commentaire a bien été supprimé!');

        return $this->redirectToRoute('home',[]);
    }

    /**
     * @Route("/member/modifiercommentaire/{id}", name="modifier_commentaire")
     */
    public function editMemberComment(Request $request, Commentaires $id)
    {
        $idUser = $this->getUser();
        $commentUserId = $id->getIdUtilisateur();

        if($idUser != $commentUserId) {
            $this->addFlash('error', 'Tu ne peux pas modifier le commentaires de quelqu\'un d\'autre!');
            return $this->redirectToRoute('profil_index',[]);
        }

        $form = $this->createForm(CommentaireType::class, $id, []);
        $form->handleRequest($request);

        if ($form->isSubmitted() && !$form->isEmpty() && $form->isValid()) {

            $doctrine = $this->getDoctrine();
            $entityManager = $doctrine->getManager();

            $entityManager->persist($id);
            $entityManager->flush();

            $this->addFlash('success', 'Votre commentaire a bien été modifié!');

            return $this->redirectToRoute('home', []);

        }
        return $this->render('member/commentaire_modif.html.twig', [
            'formAjoutcomment' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/ajoutercommentaire", name="ajouter_commentaire")
     */
    public function ajoutMemberComment(Request $request)
    {
        $commentaire = new Commentaires();

        $form = $this->createForm(CommentaireAdminType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && !$form->isEmpty() && $form->isValid()) {

            $doctrine = $this->getDoctrine();
            $entityManager = $doctrine->getManager();

            $entityManager->persist($commentaire);
            $entityManager->flush();

            $this->addFlash('success', 'Votre commentaire a bien été Ajouter!');

            return $this->redirectToRoute('home', []);

        }
        return $this->render('admin/commentaire_add.html.twig', [
            'formAjoutcomment' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/modifiercommentaire/{id}", name="admin_modifier_commentaire")
     */
    public function adminModifComment(Request $request, Commentaires $id)
    {
        $idUser = $this->getUser();

        $commentUserId = $id->getIdUtilisateur();
        $statusUserComment = $idUser->getStatus();

        if($idUser != $commentUserId && $statusUserComment == 'admin') {
            $this->addFlash('error', 'Tu ne peux pas Modifier les commentaires d\'un autre Admin!');
            return $this->redirectToRoute('commentaire_index',[]);
        }

        $form = $this->createForm(CommentaireAdminType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && !$form->isEmpty() && $form->isValid()) {

            $doctrine = $this->getDoctrine();
            $entityManager = $doctrine->getManager();

            $entityManager->persist($id);
            $entityManager->flush();

            $this->addFlash('success', 'Le commentaire a bien été modifié!');

            return $this->redirectToRoute('commentaire_index', []);

        }
        return $this->render('admin/commentaire_add.html.twig', [
            'formAjoutcomment' => $form->createView(),
        ]);
    }

}