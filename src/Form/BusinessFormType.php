<?php

namespace App\Form;

use App\Entity\Business;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class BusinessFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nom du commerce :"
            ])
            ->add('description', TextareaType::class, [
                'label' => "Description :"
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => "Image :",
                'required' => false,
                'allow_delete' => true,
                'delete_label' => "Supprimer l'image",
                'download_uri' => true,
                'download_label' => "Télécharger l'image",
                'image_uri' => true,
                'asset_helper' => true,
            ])
            ->add('address', TextType::class, [
                'label' => "Adresse postale :",
                'attr' => [
                    'placeholder' => "81 Quai des Chartrons, 33000 Bordeaux"
                ]
            ])
            ->add('phone_number', TextType::class, [
                'label' => 'Numéro de téléphone :',
                'attr' => [
                    'placeholder' => "06 00 00 00 00"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Business::class,
        ]);
    }
}
