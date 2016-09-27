<?php

namespace CodersLabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use CodersLabBundle\Entity\Persons;
use CodersLabBundle\Entity\Adress;

class AdresController extends Controller {
    
    /**
     * @Route("/{id}/addAdres", requirements={"id"="\d+"})
     * @Template()
     */
    public function addAdresAction(Request $req, $id) {
        $adres = new Adress();
        $rep = $this->getDoctrine()->getRepository('CodersLabBundle:Persons');
        $person = $rep->find($id);
        $form = $this->createFormBuilder($adres)
                ->add('city','text', array('label' => 'MIASTO: '))
                ->add('street', 'text', array('label' => 'ULICA: '))
                ->add('houseNumber', 'text', array('label' => 'NUMER BUDYNKU: '))
                ->add('apartmentNumber', 'text', array('label' => 'NUMER MIESZKANIA: '))
                ->add('save', 'submit', array('label' => 'Dodaj'))
                ->getForm();
        $form->handleRequest($req);
        
        
        if ($req->getMethod() === 'POST') {
            if ($form->isSubmitted() && $form->isValid()) {
                $newAdres = $form->getData();
                $newAdres->setPerson($person);

                $em = $this->getDoctrine()->getManager();
                $em->persist($newAdres);
                $em->flush();

                return $this->redirectToRoute('coderslab_person_showperson', array("id" => $id));
            }
        }
        return array('form' => $form->createView(), 'person' => $person);   
    }

    
    /**
     * @Route("/{id}/modifyAdres", requirements={"id"="\d+"})
     * @Template()
     */
    public function modifyAdresAction(Request $req, $id) {
        $rep = $this->getDoctrine()->getRepository('CodersLabBundle:Adress');
        $adres = $rep->find($id);
        $person = $adres->getPerson();
        $idPerson = $person->getId();
        
        $form = $this->createFormBuilder($adres)
                ->add('city','text', array('label' => 'MIASTO: '))
                ->add('street', 'text', array('label' => 'ULICA: '))
                ->add('houseNumber', 'text', array('label' => 'NUMER BUDYNKU: '))
                ->add('apartmentNumber', 'text', array('label' => 'NUMER MIESZKANIA: '))
                ->add('save', 'submit', array('label' => 'Zapisz'))
                ->getForm();
        $form->handleRequest($req);
        
        if ($req->getMethod() === 'POST') {
            if ($form->isSubmitted() && $form->isValid()) {
                $adres = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($adres);
                $em->flush();

                return $this->redirectToRoute('coderslab_person_showperson', array("id" => $idPerson));
            }
        }
        return array('form' => $form->createView(), 'person' => $person);   
    }

    
    /**
     * @Route("/{id}/deleteAdres", requirements={"id"="\d+"})
     * @Template()
     */
    public function deleteAdresAction($id) {
        $rep = $this->getDoctrine()->getRepository('CodersLabBundle:Adress');
        $adres = $rep->find($id);
        
        if (!$adres) {
            return array();
        }
        
        $person = $adres->getPerson();
        $idPerson = $person->getId();
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($adres);
        $em->flush();
        
        return $this->redirectToRoute('coderslab_person_showperson', array("id" => $idPerson));
    }

}
