<?php

namespace App\Form;

use App\Entity\MesureVibratoireEssais;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class MesureVibratoireEssaisType extends AbstractType
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
            ->add('n25')
            ->add('a10')
            ->add('a25')
            ->add('b10')
            ->add('b25')
            ->add('c10')
            ->add('c25')
            ->add('d10')
            ->add('d25')
            ->add('e10')
            ->add('e25')
            ->add('f10')
            ->add('f25')
            ->add('n35')
            ->add('a35')
            ->add('b35')
            ->add('c35')
            ->add('d35')
            ->add('e35')
            ->add('f35')
            ->add('n45')
            ->add('a45')
            ->add('b45')
            ->add('c45')
            ->add('d45')
            ->add('e45')
            ->add('f45')
            ->add('titre35')
            ->add('titre45')
            ->add('obervation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MesureVibratoireEssais::class,
        ]);
    }
}
