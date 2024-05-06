<?php

namespace App\Form;

use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Entity\Categorie;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Product name :',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'name',
                ],
                'label_attr' => [
                    'class' => 'label'
                ],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'The name cant\'n be null.']),
                ],
            ])
            ->add('quantite', IntegerType::class, [
                'label' => 'Product quantity :',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'quantity',
                ],
                'label_attr' => [
                    'class' => 'label'
                ],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'The quantity must be full.']),
                ],
            ])
            ->add('date', DateType::class, [
                'label' => 'Date :',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'quantity',
                ],
                'label_attr' => [
                    'class' => 'label'
                ],
                'widget' => 'single_text',
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Fill the date please.']),
                ],
            ])
            ->add('prix_unitaire', NumberType::class, [
                'label' => 'Product cost :',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'cost',
                ],
                'label_attr' => [
                    'class' => 'label'
                ],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'The cost must be  under 5 digits and 2 .']),
                ],
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => 'nom',
                'placeholder' => 'Choose a category',
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new Assert\NotBlank(['message' => 'Please choose a category.']),
                ],
            ])
            ->add('image', FileType::class, [
                'label' => 'Upload photo',
                'mapped' => false,
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                ],
            ])
            ->add('labelle', TextareaType::class, [
                'label' => 'Enter the description of the article',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Enter the description',
                ],
            ]);
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
