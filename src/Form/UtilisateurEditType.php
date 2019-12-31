<?php


namespace App\Form;


use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {


        $formBuilder
            ->add('pseudo',TextType::class, [
                'label' => 'Votre Pseudo :',
                'attr' => [
                    'class' => "form-control"
                ],
            ])
            ->add('nom', TextType::class,[
                'label' => 'Votre Nom :',
                'attr' => [
                    'class' => "form-control"
                ],
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Votre Prénom : ',
                'attr' => [
                    'class' => "form-control"
                ],
            ])
            ->add('naissance', BirthdayType::class, [
                'label' => 'Votre date de naissance :',
                'empty_data' => '',
                'widget' => 'choice',
                'years' => range(1945,2019),
                // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5' => false,
                // adds a class that can be selected in JavaScript
                //'attr' => ['class' => 'js-datepicker','form-control'],
                //'data_class' => null,
                //'required' => false,
            ])
            ->add('ville', TextType::class,[
                'label' => 'Votre ville :',
                'attr' => [
                    'class' => "form-control"
                ],
                'required'=>false,
            ])
            ->add('sexe', ChoiceType::class,[
                'label' => 'Votre sexe :',
                'choices'  => [
                    'Homme' => '0',
                    'Femme' => '1',
                ],
                'attr' => [
                    'class' => "form-control"
                ],

            ])
            ->add('photo', FileType::class, [
                'label' => 'Votre Photo de profil :',
                'attr' => [
                    'class' => "form-control"
                ],
                'data_class' => null,
                'required'=>false,
            ])
            ->add('save', SubmitType::class ,[
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => "btn btn-primary mt-3"
                ],
            ]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}