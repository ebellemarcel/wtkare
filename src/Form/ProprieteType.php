<?php

namespace App\Form;

use App\Entity\Accessoire;
use App\Entity\Propriete;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProprieteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('type')
            ->add('prix')
            ->add('surface')
            ->add('chambres')
            ->add('adresse')
            ->add('ville')
            ->add('codepostal')
            ->add('latitude')
            ->add('longitude')
            ->add('date_creation', null, [
                'widget' => 'single_text',
            ])
            ->add('date_update', null, [
                'widget' => 'single_text',
            ])
            ->add('accessoires', EntityType::class, [
                'class' => Accessoire::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('userid', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Propriete::class,
        ]);
    }
}
