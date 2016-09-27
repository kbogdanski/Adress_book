<?php

namespace CodersLabBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class EmailType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('email','text', array('label' => 'ADRES EMAIL: '))
            ->add('type', 'text', array('label' => 'TYP (np. służbowy, prywatny): '))
            ->add('save', 'submit', array('label' => 'Zapisz'));
    }
    
    public function getName() {
        
    }
}