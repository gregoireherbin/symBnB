<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;

class ApplicationType extends AbstractType {

    /**
    * Fonction qui permet de configurer les champs du formulaire
    */

    protected function getConfiguration($label,$placeholder,$options=[]){
        
        return array_merge (['label' => $label,
                'attr' => [ 
                    'placeholder' => $placeholder,
                ]
                
                
                ],$options);

    }


}