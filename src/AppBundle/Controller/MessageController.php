<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Message;
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
}