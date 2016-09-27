<?php

namespace CodersLabBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use CodersLabBundle\Entity\Groups;

class GroupController extends Controller {
    
    /**
     * @Route("/add")
     * @Template()
     */
    public function addAction(Request $req) {
        $group = new Groups();
        $form = $this->createFormBuilder($group)
                ->add('title','text', array('label' => 'NAZWA GRUPY: '))
                ->add('description', 'textarea', array('label' => 'OPIS: '))
                ->add('save', 'submit', array('label' => 'Zapisz'))
                ->getForm();
        $form->handleRequest($req);
        
        if ($req->getMethod() === 'POST') {
            if ($form->isSubmitted() && $form->isValid()) {
                $newGroup = $form->getData();

                $em = $this->getDoctrine()->getManager();
                $em->persist($newGroup);
                $em->flush();

                return $this->redirectToRoute('coderslab_group_group');
            }
        }
        return array('form' => $form->createView());  
    }

            
    /**
     * @Route("/group")
     * @Template()
     */
    public function groupAction() {
        $rep = $this->getDoctrine()->getRepository('CodersLabBundle:Groups');
        $groups = $rep->findAll();
        
        return array('groups' => $groups); 
    }
    
    
    /**
     * @Route("/group/{id}", requirements={"id"="\d+"})
     * @Template()
     */
    public function showGroupAction($id) {
        $rep = $this->getDoctrine()->getRepository('CodersLabBundle:Groups');
        $group = $rep->find($id);
        
        if (!$group) {
            return new Response("<h3>Brak wyników wyszukiwania</h3>");
        }
        
        return array('group' => $group);
    }

    
    /**
     * @Route("/{id}/deleteGroup", requirements={"id"="\d+"})
     * @Template("CodersLabBundle:Group:group.html.twig")
     */
    public function deleteGroupAction($id) {
        $rep = $this->getDoctrine()->getRepository('CodersLabBundle:Groups');
        $group = $rep->find($id);
        
        $em = $this->getDoctrine()->getManager();
        $em->remove($group);
        $em->flush();
        
        $groups = $rep->findAll();
        
        return array('groups' => $groups);  
        
    }

            
    /**
     * @Route("/{id}/addPersonToGroup", requirements={"id"="\d+"})
     * @Template()
     */
    public function addPersonToGroupAction(Request $req, $id) {
        $rep = $this->getDoctrine()->getRepository('CodersLabBundle:Groups');
        $group = $rep->find($id);
        
        $form = $this->createFormBuilder()
                ->add('person','entity', array('class' => 'CodersLabBundle:Persons', 'choice_label' => 'surnameName', 'label' => 'WYBIERZ KONTAKT:', 'choice_name' => 'id'))
                ->add('save', 'submit', array('label' => 'Dodaj'))
                ->getForm();
        $form->handleRequest($req);
        
        if ($req->getMethod() === 'POST') {
            if ($form->isSubmitted()) {
                $data = $form->getData();
                $personInGroup = $group->getPersons();
                
                $flag = 1;
                foreach ($personInGroup as $person) {
                    if ($person->getId() == $data['person']->getId()) {
                        $flag = 0;
                        break;
                    }
                }
                
                if ($flag) {
                    $data['person']->addGroup($group);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($data['person']);
                    $em->flush();
                    
                    return $this->redirectToRoute('coderslab_group_showgroup', array("id" => $id));
                }
                return $this->render('CodersLabBundle:Group:showGroup.html.twig', array('id' => $id, 'status' => 'Kontakt już był w tej grupie', 'group' => $group));
            }
        }
        return array('form' => $form->createView(), 'group' => $group);  
    }
    
    
    /**
     * @Route("/{id}/addGroupToPerson", requirements={"id"="\d+"})
     * @Template()
     */
    public function addGroupToPersonAction(Request $req, $id) {
        $rep = $this->getDoctrine()->getRepository('CodersLabBundle:Persons');
        $person = $rep->find($id);
        
        $form = $this->createFormBuilder()
                ->add('group','entity', array('class' => 'CodersLabBundle:Groups', 'choice_label' => 'title', 'label' => 'WYBIERZ GRUPĘ:'))
                ->add('save', 'submit', array('label' => 'Dodaj'))
                ->getForm();
        $form->handleRequest($req);
        
        if ($req->getMethod() === 'POST') {
            if ($form->isSubmitted()) {
                $data = $form->getData();
                $personInGroup = $data['group']->getPersons();
                
                $flag = 1;
                foreach ($personInGroup as $value) {
                    if ($value->getId() == $person->getId()) {
                        $flag = 0;
                        break;
                    }
                }
                
                if ($flag) {
                    $person->addGroup($data['group']);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($person);
                    $em->flush();
                    
                    return $this->redirectToRoute('coderslab_person_showperson', array('id' => $id));
                }
                return $this->render('CodersLabBundle:Group:showGroup.html.twig', array('id' => $id, 'status' => 'Kontakt już był w tej grupie', 'group' => $data['group']));
            }
        }
        return array('form' => $form->createView(), 'person' => $person);
    }

    
    /**
     * @Route("/{idGroup}/{idPerson}/deletePersonForGroup", requirements={"idGroup"="\d+", "idPerson"="\d+"})
     * @Template()
     */
    public function deletePersonForGroupAction($idGroup, $idPerson) {

        $repPerson = $this->getDoctrine()->getRepository('CodersLabBundle:Persons');
        $person = $repPerson->find($idPerson);
        
        $repGroup = $this->getDoctrine()->getRepository('CodersLabBundle:Groups');
        $group = $repGroup->find($idGroup);
        
        $person->removeGroup($group);
        
        $em = $this->getDoctrine()->getManager();
        $em->persist($person);
        $em->flush();
        
        return $this->redirectToRoute('coderslab_group_showgroup', array("id" => $idGroup));
    }
}
