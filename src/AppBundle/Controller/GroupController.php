<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Group;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GroupController extends AbstractController
{
    /**
     * @Route("/group/add", name="group-add")
     */
    public function AddGroupAction(Request $request)
    {
        $name = '';
        $error = false;
        $errorMsgs = array();
        $g = $this->getDoctrine()->getRepository(Group::class)->findAll();

        if($request->isMethod('post')) {
            $name = $request->request->get('name', '');


            if ($name === '') {
                $error = true;
                $errorMsgs[] = 'Būtina įvesti pavadinima';
            }

            foreach ($g as $gr)
            {
                if($gr->getName() == $name)
                {
                    $error = true;
                    $errorMsgs[] = 'Modulio kodas negali kartotis';
                }
            }

            if (!$error) {
                $group = new Group();

                $group->setName($name);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($group);
                $entityManager->flush();

                return $this->redirect('/group/list');
            } else {
                return $this->render('group_add.html.twig', [
                    'error' => $error,
                    'error_msgs' => $errorMsgs,
                    'last_name' => $name,
                ]);
            }
        }
        return $this->render('group_add.html.twig', [
            'error' => $error,
            'error_msgs' => $errorMsgs,
            'last_name' => $name,
        ]);
    }

    /**
     * @Route("/group/list", name="group-list")
     */
    public function groupListAction()
    {
        $group = $this->getDoctrine()->getRepository(Group::class)->findAll();
//        dump($group);
//        die();

        return $this->render('group_list.html.twig', [
            'group' => $group,
        ]);
    }
}