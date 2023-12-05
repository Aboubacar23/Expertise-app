<?php

namespace App\Form;

use App\Entity\LMesureVibratoire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LmesureVibratoireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            //->add('lig')
            ->add('titre')
            ->add('n30')
            ->add('a30')
            ->add('b30')
            ->add('c30')
            ->add('d30')
            ->add('e30')
            ->add('f30')
            //->add('mesure_vibratoire')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LMesureVibratoire::class,
        ]);
    }
}
