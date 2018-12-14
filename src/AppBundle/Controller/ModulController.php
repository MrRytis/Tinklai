<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Modul;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ModulController extends Controller
{
    /**
     * @Route("/modul/add", name="modul-add")
     */
    public function addModuleAction(Request $request)
    {
        $name = '';
        $code = '';
        $credits = '';
        $error = false;
        $errorMsgs = array();
        $m = $this->getDoctrine()->getRepository(Modul::class)->findAll();

        if($request->isMethod('post')) {
            $name = $request->request->get('name', '');
            $code = $request->request->get('code', '');
            $credits = $request->request->get('credits', '');


            if ($name === '') {
                $error = true;
                $errorMsgs[] = 'Būtina įvesti pavadinima';
            }
            if ($code === '') {
                $error = true;
                $errorMsgs[] = 'Būtina įvesti koda';
            }
            if ($credits === '') {
                $error = true;
                $errorMsgs[] = 'Būtina įvesti kreditus';
            }

            foreach ($m as $mo)
            {
                if($mo->getCode() == $code)
                {
                    $error = true;
                    $errorMsgs[] = 'Grupes pavadinimas negali kartotis';
                }
            }

            if (!$error) {
                $modul = new Modul();

                $modul->setName($name);
                $modul->setCode($code);
                $modul->setCredits($credits);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($modul);
                $entityManager->flush();

                return $this->redirect('/modul/list');
            } else {
                return $this->render('modul_add.html.twig', [
                    'error' => $error,
                    'error_msgs' => $errorMsgs,
                    'last_name' => $name,
                    'last_code' => $code,
                    'last_credits' => $credits,
                ]);
            }
        }
        return $this->render('modul_add.html.twig', [
            'error' => $error,
            'error_msgs' => $errorMsgs,
            'last_name' => $name,
            'last_code' => $code,
            'last_credits' => $credits,
        ]);
    }

    /**
     * @Route("/modul/list", name="modul-add")
     */
    public function modulListAction()
    {
        $modul = $this->getDoctrine()->getRepository(Modul::class)->findAll();

        return $this->render('modul_list.html.twig', [
            'modul' => $modul,
        ]);
    }
}