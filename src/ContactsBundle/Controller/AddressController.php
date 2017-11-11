<?php

namespace ContactsBundle\Controller;

use ContactsBundle\Entity\Address;
use ContactsBundle\Form\AddressType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class AddressController extends Controller
{
    /**
     * @Route("/{userId}/addAddress", name="addAddress")
     */
    public function addAddressAction(Request $request, $userId)
    {
        $address = new Address();

        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository("ContactsBundle:User")->findOneById($userId);

            $address->setUser($user);
            $em->persist($address);
            $em->flush();

            return $this->redirectToRoute("showUser", ["id" => $userId]);

        }

        return $this->render('ContactsBundle:Address:add_address.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{userId}/{addressId}/editAddress", name="editAddress")
     */
    public function editAddressAction(Request $request, $userId, $addressId)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository('ContactsBundle:Address');
        $address = $repository->findOneById($addressId);

        if (!$address || !$em->getRepository("ContactsBundle:User")->findOneById($userId)) {
            return $this->redirectToRoute("showUser", ["id" => $userId]);
        }

        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address = $form->getData();
            $em->persist($address);
            $em->flush();

            return $this->redirectToRoute("showUser", ["id" => $userId]);
        }

        return $this->render('ContactsBundle:Address:edit_address.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/deleteAddress", name="deleteAddress")
     */
    public function deleteAddressAction()
    {
        return $this->render('ContactsBundle:Address:delete_address.html.twig', array(// ...
        ));
    }

    /**
     * @Route("/showAllAddresses")
     */
    public function showAllAddressesAction()
    {
        return $this->render('ContactsBundle:Address:show_all_addresses.html.twig', array(// ...
        ));
    }

}
