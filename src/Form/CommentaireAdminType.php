<?php


namespace App\Form;

use App\Entity\Articles;
use App\Entity\Commentaires;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentaireAdminType  extends AbstractType
{
    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
        $formBuilder
            ->add('commentaire',TextareaType::Class, [
                'label' => 'Votre commentaire:',
                'attr' => [
                    'class' => "form-control mb-3"
                ],
                'required'=>true,
            ])
            ->add('idArticle',EntityType::Class, [
                'label' => 'Votre commentaire:',
                'class' => Articles::class,
                'choice_label' => 'Titre',
                'attr' => [
                    'class' => "form-control mb-3"
                ],
                'required'=>true,
            ])
            ->add('idUtilisateur',EntityType::Class, [
                'label' => 'Votre commentaire:',
                'choice_label' => 'pseudo',
                'class' => Utilisateur::class,
                'attr' => [
                    'class' => "form-control mb-3"
                ],
                'required'=>true,
            ])
            ->add('save', SubmitType::class ,[
                'label' => 'Poster',
                'attr' => [
                    'class' => "btn btn-primary mb-3"
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commentaires::class,
        ]);
    }
}