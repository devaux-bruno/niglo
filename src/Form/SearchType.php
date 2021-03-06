<?php


namespace App\Form;


use App\Entity\Articles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {

        $formBuilder
            ->add('term',TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => "form-control mr-sm-2",
                    'aria-label' => "Search",
                    'placeholder' => 'Recherche par mots clés...',
                ],
                'mapped' => false,
            ])
            ->add('save', SubmitType::class ,[
                'label' => 'Ok',
                'attr' => [
                    'class' => "btn btn-outline-primary my-2 my-sm-0"
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