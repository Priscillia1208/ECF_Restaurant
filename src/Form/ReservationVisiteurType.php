<?php

namespace App\Form;

use App\Entity\Allergene;
use App\Entity\Reservation;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationVisiteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateEtHeureArrivee', DateType::class, ['widget'=>'single_text', 'label'=> 'Date d\'arrivée: '])
            ->add('commentaire', TextareaType::class, ['label'=> 'Commentaires:'])
            ->add('nomClient', TextType::class, ['label'=> 'Votre nom:'])
            ->add('nbCouverts', NumberType::class, ['label' => 'Nombre de couverts:'])
            ->add('allergenes', EntityType::class, ['expanded'=> true, 'multiple'=> true, 'class'=> Allergene::class, 'label'=> 'Allergies:'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }
}
