<?php

namespace CodersLabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use CodersLabBundle\Entity\Emails;
use CodersLabBundle\Form\Type\EmailType; 

class EmailController extends Controller 
{
    /**
     * @Route("/{id}/addEmail", requirements={"id"="\d+"})
     * @Template()
     */
    public function addEmailAction(Request $req, $id) {
        $email = new Emails();
        $rep = $this->getDoctrine()->getRepository('CodersLabBundle:Persons');
        $person = $rep->find($id);
        $form = $this->createForm(new EmailType(), $email);
        $form->handleRequest($req);
        
        
        if ($req->getMethod() === 'POST') {
            if ($form->isSubmitted() && $form->isValid()) {
                $newEmail = $form->getData();
                $newEmail->setPerson($person);

                $em = $this->getDoctrine()->getManager();
                $em->persist($newEmail);
                $em->flush();

                return $this->redirectToRoute('coderslab_person_showperson', array("id" => $id));
            }
        }
        return array('form' => $form->createView(), 'person' => $person);   
    }

    
    /**
     * @Route("/{id}/modifyEmail", requirements={"id"="\d+"})
     * @Template()
     */
    public function modifyEmailAction(Request $req, $id) {
        $rep = $this->getDoctrine()->getRepository('CodersLabBundle:Emails');
        $email = $rep->find($id);
        $person = $email->getPerson();
        $idPerson = $person->getId();
        
        $form = $this->createForm(new EmailType(), $email);
        $form->handleRequest($req);
        
        if ($req->getMethod() === 'POST') {
            if ($form->isSubmitted() && $form->isValid()) {
                $email = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($email);
                $em->flush();

                return $this->redirectToRoute('coderslab_person_showperson', array("id" => $idPerson));
            }
        }
        return array('form' => $form->createView(), 'person' => $person);   
    }

    
    /**
     * @Route("/{id}/deleteEmail", requirements={"id"="\d+"})
     * @Template()
     */
    public function deleteEmailAction($id) {
        $rep = $this->getDoctrine()->getRepository('CodersLabBundle:Emails');
        $email = $rep->find($id);
        
        if (!$email) {
            return array();
        }
        
        $person = $email->getPerson();
        $idPerson = $person->getId();
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($email);
        $em->flush();
        
        return $this->redirectToRoute('coderslab_person_showperson', array("id" => $idPerson)); 
    }

}
