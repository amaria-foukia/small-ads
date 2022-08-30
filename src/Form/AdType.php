<?php

namespace App\Form;

use App\Entity\Ad;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('text')
            ->add('picture', FileType::class, [
                'label' => 'Photo ou Avatar ( .jpg, .jpeg, .png )',
                // unmapped means that this field is not associated to any entity property
                'mapped' => false,
                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,])
            ->add('postalCode')
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

/*->add('picture', FileType::class, [
    'label' => 'Photo ou Avatar ( .jpg, .jpeg, .png )',
    // unmapped means that this field is not associated to any entity property
    'mapped' => false,
    // make it optional so you don't have to re-upload the PDF file
    // every time you edit the Product details
    'required' => false,])*/
