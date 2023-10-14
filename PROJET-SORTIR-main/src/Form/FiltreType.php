<?php

namespace App\Form;

use App\Entity\Campus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FiltreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('site',EntityType::class,[
                'class'=> Campus::class,
                'choice_label' => 'nom'
            ])
            ->add('textSearch',SearchType::class,[
                'label'=> 'Le nom de la sortie contient : ',
                'attr' => [ 'placeholder'=> 'Recherche'
                ]
            ])
            ->add('startDate', DateType::class,[
                'label'=> 'Entre le ',
                'widget' => 'single_text',
                'html5' => true
            ])
            ->add('endDate', DateType::class,[
                'label'=> 'et le ',
                'widget' => 'single_text',
                'html5' => true
            ])
            ->add('organizer', CheckboxType::class,[
                'label' => 'Sorties dont je suis l\'organisateur.rice'
            ])
            ->add('registered', CheckboxType::class,[
                'label' => 'Sorties auxquelles je suis inscrit.e'
            ])
            ->add('unregistered', CheckboxType::class,[
                'label' => 'Sorties auxquelles je ne suis pas inscrit.e'
            ])
            ->add('ended', CheckboxType::class,[
                'label' => 'Sorties passées'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
