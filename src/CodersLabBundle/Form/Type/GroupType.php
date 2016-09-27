<?php

namespace CodersLabBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class GroupType extends AbstractType {
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title','text', array('label' => 'NAZWA GRUPY: '))
            ->add('description', 'textarea', array('label' => 'OPIS: '))
            ->add('save', 'submit', array('label' => 'Zapisz'));
    }
    
    public function getName() {
        
    }
}