<?php

namespace AppBundle\Controller;

use AppBundle\Entity\contact;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller
{

    /**
     * @Route("/post", name="view_post_route")
     */

    public function viewPostAction(Request $request){
        $contact = new contact;
        $form = $this->createFormBuilder($contact)
            ->add('fname', TextType::class, array('attr' =>  array('class' => 'form-control')))
            ->add('lname', TextType::class, array('attr' =>  array('class' => 'form-control')))
            ->add('telno', TextType::class, array('attr' =>  array('class' => 'form-control')))
            ->add('email', EmailType::class, array('attr' =>  array('class' => 'form-control')))
            ->add('save', SubmitType::class, array('attr' =>  array('class' => 'btn btn-primary')))

            ->getForm();
        $form -> handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $fname = $form['fname']->getData();
            $lname = $form['lname']->getData();
            $email = $form['email']->getData();
            $telno = $form['telno']->getData();

            $contact->setFname($fname);
            $contact->setLname($lname);
            $contact->setEmail($email);
            $contact->setTelno($telno);
            print_r($fname);
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
            return $this->redirectToRoute('view_contact_route');

        }



        return $this->render("pages/index.html.twig", [
            'form' => $form->createView()  ]);
    }


    /**
     * @Route("/post/viewcontact", name="view_contact_route")
     */
    public function viewContact(){
        $contacts = $this->getDoctrine()->getRepository('AppBundle:contact')->findAll();
        //print_r($contacts);
        //exit();
        return $this->render("pages/view.html.twig", ['contacts' => $contacts]);
    }


    /**
     * @Route("/post/addcontact", name="add_contact_route")
     */
    public function addContact(){

    }
}
