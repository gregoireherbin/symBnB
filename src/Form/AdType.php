<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AdType extends AbstractType
{   
    /**
     * Fonction qui permet de configurer les champs du formulaire
     */

    private function getConfiguration($label,$placeholder){
        
        return ['label' => $label,
                'attr' => [ 
                    'placeholder' => $placeholder
                ]
        ];

    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title',TextType::class,$this->getConfiguration("Titre","Tapez un titre pour votre annonce"))
            ->add('slug',TextType::class,$this->getConfiguration("Adresse web","Tapez une adresse web (automatique)"))
            ->add('coverImage',UrlType::class,$this->getConfiguration("Url de l'image principale","Donnez l'adresse d'une image"))
            ->add('introduction',TextType::class,$this->getConfiguration("Introduction","Donnez une descripation globale de l'annonce"))
            ->add('content',TextareaType::class,$this->getConfiguration("Description détaillée","Donnez une description détaillée de votre annonce qui donne vraiment envie !"))
            ->add('rooms',IntegerType::class,$this->getConfiguration("Nombre de chambres","Indiquez le nombre de chambres disponibles"))
            ->add('price', MoneyType::class,$this->getConfiguration("Prix pour une nuit","Indiquez le prix que vous souhaitez pour une nuit"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
