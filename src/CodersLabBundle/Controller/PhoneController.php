<?php

namespace CodersLabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use CodersLabBundle\Entity\Persons;
use CodersLabBundle\Entity\Phones;

class PhoneController extends Controller {
    
    /**
     * @Route("/{id}/addPhone", requirements={"id"="\d+"})
     * @Template()
     */
    public function addPhoneAction(Request $req, $id) {
        $phone = new Phones();
        $rep = $this->getDoctrine()->getRepository('CodersLabBundle:Persons');
        $person = $rep->find($id);
        $form = $this->createFormBuilder($phone)
                ->add('phoneNumber','text', array('label' => 'NUMER TELEFONU: '))
                ->add('type', 'text', array('label' => 'TYP (np. służbowy, prywatny): '))
                ->add('save', 'submit', array('label' => 'Dodaj'))
                ->getForm();
        $form->handleRequest($req);
        
        
        if ($req->getMethod() === 'POST') {
            if ($form->isSubmitted() && $form->isValid()) {
                $newPhone = $form->getData();
                $newPhone->setPerson($person);

                $em = $this->getDoctrine()->getManager();
                $em->persist($newPhone);
                $em->flush();

                return $this->redirectToRoute('coderslab_person_showperson', array("id" => $id));
            }
        }
        return array('form' => $form->createView(), 'person' => $person); 
    }

            
    /**
     * @Route("/{id}/modifyPhone", requirements={"id"="\d+"})
     * @Template()
     */
    public function modifyPhoneAction(Request $req, $id) {
        $rep = $this->getDoctrine()->getRepository('CodersLabBundle:Phones');
        $phone = $rep->find($id);
        $person = $phone->getPerson();
        $idPerson = $person->getId();
        
        $form = $this->createFormBuilder($phone)
                ->add('phoneNumber','text', array('label' => 'NUMER TELEFONU: '))
                ->add('type', 'text', array('label' => 'TYP (np. służbowy, prywatny): '))
                ->add('save', 'submit', array('label' => 'Zapisz'))
                ->getForm();
        $form->handleRequest($req);
        
        if ($req->getMethod() === 'POST') {
            if ($form->isSubmitted() && $form->isValid()) {
                $phone = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($phone);
                $em->flush();

                return $this->redirectToRoute('coderslab_person_showperson', array("id" => $idPerson));
            }
        }
        return array('form' => $form->createView(), 'person' => $person);    
    }

    
    /**
     * @Route("/{id}/deletePhone", requirements={"id"="\d+"})
     * @Template()
     */
    public function deletePhoneAction($id) {
        $rep = $this->getDoctrine()->getRepository('CodersLabBundle:Phones');
        $phone = $rep->find($id);
        
        if (!$phone) {
            return array();
        }
        
        $person = $phone->getPerson();
        $idPerson = $person->getId();
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($phone);
        $em->flush();
        
        return $this->redirectToRoute('coderslab_person_showperson', array("id" => $idPerson));
    }

}
