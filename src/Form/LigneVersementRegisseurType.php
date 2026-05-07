<?php

namespace App\Form;

use App\Entity\LigneVersementRegisseurVersTresor;
use App\Entity\Regisseur;
use App\Entity\Tresor;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LigneVersementRegisseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('regisseur', EntityType::class, [
                'class' => Regisseur::class,
                'choice_label' => 'nom',
            ])
            ->add('tresor', EntityType::class, [
                'class' => Tresor::class,
                'choice_label' => 'nom',
            ])
            ->add('date', DateType::class, [
                'widget' => 'single_text',
                'format' => 'yyyy-MM-dd',])
            ->add('montant', NumberType::class, [
                'scale' => 2,
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Enregistrer',
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LigneVersementRegisseurVersTresor::class,
        ]);
    }
}
