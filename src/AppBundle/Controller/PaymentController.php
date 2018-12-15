<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Debt;
use AppBundle\Entity\Modul;
use AppBundle\Entity\Payment;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PaymentController extends Controller
{
    /**
     * @param $id
     *
     * @Route("/dept/payment/save/{id}", requirements={"id" = "\d+"}, name="payment-save")
     * @return null
     *
     */
    public function paymentAction(Request $request, $id=null)
    {
        $lastBank = '';
        $lastName = '';
        $lastSurname = '';
        $error = false;
        $errorMsgs = array();
        $currentId = null;
        $currentId = $id;


        if($request->isMethod('post')) {
            $lastBank = $request->request->get('bank', '');
            $lastName = $request->request->get('name', '');
            $lastSurname = $request->request->get('surname', '');
            $card = $request->request->get('card', '');


            if ($lastName === '') {
                $error = true;
                $errorMsgs[] = 'Būtina įvesti vardą';
            }
            if ($lastSurname === '') {
                $error = true;
                $errorMsgs[] = 'Būtina įvesti pavardę';
            }
            if ($lastBank === '') {
                $error = true;
                $errorMsgs[] = 'Būtina įvesti banką';
            }

            if ($card === '') {
                $error = true;
                $errorMsgs[] = 'Būtina įvesti kortelės numerį';
            }

            if (!$error) {
                $entityManager = $this->getDoctrine()->getManager();
                $debt = $entityManager->getRepository(Debt::class)->find($id);

                $payment = $debt->getFkPaymentid();
                $payment->setPaid(1);
                $entityManager->flush();
                return $this->redirect('/message/create');
            } else {
                return $this->render('payment.html.twig', [
                    'error' => $error,
                    'error_msgs' => $errorMsgs,
                    'last_bank' => $lastBank,
                    'last_name' => $lastName,
                    'last_surname' => $lastSurname,
                    'currentId' => $currentId,
                ]);
            }
        }


        return $this->render('payment.html.twig', [
            'error' => $error,
            'error_msgs' => $errorMsgs,
            'last_bank' => $lastBank,
            'last_name' => $lastName,
            'last_surname' => $lastSurname,
            'currentId' => $currentId,
        ]);
    }

}