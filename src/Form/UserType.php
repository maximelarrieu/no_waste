<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom :'
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom :'
            ])
            ->add('email', TextType::class, [
                'label' => 'Email :'
            ])
            ->add('avatarFile', VichImageType::class, [
                'label' => 'Image de profil :',
                'required' => false,
                'allow_delete' => true,
                'delete_label' => "Supprimer l'image",
                'download_uri' => true,
                'download_label' => "Télécharger l'image",
                'image_uri' => true,
                'asset_helper' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
