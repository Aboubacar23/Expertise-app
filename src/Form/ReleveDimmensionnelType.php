<?php

namespace App\Form;

use App\Entity\ReleveDimmensionnel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ReleveDimmensionnelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('designation')
            ->add('cote_attendue')
            ->add('tolerance')
            ->add('cote_relevee')
            ->add('observation')
            ->add('conformite', ChoiceType::class, [
                'choices' => [
                    'Conforme' => 'Conforme',
                    'Non conforme' => 'Non conforme'
                ]
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Côté accoupplement' => 'Côté accoupplement',
                    'Côté opposé accoupplement' => 'Côté opposé accoupplement',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ReleveDimmensionnel::class,
        ]);
    }
}
