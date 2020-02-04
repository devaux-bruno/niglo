<?php


namespace App\Form;


use App\Entity\Partenaire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartenaireType extends AbstractType
{

    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
        $formBuilder
            ->add('nom',TextType::class, [
                'label' => 'Nom Partenaire :',
                'attr' => [
                    'class' => "form-control"
                ],
                'required'=>true,
            ])
            ->add('description', TextareaType ::class, [
                'label' => 'Description du Partenaire:',
                'attr' => [
                    'class' => "form-control"
                ],
                'required'=>true,
            ])
            ->add('photo', FileType::class, [
                'label' => ' Photo de partenaire :',
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
            'data_class' => Partenaire::class,
        ]);
    }
}