<?php

namespace App\Form;

use App\Entity\Agent;
use App\Entity\Localite;
use App\Entity\Regisseur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AgentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('telephone')
            ->add('portefeuille')
            ->add('regisseur', EntityType::class, [
                'class' => Regisseur::class,
                'choice_label' => 'id',
            ])
            ->add('localite', EntityType::class, [
                'class' => Localite::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Agent::class,
        ]);
    }
}
