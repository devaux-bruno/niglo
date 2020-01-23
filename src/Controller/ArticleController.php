<?php


namespace App\Controller;


use App\Entity\Articles;
use App\Form\AdminArticleType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route("admin/articles", name="article_index")
     */
    public function indexArticles(Request $request, PaginatorInterface $paginator)
    {
        $doctrine = $this->getDoctrine();

        $articleRepository = $doctrine->getRepository(Articles::class);
        $resultatedit= $articleRepository->findAll();

        $pagination = $paginator->paginate(
            $resultatedit, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('admin/index_article.html.twig', [
            'resultatedit' => $resultatedit,
            'pagination' => $pagination,
        ]);
    }

    /**
     * @Route("admin/addArticle", name="article_add")
     */
    public function adminAddArticle(Request $request)
    {
        $article = new Articles();
        $use = $this->getUser();
        $user = $this->getUser()->getId();
        $form = $this->createForm(AdminArticleType::Class, $article, []);
        $form->handleRequest($request);

        if( $form->isSubmitted() && !$form->isEmpty() && $form->isValid())
        {
            if($article->getImagePrincipale() != '' || $article->getImagePrincipale() != null ){
                //ajout d'une photo
                $file = $form->get('imagePrincipale')->getData();
                $fileName = $this->generateUniqueFileName().'.'.$file->guessExtension();
                try {
                    $file->move(
                        $this->getParameter('article_pictures_directory'),
                        $fileName
                    );
                } catch (FileException $e) {
                    $this->addFlash('error', 'Un problème est survenue sur la photo de l\'article lors de l\'enregistrement!');

                    return $this->redirectToRoute('article_add', []);
                }
            }
            else{
                $fileName = '';
            }

            $article->setImagePrincipale($fileName);
            $article->setDatePublication(new \DateTime()) ;
            $article->setIdUtilisateur($use);
            $doctrine = $this->getDoctrine();
            $entityManager = $doctrine->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            $this->addFlash('success', 'l\'article a bien été enregistré et publié!');

            return $this->redirectToRoute('home',[]);

        }
        return $this->render('admin/article_admin_add.html.twig',[
            'formAjoutarticle' => $form->createView(),
        ]);
    }


    /**
     * @Route("article/{id}", name="article")
     */
    public function readArticle(Articles $id)
    {
        $doctrine = $this->getDoctrine();
        $userRepository = $doctrine->getRepository(Articles::class);
        $resultatArticle= $userRepository->find($id);

        return $this->render('home/article.html.twig', [
            'resultatArticle' => $resultatArticle,
        ]);
    }

    /**
     * @Route("admin/article-delete/{id}", name="article_admin_delete")
     */
    public function deleteArticle(Articles $id)
    {

        $idUser = $this->getUser()->getId();
        $idStatus = $this->getUser()->getStatus();
        $numIdUser = $id->getIdUtilisateur()->getId();

        if($idUser != $numIdUser || $idStatus != 'superadmin' ) {
            $this->addFlash('error', 'Vous ne pouvez pas supprimer que vos articles');
            return $this->redirectToRoute('home',[]);
        }

        $entityManager = $this->getDoctrine()->getManager();
        $article = $entityManager->getRepository(Articles::class)->find($id);

        if (!$article) {
            throw $this->createNotFoundException(
                'Il n \'y a pas de d\'article avec l\'ID n°'.$article.'!'
            );
        }

        $articlePicture = $entityManager->getRepository(Articles::class)->find($id)->getImagePrincipale();
        if( !empty($articlePicture))
        {
            //suppression de l'ancienne photo
            $fichierSupp = $this->getParameter('article_pictures_directory');
            unlink($fichierSupp . $articlePicture);
            $fs = new Filesystem();
            $fs->remove($fichierSupp.$id->getImagePrincipale());
        }

        $entityManager->remove($article);
        $entityManager->flush();

        $this->addFlash('success', 'L\'article a bien été supprimé!');

        return $this->redirectToRoute('article_index',[]);
    }



    /**
     * @Route("admin/Article-edit/{id}", name="admin_article_edit")
     */
    public function adminArticleEdit(Request $request, Articles $id)
    {

        $idUser = $this->getUser()->getId();
        $idStatus = $this->getUser()->getStatus();
        $numIdUser = $id->getIdUtilisateur()->getId();

        if($idUser != $numIdUser || $idStatus != 'superadmin' ) {
            $this->addFlash('error', 'Vous ne pouvez pas modifier que vos articles');
            return $this->redirectToRoute('home',[]);
        }

        $doctrine = $this->getDoctrine();
        $entityManager = $doctrine->getManager();
        $articlePicture = $entityManager->getRepository(Articles::class)->find($id)->getImagePrincipale();

        $form = $this->createForm(AdminArticleType::Class, $id, []);
        $form->handleRequest($request);

        if( $form->isSubmitted() && !$form->isEmpty() && $form->isValid())
        {
            if($id->getImagePrincipale() != '' || $id->getImagePrincipale() != null ) {
                if (!empty($articlePicture)) {
                    $file = $form->get('imagePrincipale')->getData();
                    if (!empty($file)) {
                        //suppression de l'ancienne photo
                        $fichierSupp = $this->getParameter('article_pictures_directory');
                        unlink($fichierSupp . $articlePicture);
                        $fs = new Filesystem();
                        $fs->remove($fichierSupp . $id->getImagePrincipale());

                        //update de la nouvelle photo
                        $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                        try {
                            $file->move(
                                $this->getParameter('article_pictures_directory'),
                                $fileName
                            );
                        } catch (FileException $e) {
                            $this->addFlash('error', 'Un problème est survenue sur la photo de l\'article lors de la modification!');

                            return $this->redirectToRoute('admin_article_edit', []);
                        }
                    } else {
                        $fileName = $articlePicture;
                    }
                } else {
                    $file = $form->get('imagePrincipale')->getData();
                    if (!empty($file)) {
                        //ajout d'une photo
                        $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();
                        try {
                            $file->move(
                                $this->getParameter('article_pictures_directory'),
                                $fileName
                            );
                        } catch (FileException $e) {
                            $this->addFlash('error', 'Un problème est survenue sur la photo lors de l\'enregistrement!');

                            return $this->redirectToRoute('admin_article_edit', []);
                        }
                    } else {
                        $fileName = $articlePicture;
                    }
                }
            }
            else
            {
                $fileName= $articlePicture;
            }

            $id->setImagePrincipale($fileName);
            $doctrine = $this->getDoctrine();
            $entityManager = $doctrine->getManager();

            $entityManager->persist($id);
            $entityManager->flush();

            $this->addFlash('success', 'l\'article a bien été modifier!');

            return $this->redirectToRoute('article_index',[]);
        }
        return $this->render('admin/article_admin_add.html.twig',[
            'formAjoutarticle' => $form->createView(),
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