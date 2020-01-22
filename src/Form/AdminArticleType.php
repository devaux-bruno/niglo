<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminArticleType extends AbstractType
{

    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
        $formBuilder
            ->add('titre',TextType::class, [
                'label' => 'Titre de l\'articles:',
                'attr' => [
                    'class' => "form-control mb-3"
                ],
                'required'=>true,
            ])
            ->add('imagePrincipale', FileType::class, [
                'label' => 'Votre Photo Principale :',
                'attr' => [
                    'class' => "form-control mb-3"
                ],
                'data_class' => null,
                'required'=>false,
            ])
            ->add('descriptionCourte', TextareaType::class,[
                'label' => 'Description courte',
                'attr' => [
                    'class' => "form-control mb-3"
                ],
                'required'=>false,
            ])
            ->add('texte', TextareaType::class,[
                'label' => 'Votre article',
                'attr' => [
                    'class' => "form-control mb-3"
                ],
                'required'=>false,
            ])
            ->add('idService', EntityType::class, [
                // looks for choices from this entity
                'class' => Service::class,
                // uses the User.username property as the visible option string
                'choice_label' => 'Titre',
                'label' => 'Quel service ?',
                'attr' => [
                    'class' => "form-control mb-3"
                ],
                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
                'required'=>true,
            ])
            ->add('save', SubmitType::class ,[
                'label' => 'Ajouter article',
                'attr' => [
                    'class' => "btn btn-primary mt-3 mb-3"
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}