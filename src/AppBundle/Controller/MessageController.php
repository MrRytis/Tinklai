<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
use AppBundle\Entity\MessageToLector;
use AppBundle\Entity\MessageToStudent;
use AppBundle\Entity\Modul;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MessageController extends Controller
{
    /**
     * @Route("/message/list", name="message-list")
     */
    public function messageListAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $m = $entityManager->createQuery(
            'SELECT m
            FROM AppBundle:Message m
            ORDER BY m.id DESC'
        )->getResult();

        return $this->render('message_list.html.twig', [
            'message' => $m,
        ]);
    }

    /**
     * @Route("/message/create", name="message-create")
     */
    public function messageCreateAction(Request $request)
    {
        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        $student = $entityManager->createQuery(
            'SELECT s
            FROM AppBundle:User_student s
            WHERE s.fk_Userid = :user'
        )->setParameter('user', $user->getId())->getOneOrNullResult();

        $message = new Message();

        $message->setText('Skola apmoketa uz moduli ' . $student->getFkModulsid()->getCode());
        $message->setFkStudentid($student);

        $entityManager->persist($message);
        $entityManager->flush();

        return $this->redirect('/dept');
    }

    /**
     * @Route("/message/lector/list", name="message-lector-list")
     */
    public function messageLectorList()
    {
        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        $lector = $entityManager->createQuery(
            'SELECT l
            FROM AppBundle:User_lector l
            WHERE l.fk_Userid = :user'
        )->setParameter('user', $user->getId())->getOneOrNullResult();

        $message = $entityManager->createQuery(
            'SELECT m
            FROM AppBundle:MessageToLector m
            WHERE m.fk_Lectorid = :user
            ORDER BY m.id DESC'
        )->setParameter('user', $lector->getId())->getResult();

        return $this->render('message_list_lector.html.twig', [
            'message' => $message,
        ]);
    }

    /**
     * @Route("/message/student/list", name="message-student-list")
     */
    public function messageStudentList()
    {
        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        $student = $entityManager->createQuery(
            'SELECT s
            FROM AppBundle:User_student s
            WHERE s.fk_Userid = :user'
        )->setParameter('user', $user->getId())->getOneOrNullResult();

        $message = $entityManager->createQuery(
            'SELECT m
            FROM AppBundle:MessageToStudent m
            WHERE m.fk_Studentid = :user
            ORDER BY m.id DESC'
        )->setParameter('user', $student->getId())->getResult();

        return $this->render('message_list_student.html.twig', [
            'message' => $message,
        ]);
    }

    /**
     * @Route("/message/student/create", name="message-student-create")
     */
    public function messageStudentCreateAction(Request $request)
    {
        $error = false;
        $errorMsgs = array();
        $entityManager = $this->getDoctrine()->getManager();
        $lector = $entityManager->createQuery(
            'SELECT l
            FROM AppBundle:User_lector l'
        )->getResult();

        if($request->isMethod('post')) {
            $text = $request->request->get('text', '');
            $l = $request->request->get('lector', '');


            if ($text === '') {
                $error = true;
                $errorMsgs[] = 'Būtina įvesti teksta';
            }
            if ($l === '') {
                $error = true;
                $errorMsgs[] = 'Būtina įvesti destitoja';
            }

            if (!$error) {
                $user = $this->getUser();
                $entityManager = $this->getDoctrine()->getManager();
                $student = $entityManager->createQuery(
                    'SELECT s
                    FROM AppBundle:User_student s
                    WHERE s.fk_Userid = :user'
                )->setParameter('user', $user->getId())->getOneOrNullResult();

                $u = $entityManager->createQuery(
                    'SELECT u
                    FROM AppBundle:User u
                    WHERE u.name = :name'
                )->setParameter('name', $l)->getOneOrNullResult();

                $lector = $entityManager->createQuery(
                    'SELECT l
                    FROM AppBundle:User_lector l
                    WHERE l.fk_Userid = :user'
                )->setParameter('user', $u->getId())->getOneOrNullResult();

                $message = new MessageToLector();
                $message->setText($text);
                $message->setStudent($student->getFkUserid()->getName());
                $message->setFkLectorid($lector);

                $entityManager->persist($message);
                $entityManager->flush();

                return $this->redirect('/message/student/list');
            } else {
                return $this->render('message_student_create.html.twig', [
                    'error' => $error,
                    'error_msgs' => $errorMsgs,
                    'lector' => $lector,
                ]);
            }
        }
        return $this->render('message_student_create.html.twig', [
            'error' => $error,
            'error_msgs' => $errorMsgs,
            'lector' => $lector,
        ]);
    }

    /**
     * @Route("/message/lector/create", name="message-lector-create")
     */
    public function messageLectorCreateAction(Request $request)
    {
        $error = false;
        $errorMsgs = array();
        $entityManager = $this->getDoctrine()->getManager();
        $student = $entityManager->createQuery(
            'SELECT l
            FROM AppBundle:User_student l'
        )->getResult();

        if($request->isMethod('post')) {
            $text = $request->request->get('text', '');
            $l = $request->request->get('lector', '');


            if ($text === '') {
                $error = true;
                $errorMsgs[] = 'Būtina įvesti teksta';
            }
            if ($l === '') {
                $error = true;
                $errorMsgs[] = 'Būtina įvesti studenta';
            }

            if (!$error) {
                $user = $this->getUser();
                $entityManager = $this->getDoctrine()->getManager();
                $lector = $entityManager->createQuery(
                    'SELECT l
                    FROM AppBundle:User_lector l
                    WHERE l.fk_Userid = :user'
                )->setParameter('user', $user->getId())->getOneOrNullResult();

                $u = $entityManager->createQuery(
                    'SELECT u
                    FROM AppBundle:User u
                    WHERE u.name = :name'
                )->setParameter('name', $l)->getOneOrNullResult();

                $student = $entityManager->createQuery(
                    'SELECT l
                    FROM AppBundle:User_Student l
                    WHERE l.fk_Userid = :user'
                )->setParameter('user', $u->getId())->getOneOrNullResult();

                $message = new MessageToStudent();
                $message->setText($text);
                $message->setLector($lector->getFkUserid()->getName());
                $message->setFkStudentid($student);

                $entityManager->persist($message);
                $entityManager->flush();

                return $this->redirect('/message/lector/list');
            } else {
                return $this->render('message_lector_create.html.twig', [
                    'error' => $error,
                    'error_msgs' => $errorMsgs,
                    'lector' => $student,
                ]);
            }
        }
        return $this->render('message_lector_create.html.twig', [
            'error' => $error,
            'error_msgs' => $errorMsgs,
            'lector' => $student,
        ]);
    }
}