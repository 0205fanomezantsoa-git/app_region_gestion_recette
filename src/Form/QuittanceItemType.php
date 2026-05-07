<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Quittance;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuittanceItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numQuittance')
            ->add('dateUtilisation', DateType::class, [
                'widget' => 'single_text',
            ])
            ->add('nomClient')

            ->add('quantite', IntegerType::class, [
                'attr' => [
                    'class' => 'quantite-input form-control'
                ]
            ])

            ->add('produit', EntityType::class, [
                'class' => Produit::class,
                'choice_label' => 'nomProduit',

                // 🔥 on injecte le prixUnitaire dans le HTML
                'choice_attr' => function ($produit) {
                    return [
                        'data-prix' => $produit->getRistourne(),
                        'data-unite' => $produit->getUniteMesure()
                    ];
                },

                'attr' => [
                    'class' => 'produit-select form-select'
                ]
            ])

            ->add('montantTotal', null, [
                'attr' => [
                    'class' => 'total-input form-control',
                    'readonly' => true
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Quittance::class,
        ]);
    }
}