<?php

namespace App\Form;

use App\Entity\Adminstrateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
// use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
// use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Username :',
                'attr' => [
                    'class' => 'form-control border-success',
                    'placeholder' => 'Username',
                ],
                'label_attr' => [
                    'class' => 'label'
                ],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le nom ne peut pas être vide.']),  // Utilisation de NotBlank
                ],
                ])
            ->add('email', EmailType::class, [
                'label' => 'Email :',
                'attr' => [
                    'class' => 'form-control border-success',
                    'placeholder' => 'Email',
                ],
                'label_attr' => [
                    'class' => 'label'
                ],
                'constraints' => [
                    new Assert\Email(['message' => 'Entrez un email valide.']),
                    new Assert\NotBlank(['message' => 'L\'email ne peut pas être vide.']),
                ],
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Password :',
                'attr' => [
                    'class' => 'form-control border-success',
                    'placeholder' => 'Password',
                ],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Le mot de passe ne peut pas être vide.']),
                    new Assert\Length(['min' => 6, 'minMessage' => 'Le mot de passe doit avoir au moins 6 caractères.']),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adminstrateur::class,
        ]);
    }
}
