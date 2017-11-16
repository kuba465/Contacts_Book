<?php

namespace ContactsBundle\Controller;

use ContactsBundle\Entity\Group;
use ContactsBundle\Form\GroupType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/group")
 */
class GroupController extends Controller
{
    /**
     * @Route("/add", name="addGroup")
     */
    public function addGroupAction(Request $request)
    {
        $group = new Group();
        $form = $this->createForm(GroupType::class, $group);

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
            $group = $form->getData();
            $em = $this->getDoctrine()->getManager();

            //pobieram użytkowników i dodaję każdemu grupę
            $users = $group->getUsers();
            if (!is_null($users)) {
                foreach ($users as $user) {
                    $user->addGroup($group);
                }
            }

            $em->persist($group);
            $em->flush();

            return $this->redirectToRoute("showUsersOfGroup", ["id" => $group->getId()]);
        }

        return $this->render('ContactsBundle:Group:add_group.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{id}/edit", name="editGroup")
     */
    public function editGroupAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ContactsBundle:Group");
        $group = $repository->findOneById($id);

        if (!$group) {
            return $this->redirectToRoute("showAllGroups");
        }

        $form = $this->createForm(GroupType::class, $group);

        $form->handleRequest($request);

        if ($form->isValid() && $form->isSubmitted()) {
            $group = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $em->persist($group);
            $em->flush();

            $users = $group->getUsers();
            foreach ($users as $user) {//niestety nie dodaje nowych osób...
                if (!$group->getUsers()->contains($user)) {
                    $user->addGroup($group);
                }
            }


            return $this->redirectToRoute("showUsersOfGroup", ["id" => $group->getId()]);
        }

        return $this->render('ContactsBundle:Group:edit_group.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/{id}/delete", name="deleteGroup")
     */
    public function deleteGroupAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ContactsBundle:Group");

        $groupToDelete = $repository->findOneById($id);

        if (!$groupToDelete) {
            return $this->redirectToRoute("showAllGroups");
        }

        $em->remove($groupToDelete);
        $em->flush();

        return $this->redirectToRoute("showAllGroups");
    }

    /**
     * @Route("/{userId}/{groupId}/deleteUserFromGroup", name="deleteUserFromGroup")
     */
    public function deleteUserFromGroupAction(Request $request, $userId, $groupId)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ContactsBundle:Group");
        $group = $repository->findOneById($groupId);

        $user = $em->getRepository("ContactsBundle:User")->findOneById($userId);

        if (!$user || !$group) {
            return $this->redirectToRoute("showAllGroups");
        }
        //należy usunąć usera z grupy i "grupę z usera"
        $group->removeUser($user);
        $user->removeGroup($group);
        $em->persist($group);
        $em->flush();

        //if i delete user from group by user site it render to this user site
        if (strpos($request->headers->get('referer'), 'group') == false) {
            return $this->redirectToRoute("showUser", ["id" => $userId]);
        }

        return $this->redirectToRoute("showUsersOfGroup", ["id" => $groupId]);
    }

    /**
     * @Route("/", name="showAllGroups")
     */
    public function showAllGroupsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ContactsBundle:Group");

        $groups = $repository->findAll();

        return $this->render('ContactsBundle:Group:show_all_groups.html.twig', array(
            'groups' => $groups
        ));
    }

    /**
     * @Route("/{id}/showUsersOfGroup", name="showUsersOfGroup")
     */
    public function showUsersOfGroupAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $em->getRepository("ContactsBundle:Group");

        $group = $repository->findOneById($id);

        return $this->render('ContactsBundle:Group:show_users_of_group.html.twig', array(
            'users' => $group->getUsers(),
            'group' => $group
        ));
    }

}
