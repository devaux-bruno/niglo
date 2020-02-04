<?php
namespace App\Form;

use App\Entity\Partenaire;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartenaireEnleverType extends AbstractType
{
    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
        $formBuilder
            ->add('publier',EntityType::class, [
                'label' => 'Ne plus publier ce partenaire :',
                'class' => Partenaire::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.publier = :val')
                        ->setParameter('val', 1);

                },
                'choice_label' => 'nom',
                'attr' => [
                    'class' => "form-control"
                ],
                'required'=> true,
            ])
            ->add('save', SubmitType::class ,[
                'label' => 'Afficher',
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