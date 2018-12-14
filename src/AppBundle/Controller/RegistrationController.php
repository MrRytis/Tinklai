<?php
/**
 * Created by PhpStorm.
 * UserStudent: Rytis
 * Date: 12/11/2018
 * Time: 9:25 PM
 */

namespace AppBundle\Controller;


use AppBundle\Entity\Group;
use AppBundle\Entity\Modul;
use AppBundle\Entity\User;
use AppBundle\Entity\User_lector;
use AppBundle\Entity\User_student;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RegistrationController extends Controller
{
    /**
     * @Route("/register/student", name="register-student")
     */
    public function registerAction(Request $request)
    {
        // Create a new blank user and process the form

        $lastEmail = '';
        $lastName = '';
        $lastSurname = '';
        $error = false;
        $errorMsgs = array();
        $groups = $this->getDoctrine()->getRepository(Group::class)->findAll();
        $moduls = $this->getDoctrine()->getRepository(Modul::class)->findAll();

        if($request->isMethod('post')) {
            $lastEmail = $request->request->get('email', '');
            $lastName = $request->request->get('name', '');
            $lastSurname = $request->request->get('surname', '');
            $password = $request->request->get('password', '');
            $repeat = $request->request->get('password-repeat', '');
            $group = $request->request->get('group', '');
            $modul = $request->request->get('modul', '');


            if ($lastEmail === '') {
                $error = true;
                $errorMsgs[] = 'Būtina įvesti el. paštą';
            }
            if ($lastName === '') {
                $error = true;
                $errorMsgs[] = 'Būtina įvesti vardą';
            }
            if ($lastSurname === '') {
                $error = true;
                $errorMsgs[] = 'Būtina įvesti pavardę';
            }
            if ($password === '') {
                $error = true;
                $errorMsgs[] = 'Būtina įvesti slatpažodį';
            }
            if ($password !== $repeat) {
                $error = true;
                $errorMsgs[] = 'Slaptažodis nesutampa su pakartotų slaptažodžiu';
            }

            if (!$error) {
                $entityManager = $this->getDoctrine()->getManager();
                $g = $entityManager->createQuery(
                    'SELECT g
                    FROM AppBundle:Group g
                    WHERE g.name = :name'
                )->setParameter('name', $group)->getOneOrNullResult();

                $m = $entityManager->createQuery(
                    'SELECT m
                    FROM AppBundle:Modul m
                    WHERE m.code = :code'
                )->setParameter('code', $modul)->getOneOrNullResult();

                $user = new User();
                $encoder = $this->get('security.password_encoder');
                $pass = $encoder->encodePassword($user, $password);

                $user->setName($lastName);
                $user->setEmail($lastEmail);
                $user->setPassword($pass);
                $user->setRole('ROLE_STUDENT');

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                $user_student = new User_student();
                $user_student->setFkUserid($user);
                $user_student->setFkModulsid($m);
                $user_student->setFkGroupsid($g);

                $entityManager->persist($user_student);
                $entityManager->flush();

                return $this->redirect('/register');
            } else {
                return $this->render('auth/register_student.html.twig', [
                    'error' => $error,
                    'error_msgs' => $errorMsgs,
                    'last_email' => $lastEmail,
                    'last_name' => $lastName,
                    'last_surname' => $lastSurname,
                    'groups' => $groups,
                    'moduls' => $moduls,
                ]);
            }
        }
        return $this->render('auth/register_student.html.twig', [
            'error' => $error,
            'error_msgs' => $errorMsgs,
            'last_email' => $lastEmail,
            'last_name' => $lastName,
            'last_surname' => $lastSurname,
            'groups' => $groups,
            'moduls' => $moduls,
        ]);
    }

    /**
     * @Route("/register/lector", name="register-lector")
     */
    public function registerLectorAction(Request $request)
    {
        // Create a new blank user and process the form

        $lastEmail = '';
        $lastName = '';
        $lastSurname = '';
        $error = false;
        $errorMsgs = array();
        $moduls = $this->getDoctrine()->getRepository(Modul::class)->findAll();

        if($request->isMethod('post'))
        {
            $lastEmail = $request->request->get('email', '');
            $lastName = $request->request->get('name', '');
            $lastSurname = $request->request->get('surname', '');
            $password = $request->request->get('password', '');
            $repeat = $request->request->get('password-repeat', '');
            $modul = $request->request->get('modul', '');

            if($lastEmail === '')
            {
                $error = true;
                $errorMsgs[] = 'Būtina įvesti el. paštą';
            }
            if($lastName === '')
            {
                $error = true;
                $errorMsgs[] = 'Būtina įvesti vardą';
            }
            if($lastSurname === '')
            {
                $error = true;
                $errorMsgs[] = 'Būtina įvesti pavardę';
            }
            if($password === '')
            {
                $error = true;
                $errorMsgs[] = 'Būtina įvesti slatpažodį';
            }
            if($password !== $repeat)
            {
                $error = true;
                $errorMsgs[] = 'Slaptažodis nesutampa su pakartotų slaptažodžiu';
            }

            if(!$error)
            {
                $entityManager = $this->getDoctrine()->getManager();
                $m = $entityManager->createQuery(
                    'SELECT m
                    FROM AppBundle:Modul m
                    WHERE m.code = :code'
                )->setParameter('code', $modul)->getOneOrNullResult();

                $user = new User();
                $encoder = $this->get('security.password_encoder');
                $pass = $encoder->encodePassword($user, $password);

                $user->setName($lastName);
                $user->setEmail($lastEmail);
                $user->setPassword($pass);
                $user->setRole('ROLE_LECTOR');


                $entityManager->persist($user);
                $entityManager->flush();

                $user_lector = new User_lector();
                $user_lector->setFkUserid($user);
                $user_lector->setFkModulsid($m);

                $entityManager->persist($user_lector);
                $entityManager->flush();

                return $this->redirect('/register');
            }
            else
            {
                return $this->render('auth/register_lector.html.twig', [
                    'error' => $error,
                    'error_msgs' => $errorMsgs,
                    'last_email' => $lastEmail,
                    'last_name' => $lastName,
                    'last_surname' => $lastSurname,
                    'moduls' => $moduls,
                ]);
            }
        }
        return $this->render('auth/register_lector.html.twig', [
            'error' => $error,
            'error_msgs' => $errorMsgs,
            'last_email' => $lastEmail,
            'last_name' => $lastName,
            'last_surname' => $lastSurname,
            'moduls' => $moduls,
        ]);
    }

    /**
     * @Route("/register", name="register")
     */
    public function registerMainAction(Request $request)
    {
        return $this->render('register/register_main.html.twig', [
        ]);
    }
}