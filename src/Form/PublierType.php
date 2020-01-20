<?php


namespace App\Form;


use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
        $formBuilder
            ->add('publier',EntityType::class, [
                'label' => 'Paramètres affichés dans le menu :',
                'class' => Service::class,
                'multiple' => true,
                'expanded' => true,
                'empty_data' => '0',
                'choice_label' => 'Titre',
                'attr' => [
                    'class' => "form-control"
                ],
                'required'=>true,
            ])
            ->add('save', SubmitType::class ,[
                'label' => 'Valider',
                'attr' => [
                    'class' => "btn btn-primary mt-3"
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}