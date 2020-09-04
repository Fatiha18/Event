<?php

namespace App\Form;

use App\Entity\Events;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;


class CreateEventFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Nom manquant.']),
                    new Length([
                        'max' => 100,
                        'maxMessage' => 'Le nom ne peut contenir plus de {{ limit }} caractères.'
                    ])
                ]
            ])
            ->add('Description', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Description manquante.']),
                    new Length([
                        'min' => 20,
                        'minMessage' => 'La description doit contenir au moins {{ limit }} caractères.',
                        'max' => 200,
                        'maxMessage' => 'La description ne peut contenir plus de {{ limit }} caractères.'
                    ])
                   
                ]
            ])
            ->add('Lieu', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Lieu manquant.']),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Le lieu doit contenir au moins {{ limit }} caractères.',
                        'max' => 50,
                        'maxMessage' => 'Le lieu ne peut contenir plus de {{ limit }} caractères.'
                    ])
                   
                ]
            ])

            ->add('Date', DateType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Date manquant.']),
                ]
            ])


           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Events::class,
        ]);
    }
}
