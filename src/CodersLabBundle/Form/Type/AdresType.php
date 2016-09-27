<?php

namespace CodersLabBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AdresType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('city','text', array('label' => 'MIASTO: '))
            ->add('street', 'text', array('label' => 'ULICA: '))
            ->add('houseNumber', 'text', array('label' => 'NUMER BUDYNKU: '))
            ->add('apartmentNumber', 'text', array('label' => 'NUMER MIESZKANIA: '))
            ->add('save', 'submit', array('label' => 'Zapisz'));
    }
    
    public function getName() {
        
    }
}