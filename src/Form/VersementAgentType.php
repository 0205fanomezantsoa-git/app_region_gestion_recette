<?php

namespace App\Form;

use App\Entity\Agent;
use App\Entity\LigneVersementAgentVersRegisseur;
use App\Entity\Regisseur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VersementAgentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
             ->add('agent', EntityType::class, [
                'class' => Agent::class,
                'choice_label' => 'nom',
            ])
            ->add('regisseur', EntityType::class, [
                'class' => Regisseur::class,
                'choice_label' => 'nom',
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',])
            ->add('typeVersement', ChoiceType::class, [
                'choices' => [
                'Mobile money' => 'Mobile money',
                'Espèces' => 'Espèces',
                                                            ],
                'placeholder' => 'Choisir le type de versement',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
            ])
            ->add('montant', NumberType::class, [
                'scale' => 2,
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LigneVersementAgentVersRegisseur::class,
        ]);
    }
}
