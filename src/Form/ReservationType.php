<?php

namespace App\Form;

use App\Entity\Allergene;
use App\Entity\Reservation;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateEtHeureArrivee', null, ['widget'=>'single_text'])
            ->add('nbCouverts')
            ->add('etat', ChoiceType::class,
                [
                'required' => false,
                'choices'=> [
                    'Confirmer' => Reservation::ETAT_CONFIRME,
                    'Annulé'=> Reservation::ETAT_ANNULE
                    ]
            ])
            ->add('tables')
            ->add('allergenes', EntityType::class, ['expanded'=> true, 'class'=> Allergene::class, 'multiple'=> true])
            ->add('commentaire')
            ->add('nomClient')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
