<?php

namespace CodersLabBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class PhoneType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('phoneNumber','text', array('label' => 'NUMER TELEFONU: '))
            ->add('type', 'text', array('label' => 'TYP (np. służbowy, prywatny): '))
            ->add('save', 'submit', array('label' => 'Zapisz'));
    }
    
    public function getName() {
        
    }
}