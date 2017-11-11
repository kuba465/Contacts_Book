<?php

namespace ContactsBundle\Controller;

use ContactsBundle\Entity\User;
use ContactsBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class UserController extends Controller
{
    /**
     * @Route("/new", name="newUser")
     */
    public function newAction(Request $request)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute("showUser", ["id" => $user->getId()]);
        }

        return $this->render('ContactsBundle:User:new.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{id}/modify", requirements={"id"="\d+"}, name="modify")
     */
    public function modifyAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ContactsBundle:User");
        $user = $repository->findOneById($id);

        if (!$user) {
            return $this->redirectToRoute("showAll");
        }

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute("showUser", ["id" => $user->getId()]);
        }

        return $this->render('ContactsBundle:User:modify.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{id}/delete", name="delete")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ContactsBundle:User");

        $userToDelete = $repository->findOneById($id);

        if (!$userToDelete) {
            return $this->redirectToRoute("showAll");
        }

        $em->remove($userToDelete);
        $em->flush();

        return $this->render('ContactsBundle:User:delete.html.twig', array(// ...
        ));
    }

    /**
     * @Route("/", name="showAll")
     */
    public function showAllAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ContactsBundle:User");

        $users = $repository->findAll();

        return $this->render('ContactsBundle:User:show_all.html.twig', array(
            'users' => $users
        ));
    }

    /**
     * @Route("/{id}", name="showUser")
     */
    public function showUserAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository("ContactsBundle:User")->findOneById($id);

        if (!$user) {
            return $this->redirectToRoute("showAll");
        }

        $phones = $em->getRepository("ContactsBundle:Phone")->findByUser($user);
        $emails = $em->getRepository("ContactsBundle:Email")->findByUser($user);
        $addresses = $em->getRepository("ContactsBundle:Address")->findByUser($user);

        return $this->render("ContactsBundle:User:showUser.html.twig", [
            'user' => $user,
            'phones' => $phones,
            'emails' => $emails,
            'addresses' => $addresses
        ]);
    }

}
