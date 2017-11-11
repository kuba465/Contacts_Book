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
     * @Route("/{id}/addAddress", name="addAddress")
     */
    public function addAddressAction(Request $request, $id)
    {
        $address = new Address();

        $form = $this->createForm(AddressType::class, $address);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $address = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository("ContactsBundle:User")->findOneById($id);

            $address->setUser($user);
            $em->persist($address);
            $em->flush();

            return $this->redirectToRoute("showUser", ["id" => $id]);

        }

        return $this->render('ContactsBundle:Address:add_address.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{userId}/{addressId}/editAddress", name="editAddress")
     */
    public function editAddressAction()
    {
        return $this->render('ContactsBundle:Address:edit_address.html.twig', array(// ...
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
