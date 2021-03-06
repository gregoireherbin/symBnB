<?php

namespace App\Form;

use App\Entity\Ad;
use App\Form\ImageType;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AdType extends ApplicationType
{   
 

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class,$this->getConfiguration("Titre","Tapez un titre pour votre annonce"))
            ->add('slug',TextType::class,$this->getConfiguration("Adresse web","Tapez une adresse web (automatique)",['required' => false]))
            ->add('coverImage',UrlType::class,$this->getConfiguration("Url de l'image principale","Donnez l'adresse d'une image"))
            ->add('introduction',TextType::class,$this->getConfiguration("Introduction","Donnez une descripation globale de l'annonce"))
            ->add('content',TextareaType::class,$this->getConfiguration("Description détaillée","Donnez une description détaillée de votre annonce qui donne vraiment envie !"))
            ->add('rooms',IntegerType::class,$this->getConfiguration("Nombre de chambres","Indiquez le nombre de chambres disponibles"))
            ->add('price', MoneyType::class,$this->getConfiguration("Prix pour une nuit","Indiquez le prix que vous souhaitez pour une nuit"))
            ->add('images',CollectionType::class,['entry_type'=>ImageType::class,'allow_add'=>true,'allow_delete'=>true])
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
