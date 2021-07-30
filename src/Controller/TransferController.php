<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Transaction;
use App\Form\TransferType;
use App\Service\TransferHelper;
use App\Validator\AmountLessThan;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TransferController extends BaseController
{
    /**
     * @Route("/transfer/{account}", name="transfer")
     */
    public function index(Request $request, TransferHelper $helper, Account $account): Response
    {
        $accounts = $this->getEntityManager()->getRepository(Account::class)->getActivesFilterUser($this->getUser(), $account);

        $form = $this->createForm(TransferType::class, null, [
            'exceptAccount' => $account,
            'user' => $this->getUser(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $errorList = $this->getValidator()->validate($account,
                new AmountLessThan());

            if (!count($errorList)) {
                if ($helper->transfer($form->getData(), $account) instanceof Transaction) {
                    $this->addFlash('success', '');
                }
            }

            $errorMessage = new FormError($errorList[0]->getMessage());
            $form->get('amount')->addError($errorMessage);
        }

        return $this->render('transfer/transfer_action.html.twig', [
            'controller_name' => 'TransferController',
            'accountTransferFrom' => $account,
            'form' => $form->createView()
        ]);
    }

}
