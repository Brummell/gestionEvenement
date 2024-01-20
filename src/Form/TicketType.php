<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Ticket;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TicketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prix')
            ->add('type')
            ->add('nbrPlaceDispo')
            ->add('event', EntityType::class, [
                'class' => Event::class,
'choice_label' => 'id',
            ])
            ->add('user_ticker', EntityType::class, [
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
            'data_class' => Ticket::class,
        ]);
    }
}
