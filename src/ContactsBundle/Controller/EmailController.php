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
     * @Route("/{userId}/addEmail", name="addEmail")
     */
    public function addEmailAction(Request $request, $userId)
    {
        $email = new Email();

        $form = $this->createForm(EmailType::class, $email);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository("ContactsBundle:User")->findOneById($userId);

            $email->setUser($user);
            $em->persist($email);
            $em->flush();

            return $this->redirectToRoute("showUser", ["id" => $userId]);

        }

        return $this->render('ContactsBundle:Email:add_email.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{userId}/{emailId}/editEmail", name="editEmail")
     */
    public function editEmailAction(Request $request, $userId, $emailId)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('ContactsBundle:Email');
        $email = $repository->findOneById($emailId);

        if (!$email || !$em->getRepository("ContactsBundle:User")->findOneById($userId)) {
            return $this->redirectToRoute("showUser", ["id" => $userId]);
        }

        $form = $this->createForm(EmailType::class, $email);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->getData();
            $em->persist($email);
            $em->flush();

            return $this->redirectToRoute("showUser", ["id" => $userId]);
        }

        return $this->render('ContactsBundle:Email:edit_email.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{userId}/{emailId}/deleteEmail", name="deleteEmail")
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
