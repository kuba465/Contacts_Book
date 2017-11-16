<?php

namespace ContactsBundle\Controller;

use ContactsBundle\Entity\Phone;
use ContactsBundle\Entity\User;
use ContactsBundle\Form\PhoneType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PhoneController extends Controller
{
    /**
     * @Route("/{userId}/addPhone", name="addPhone")
     */
    public function addPhoneAction(Request $request, $userId)
    {
        $phone = new Phone();

        $form = $this->createForm(PhoneType::class, $phone);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $phone = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository("ContactsBundle:User")->findOneById($userId);

            $phone->setUser($user);
            $em->persist($phone);
            $em->flush();

            return $this->redirectToRoute("showUser", ["id" => $userId]);

        }

        return $this->render('ContactsBundle:Phone:add_phone.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{userId}/{phoneId}/editPhone", name="editPhone")
     */
    public function editPhoneAction(Request $request, $userId, $phoneId)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('ContactsBundle:Phone');
        $phone = $repository->findOneById($phoneId);

        if (!$phone || !$em->getRepository("ContactsBundle:User")->findOneById($userId)) {
            return $this->redirectToRoute("showUser", ["id" => $userId]);
        }

        $form = $this->createForm(PhoneType::class, $phone);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $phone = $form->getData();
            $em->persist($phone);
            $em->flush();

            return $this->redirectToRoute("showUser", ["id" => $userId]);
        }

        return $this->render('ContactsBundle:Phone:edit_phone.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{userId}/{phoneId}/deletePhone", name="deletePhone")
     */
    public function deletePhoneAction($userId, $phoneId)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('ContactsBundle:Phone');
        $phoneToDelete = $repository->findOneById($phoneId);

        if (!$phoneToDelete || !$em->getRepository("ContactsBundle:User")->findOneById($userId)) {
            return $this->redirectToRoute("showUser", ["id" => $userId]);
        }

        $em->remove($phoneToDelete);
        $em->flush();

        return $this->redirectToRoute("showUser", ["id" => $userId]);
    }
}
