<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Debt;
use AppBundle\Entity\Modul;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class WorkController extends Controller
{
    /**
    * @Route("/work", name="work")
    */
    public function studentDeptAction()
    {
        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();
        $student = $entityManager->createQuery(
            'SELECT s
            FROM AppBundle:User_student s
            WHERE s.fk_Userid = :user'
        )->setParameter('user', $user->getId())->getOneOrNullResult();

        $dept = $entityManager->createQuery(
            'SELECT d
            FROM AppBundle:Debt d
            WHERE d.fk_Studentid = :student'
        )->setParameter('student', $student->getId())->getResult();

        return $this->render('work_list.html.twig', [
            'dept' => $dept,
        ]);
    }
}