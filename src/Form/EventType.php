<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Organizer;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('date')
            ->add('date_fin')
            ->add('lieu')
            ->add('description')
            ->add('organizer', EntityType::class, [
                'class' => Organizer::class,
'choice_label' => 'id',
            ])
            ->add('users', EntityType::class, [
                'class' => User::class,
'choice_label' => 'id',
'multiple' => true,
'required'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
