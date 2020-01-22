<?php


namespace App\Form;


use App\Entity\Organisateur;

use App\Entity\Service;
use App\Entity\Utilisateur;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AssociationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $formBuilder, array $options)
    {
        $formBuilder
            ->add('idUtilisateur',EntityType::class, [
                'label' => 'Qui ?',
                'class' => Utilisateur::class,
                'choice_label' => 'pseudo',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->andWhere('u.status = :val')
                        ->setParameter('val', 'admin')
                        ->orderBy('u.pseudo', 'ASC');

                },
                'attr' => [
                    'class' => "form-control"
                ],
                'required'=> true,
            ])
            ->add('idService', EntityType ::class, [
                'label' => 'Quelle service ?',
                'class' => Service::class,
                'choice_label' => 'Titre',
                'attr' => [
                    'class' => "form-control"
                ],
                'required'=> true,
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
            'data_class' => Organisateur::class,
        ]);
    }
}
