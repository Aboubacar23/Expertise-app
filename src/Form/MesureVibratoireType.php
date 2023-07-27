<?php

namespace App\Form;

use App\Entity\MesureVibratoire;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MesureVibratoireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('position', ChoiceType::class, [
                'choices' => [
                    'Verticale' => 'Verticale',
                    'Horizontale' => 'Horizontale'
                ]
            ])
            ->add('montage', ChoiceType::class, [
                'choices' => [
                    'Souple' => 'Souple',
                    'Bridé' => 'Bridé'
                ]
            ])
            ->add('accouplement', ChoiceType::class, [
                'choices' => [
                    'Oui' => 'Oui',
                    'Non' => 'Non'
                ]
            ])
            ->add('clavette', ChoiceType::class, [
                'choices' => [
                    'Entière' => 'Entière',
                    'Demie' => 'Demie',
                    'Sans' => 'Sans'
                ]
            ])
            ->add('commentaire')
            ->add('n10')
            ->add('n30')
            ->add('n25')
            ->add('a10')
            ->add('a30')
            ->add('a25')
            ->add('b10')
            ->add('b30')
            ->add('b25')
            ->add('c10')
            ->add('c30')
            ->add('c25')
            ->add('d10')
            ->add('d30')
            ->add('d25')
            ->add('e10')
            ->add('e30')
            ->add('e25')
            ->add('f10')
            ->add('f30')
            ->add('f25')
            ->add('obervation')
            ->add('titre')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MesureVibratoire::class,
        ]);
    }
}
