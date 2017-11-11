<?php

namespace ContactsBundle\Controller;

use ContactsBundle\Entity\Email;
use ContactsBundle\Form\EmailType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class EmailController extends Controller
{
    /**
     * @Route("/{id}/addEmail", name="addEmail")
     */
    public function addEmailAction(Request $request, $id)
    {
        $email = new Email();

        $form = $this->createForm(EmailType::class, $email);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository("ContactsBundle:User")->findOneById($id);

            $email->setUser($user);
            $em->persist($email);
            $em->flush();

            return $this->redirectToRoute("showUser", ["id" => $id]);

        }

        return $this->render('ContactsBundle:Email:add_email.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{userId]/{emailId}/editEmail", name="editEmail")
     */
    public function editEmailAction()
    {
        return $this->render('ContactsBundle:Email:edit_email.html.twig', array(// ...
        ));
    }

    /**
     * @Route("/{userId]/{emailId}/deleteEmail", name="deleteEmail")
     */
    public function deleteEmailAction()
    {
        return $this->render('ContactsBundle:Email:delete_email.html.twig', array(// ...
        ));
    }

    /**
     * @Route("/showAllEmails")
     */
    public function showAllEmailsAction()
    {
        return $this->render('ContactsBundle:Email:show_all_emails.html.twig', array(// ...
        ));
    }

}
