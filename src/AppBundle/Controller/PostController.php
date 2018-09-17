<?php

namespace AppBundle\Controller;

use AppBundle\Entity\contact;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


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
            $this->addFlash('message','Contact Succcessfully Added!');
            return $this->redirectToRoute('view_contact_route');

        }



        return $this->render("pages/index.html.twig", [
            'form' => $form->createView()  ]);
    }



    /**
     * @Route("/api/insertdata", name="insert_post_route")
     */

    public function insertDataAction(Request $request){
        $data = json_decode($request->getContent(), true);

        $contact = new contact;



        $fname = $data['fname'];
        $lname = $data['lname'];
        $email = $data['email'];
        $telno = $data['telno'];

        $contact->setFname($fname);
        $contact->setLname($lname);
        $contact->setEmail($email);
        $contact->setTelno($telno);

        $em = $this->getDoctrine()->getManager();
        $em->persist($contact);
        $em->flush();

        $response = new Response();
        return $response;

    }
    /**
     * @Route("/api/updatedata", name="update_post_route")
     */

    public function updateDataAction(Request $request){
        $data = json_decode($request->getContent(), true);




        $id = $data['id'];
        $fname = $data['fname'];
        $lname = $data['lname'];
        $email = $data['email'];
        $telno = $data['telno'];

        $em = $this->getDoctrine()->getManager();
        $contact = $em->getRepository('AppBundle:contact')->find($id);

        $contact->setFname($fname);
        $contact->setLname($lname);
        $contact->setEmail($email);
        $contact->setTelno($telno);

        $em->flush();

        $response = new Response();
        return $response;


    }

    /**
     * @Route("/api/deletedata", name="delete_post_route")
     */

    public function deleteDataAction(Request $request){

        $data = json_decode($request->getContent(), true);

        $id = $data['id'];

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:contact')->findOneBy(array('id' => $id));

        if ($entity != null){
            $em->remove($entity);
            $em->flush();
        }

        $response = new Response();
        return $response;

    }


    /**
     * @Route("/api/viewcontact", name="view_contact_route")
     */
    public function viewContact(){
        $contacts = $this->getDoctrine()->getRepository('AppBundle:contact')->findAll();
        //print_r($contacts);



        $data = array();

            foreach($contacts as $e)
            {
                $data[] =
                    array(
                        'id' => $e->getId(),
                        'fname' => $e->getFname(),
                        'lname' => $e->getLname(),
                        'telno' => $e->getTelno(),
                        'email' => $e->getEmail()
                    );



            }

        $response = new Response(json_encode($data));
        return $response;


    }


    /**
     * @Route("/api/deletecontact/{id}", name="delete_contact_route")
     */
    public function deleteContact($id){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:contact')->findOneBy(array('id' => $id));

        if ($entity != null){
            $em->remove($entity);
            $em->flush();
        }
        $this->addFlash('message','Contact Succcessfully Deleted!');
        return $this->redirectToRoute('view_contact_route');
    }

    /**
     * @Route("/post/updatecontact/{id}", name="update_contact_route")
     */
    public function updateContact($id,Request $request){
        $contact = $this->getDoctrine()->getRepository('AppBundle:contact')->find($id);

        $form = $this->createFormBuilder($contact)
            ->add('fname', TextType::class, array('attr' =>  array('class' => 'form-control')))
            ->add('lname', TextType::class, array('attr' =>  array('class' => 'form-control')))
            ->add('telno', TextType::class, array('attr' =>  array('class' => 'form-control')))
            ->add('email', EmailType::class, array('attr' =>  array('class' => 'form-control')))
            ->add('Update', SubmitType::class, array('attr' =>  array('class' => 'btn btn-primary')))

            ->getForm();
        $form -> handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $fname = $form['fname']->getData();
            $lname = $form['lname']->getData();
            $email = $form['email']->getData();
            $telno = $form['telno']->getData();


            $em = $this->getDoctrine()->getManager();
            $contact = $em->getRepository('AppBundle:contact')->find($id);

            $contact->setFname($fname);
            $contact->setLname($lname);
            $contact->setEmail($email);
            $contact->setTelno($telno);

            $em->flush();


            $this->addFlash('message','Contact Succcessfully Updated!');
            return $this->redirectToRoute('view_contact_route');

        }



        return $this->render("pages/update.html.twig", [
            'form' => $form->createView()  ]);
    }

    /**
     * @Route("/post/showcontact/{id}", name="show_contact_route")
     */
    public function showContact($id){

        $contacts = $this->getDoctrine()->getRepository('AppBundle:contact')->find($id);
        $fname = $contacts->getFname();
        $lname = $contacts->getLname();
        $telno = $contacts->getTelno();
        $email = $contacts->getEmail();

        $data = [
                'fname' => $fname,
                'lname' => $lname,
                'telno' => $telno,
                'email' => $email,
            ];
        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;


    }

}
