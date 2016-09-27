<?php

namespace CodersLabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use CodersLabBundle\Entity\Persons;

class PersonController extends Controller {
    
    /**
     * @Route("/index")
     * @Template()
     */
    public function indexAction() {
        return array();
    }

        /**
     * @Route("/new")
     * @Template()
     */
    public function newAction(Request $req) {
        $person = new Persons();
        $form = $this->createFormBuilder($person)
                ->add('name','text', array('label' => 'IMIĘ: '))
                ->add('surname', 'text', array('label' => 'NAZWISKO: '))
                ->add('description', 'textarea', array('label' => 'OPIS: '))
                ->add('photo', 'file', array('label' => 'FOTO: '))
                ->add('save', 'submit', array('label' => 'Zapisz'))
                ->getForm();
        $form->handleRequest($req);
        
        if ($req->getMethod() === 'POST') {
            if ($form->isSubmitted() && $form->isValid()) {
                $newPerson = $form->getData();

                $file = $newPerson->getPhoto();
                if (isset($file)) {
                    $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    $file->move('photos',$fileName);

                    $newPerson->setPhoto($fileName);
                } else {
                    $newPerson->setPhoto('brak.jpg');
                }
                $em = $this->getDoctrine()->getManager();
                $em->persist($newPerson);
                $em->flush();

                return $this->redirectToRoute('coderslab_person_showperson', array("id" => $newPerson->getId()));
            }
        }
        return array('form' => $form->createView());
    }
    
    
    /**
     * @Route("/")
     * @Template()
     */
    public function showAllAction() {
        $rep = $this->getDoctrine()->getRepository('CodersLabBundle:Persons');
        $persons = $rep->findAll();
        
        return array('persons' => $persons);
    }
    
    
    /**
     * @Route("/{id}", requirements={"id"="\d+"})
     * @Template()
     */
    public function showPersonAction($id) {
        $rep = $this->getDoctrine()->getRepository('CodersLabBundle:Persons');
        $person = $rep->find($id);
        
        if (!$person) {
            return new Response("<h3>Brak wyników wyszukiwania</h3>");
        }
        
        return array('person' => $person);
    }
    
    
    /**
     * @Route("/{letter}", requirements={"letter"="[A-Z]"})
     * @Template("CodersLabBundle:Person:showAll.html.twig")
     */
    public function showPersonOnLetter($letter) {
        $rep = $this->getDoctrine()->getRepository('CodersLabBundle:Persons');
        $persons = $rep->getPersonsLetter($letter);
        
        return array('persons' => $persons);
    }

    

    /**
     * @Route("/{id}/modify", requirements={"id"="\d+"})
     * @Template()
     */
    public function modifyPersonAction(Request $req, $id) {
        $rep = $this->getDoctrine()->getRepository('CodersLabBundle:Persons');
        $person = $rep->find($id);
        
        $form = $this->createFormBuilder($person)
                ->add('name','text', array('label' => 'IMIĘ: '))
                ->add('surname', 'text', array('label' => 'NAZWISKO: '))
                ->add('description', 'text', array('label' => 'OPIS: '))
                ->add('save', 'submit', array('label' => 'Zapisz'))
                ->getForm();
        $form->handleRequest($req);
        
        if ($req->getMethod() === 'POST') {
            if ($form->isSubmitted()) {
                $person = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($person);
                $em->flush();

                return new Response("<h3>Zapisano</h3>");
            }
        }
        
        return array('form' => $form->createView(), 'person' => $person);
    }
    
    
    /**
    * @Route("/{id}/modifyfoto", requirements={"id"="\d+"})
    * @Template()
    */
    public function modifyPersonFotoAction(Request $req, $id) {
        $rep = $this->getDoctrine()->getRepository('CodersLabBundle:Persons');
        $person = $rep->find($id);
        $file = $person->getPhoto();
        $person->setPhoto('');
        
        $form = $this->createFormBuilder($person)
                ->add('photo', 'file', array('label' => 'FOTO: '))
                ->add('save', 'submit', array('label' => 'Zapisz'))
                ->getForm();
        $form->handleRequest($req);
        
        if ($req->getMethod() === 'POST') {
            if ($form->isSubmitted() && $form->isValid()) {
                $person = $form->getData();
                $file = $person->getPhoto();
                
                if (isset($file)) {
                    $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    $file->move('photos',$fileName);

                    $person->setPhoto($fileName);
                } else {
                    $person->setPhoto('brak.jpg');
                }

                $em = $this->getDoctrine()->getManager();
                $em->persist($person);
                $em->flush();

                return new Response("<h3>Zapisano</h3>");
            }
        }
        
        return array('form' => $form->createView(), 'person' => $person, 'photo' => $file);
    }
    
    
    /**
     * @Route("/{id}/delete", requirements={"id"="\d+"})
     * @Template("CodersLabBundle:Person:showAll.html.twig")
     */
    public function deletePersonAction($id) {
        $rep = $this->getDoctrine()->getRepository('CodersLabBundle:Persons');
        $person = $rep->find($id);
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($person);
        $em->flush();
        
        $persons = $rep->findAll();
        
        return array('persons' => $persons);
    }
    
    
    /**
     * @Route("/searchSurname")
     * @Template("CodersLabBundle:Person:search.html.twig")
     */
    public function searchSurnameAction(Request $req) {
        $form = $this->createFormBuilder()
                ->add('searchString', 'text', array('label' => 'NAZWISKO: '))
                ->add('save', 'submit', array('label' => 'Szukaj'))
                ->getForm();
        $form->handleRequest($req);
        
        if ($req->getMethod() === 'POST') {
            if ($form->isSubmitted()) {
                $data = $form->getData();
                $string = $data['searchString'];

                $rep = $this->getDoctrine()->getRepository('CodersLabBundle:Persons');
                $persons = $rep->getPersonsForSurname($string);

                return $this->render('CodersLabBundle:Person:showAll.html.twig', array('persons' => $persons));
            }
        }
        return array('form' => $form->createView());
    }
    
    /**
     * @Route("/searchName")
     * @Template("CodersLabBundle:Person:search.html.twig")
     */
    public function searchNameAction(Request $req) {
        $form = $this->createFormBuilder()
                ->add('searchString', 'text', array('label' => 'IMIE: '))
                ->add('save', 'submit', array('label' => 'Szukaj'))
                ->getForm();
        $form->handleRequest($req);
        
        if ($req->getMethod() === 'POST') {
            if ($form->isSubmitted()) {
                $data = $form->getData();
                $string = $data['searchString'];

                $rep = $this->getDoctrine()->getRepository('CodersLabBundle:Persons');
                $persons = $rep->getPersonsForName($string);

                return $this->render('CodersLabBundle:Person:showAll.html.twig', array('persons' => $persons));
            }
        }
        return array('form' => $form->createView());
    }

}
