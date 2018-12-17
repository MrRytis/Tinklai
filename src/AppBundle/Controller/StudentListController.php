<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Debt;
use AppBundle\Entity\Modul;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class StudentListController extends Controller
{
    /**
    * @Route("/student/list", name="student-list")
    */
    public function studentListAction()
    {
        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        $lector = $entityManager->createQuery(
            'SELECT l
            FROM AppBundle:User_lector l
            WHERE l.fk_Userid = :user'
        )->setParameter('user', $user->getId())->getOneOrNullResult();
        $students = $entityManager->createQuery(
            'SELECT s
            FROM AppBundle:User_student s
            WHERE s.fkModulsid = :modul'
        )->setParameter('modul', $lector->getFkModulsid()->getId())->getResult();


        return $this->render('student_list.html.twig', [
            'students' => $students,
        ]);
    }
}