<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Debt;
use AppBundle\Entity\File;
use AppBundle\Entity\Modul;
use AppBundle\Entity\Payment;
use AppBundle\Form\FileType;
use AppBundle\Form\FType;
use League\Csv\Reader;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class AddFileController extends Controller
{
    /**
     * @Route("/add_file", name="add-file")
     */
    public function addFileAction(Request $request)
    {
        $f = new File();
        $form = $this->createForm(FType::class, $f);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $file stores the uploaded PDF file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $f->getFile();

            $fileName = 'Failas.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $file->move(
                    $this->getParameter('file_directory'),
                    $fileName
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            // updates the 'brochure' property to store the PDF file name
            // instead of its contents
            $f->setFile($fileName);

            // ... persist the $product variable or any other work

            return $this->redirect('/file/setup');
        }

        return $this->render('add_file.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/file/setup", name="file-setup")
     */
    public function fileSetupAction(Request $request)
    {
        $lastCost = '';
        $error = false;
        $errorMsgs = array();

        $em = $this->getDoctrine()->getManager();
        $groups = $em->createQuery(
            'SELECT g
            FROM AppBundle:Group g'
        )->getResult();

        if($request->isMethod('post')) {
            $lastCost = $request->request->get('cost', '');
            $dateFrom = $request->request->get('dateFrom', '');
            $dateTo = $request->request->get('dateFrom', '');


            if ($lastCost === '') {
                $error = true;
                $errorMsgs[] = 'Būtina įvesti kaina per valanda';
            }

            if (!$error) {

//                $payment = new Payment();
//                $payment->setAmount($lastCost);
//                $payment->setConfirmed(0);
//                $payment->setPaid(0);
//                $payment->setDate(new \DateTime('now'));
//
//                $entityManager = $this->getDoctrine()->getManager();
//                $entityManager->persist($payment);
//                $entityManager->flush();


                $finder = new Finder();
                $finder->files()->in('%kernel.project_dir%/web/Files');
//                $reader = Reader::createFromPath('%kernel.project_dir%/web/Files/Failas.csv');
//                $results = $reader->fetchAssoc();

                foreach ($finder as $files)
                {
                    dump($files);
                    die();
                    $user = $entityManager->createQuery(
                        'SELECT u
                        FROM AppBundle:User u
                        WHERE u.name = :name'
                    )->setParameter('name', $row['vardas'])->getOneOrNullResult();
                    $student = $entityManager->createQuery(
                        'SELECT s
                        FROM AppBundle:User_student s
                        WHERE s.fk_Userid = :user'
                    )->setParameter('name', $user->getId())->getOneOrNullResult();

                    $modul = $entityManager->createQuery(
                        'SELECT m
                        FROM AppBundle:Modul m
                        WHERE m.code = :modul'
                    )->setParameter('modul', $row['modulis'])->getOneOrNullResult();

                    $lector = $entityManager->createQuery(
                        'SELECT l
                        FROM AppBundle:User_lector l
                        WHERE l.fkModulsid = :modul'
                    )->setParameter('modul', $modul->getId())->getOneOrNullResult();

                    $dept = new Debt();

                    $dept->setAmount($lastCost);
                    $dept->setDateFrom($dateFrom);
                    $dept->setDateTo($dateTo);
                    $dept->setFkPaymentid($payment);
                    $dept->setFkLectorid($lector);
                    $dept->setFkModulid($modul);
                    $dept->setFkStudentid($student);

                    $entityManager->persist($dept);
                }
                $entityManager->flush();

                return $this->redirect('/');
            } else {
                return $this->render('setup_file.html.twig', [
                    'error' => $error,
                    'error_msgs' => $errorMsgs,
                    'last_cost' => $lastCost,
                ]);
            }
        }
        return $this->render('setup_file.html.twig', [
            'error' => $error,
            'error_msgs' => $errorMsgs,
            'last_cost' => $lastCost,
            'groups' => $groups,
        ]);
    }
}