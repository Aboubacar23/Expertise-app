<?php

namespace App\Form;

use DateTime;
use App\Entity\Intervention;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class InterventionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero_da', TextType::class, [
                'label' => "Numero DA"
            ])
            ->add('date_da', DateType::class, [
                'widget' => 'single_text',
                'data' => new DateTime()
            ])
            ->add('date_envoi', DateType::class, [
                'widget' => 'single_text',
                'data' => new DateTime()
            ])
            ->add('demandeur')
            ->add('prestataire')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Intervention::class,
        ]);
    }
}
