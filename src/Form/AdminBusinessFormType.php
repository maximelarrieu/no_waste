<?php

namespace App\Form;

use App\Entity\Business;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AdminBusinessFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => "Nom du commerce :"
            ])
            ->add('user', EntityType::class, [
                'label' => 'Commerçant :',
                'placeholder' => 'Propriétaire du commerce',
                'class' => User::class,
                'choice_label' => 'lastname',
                'query_builder' => function(UserRepository $repository) {
                    return $repository->createAlphabeticalQueryBuilder();
                }
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
