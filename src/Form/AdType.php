<?php

namespace App\Form;

use App\Entity\Ad;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class AdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',
                TextType::class,
                [
                    'label' => 'Titre',
                    'constraints' => new Length([
                        'min' => 2,
                        'max' => 30
                    ]),
                    'attr' => [
                        'placeholder' => 'Saisir le titre de l\'annonce'
                    ]
                ])
            ->add('text',
                TextareaType::class,
                [
                    'label' => 'Description de l\'annonce',
                    'constraints' => new Length([
                        'min' => 2,
                        'max' => 300
                    ]),
                    'attr' => [
                        'placeholder' => 'Décrire l\'annonce'
                    ]
                ])
            ->add('picture', FileType::class, [
                'label' => 'Photo de l\'annonce ( .jpg, .jpeg, .png )',
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,])
            ->add('postalCode',
                TextareaType::class,
                [
                    'label' => 'Code postal',
                    'constraints' => new Length([
                        'min' => 5,
                        'max' => 7
                    ]),
                    'attr' => [
                        'placeholder' => 'Votre code postal'
                    ]
                ])
            ->add('author', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'email',
                'expanded' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
