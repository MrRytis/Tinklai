<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Debt;
use AppBundle\Entity\Modul;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DebtController extends Controller
{
    /**
    * @Route("/dept", name="dept")
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

        return $this->render('dept_list_student.html.twig', [
            'dept' => $dept,
        ]);
    }

    /**
     * @param $id
     *
     * @Route("/dept/edit/{id}", requirements={"id" = "\d+"}, name="dept-edit")
     * @return null
     *
     */
    public function editDeptAction($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $debt = $entityManager->getRepository(Debt::class)->find($id);

        $payment = $debt->getFkPaymentid();
        $payment->setConfirmed(1);
        $entityManager->flush();

        return $this->redirect("/dept/list");
    }

    /**
     * @Route("/dept/list", name="dept-list")
     */
    public function deptListAction()
    {
        $em = $this->getDoctrine()->getManager();
        $dept = $em->createQuery(
            'SELECT d
            FROM AppBundle:Debt d'
        )->getResult();

//        dump($dept);
//        die();
        return $this->render('dept_list.html.twig', [
            'dept' => $dept,
        ]);
    }
}