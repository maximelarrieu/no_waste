<?php

namespace App\Form;

use App\Entity\Commodity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CommodityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => "Titre du produit :"
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
            ->add('price', MoneyType::class, [
                'label' => "Prix du prduit :"
            ])
            ->add('remaining', IntegerType::class, [
                'label' => "Stock :"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commodity::class,
        ]);
    }
}
