<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Transaction;
use App\Form\CustomerFilterType2;
use App\Form\TransferFilterType;
use App\Form\TransferThirdType;
use App\Form\TransferType;
use App\Model\TransactionModel;
use App\Service\TransferHelper;
use App\Validator\AmountLessThan;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraint;

class TransferController extends BaseController
{
    /**
     * @Route("/transfer/async/{account}", name="transfer")
     */
    public function index(Request $request, TransferHelper $helper, Account $account): Response
    {
        $transactionModel = TransactionModel::transaction($account);
        $form = $this->createForm(TransferType::class, $transactionModel, [
            'exceptAccount' => $account,
            'user' => $this->getUser(),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contraints = $this->getValidator()->validate($transactionModel,
                new AmountLessThan());

            if (!count($contraints)) {
                $transaction = $helper->transfer($form->getData());
                if ($transaction instanceof Transaction) {
                    $this->addFlash('success', '');
                    return $this->redirectToRoute('transfer_success', ['transaction' => $transaction->getId()]);
                }
            }

            $errorMessage = new FormError($contraints[0]->getMessage());
            $form->get('amount')->addError($errorMessage);
        }

        return $this->render('transfer/transfer_action.html.twig', [
            'accountTransferFrom' => $account,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/transfer/list/third/{account}", name="transfer_list_third")
     */
    public function transferListThirds(Request $request, Account $account)
    {
        $user = $this->getUser();
        $formFilter = $this->createForm(CustomerFilterType2::class)
            ->handleRequest($request);

        $accountsActives = $this->getDoctrine()->getManager()->getRepository(Account::class)->findAllAndFilter($user, $formFilter->getData());

        $pagination = $this->getPaginator()->paginate($accountsActives,
            $request->query->getInt('page', 1));

        return $this->render('transfer/Third/list.html.twig',[
            'pagination' => $pagination,
            'form_filter' => $formFilter->createView(),
            'account' => $account
        ]);
    }

    /**
     * @Route("/transfer/sync/third/{accountTo}/{account}", name="transfer_third", methods={"GET","POST"})
     */
    public function transferThird(Request $request, TransferHelper $helper, Account $accountTo, Account $account)
    {
        $transactionModel = TransactionModel::transaction($account, $accountTo);
        $form = $this->createForm(TransferThirdType::class, $transactionModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contraints = $this->getValidator()->validate($transactionModel,
                new AmountLessThan());

            if (!count($contraints)) {
                $transaction = $helper->transfer($form->getData());
                if ($transaction instanceof Transaction) {
                    $this->addFlash('success', '');
                    return $this->redirectToRoute('transfer_success', ['transaction' => $transaction->getId()]);
                }
            }

            $errorMessage = new FormError($contraints[0]->getMessage());
            $form->get('amount')->addError($errorMessage);

//            if ($request->isXmlHttpRequest()) {
//                return new Response(null, 204);
//            }

//            return $this->redirectToRoute('transfer_list_third');
        }

        $template = $request->isXmlHttpRequest() ? '_form.html.twig' : 'new.html.twig';

        return $this->render('transfer/third/' . $template, [
            'form' => $form->createView(),
        ], new Response(
            null,
            $form->isSubmitted() && !$form->isValid() ? 422 : 200,
        ));
    }

    /**
     * @Route("/transfer/my_transfers", name="my_transfers")
     */
    public function listTransfers(Request $request)
    {
       $user = $this->getUser();
        $formFilter = $this->createForm(TransferFilterType::class)
            ->handleRequest($request);

       $myTransfers = $this->getEntityManager()->getRepository(Transaction::class)->allTransferUser($user, $formFilter->getData());

        $pagination = $this->getPaginator()->paginate($myTransfers,
            $request->query->getInt('page', 1), 2);

        return $this->render('transfer/list.html.twig',[
            'pagination' => $pagination,
            'formFilter' => $formFilter->createView(),
        ]);

    }




    /**
     * @Route("/transfer/successFully/{transaction}", name="transfer_success")
     */
    public function confirmTransaction(Transaction $transaction)
    {
        return $this->render('transfer/confirmation.html.twig', ['controlNumber' => $transaction->getControlNumber()]);
    }


    /**
     * @Route("/transfer/successFully", name="transfer_success_xmlhttp")
     */
    public function confirmTransactionXmlHttp()
    {
        $transaction = $this->getEntityManager()->getRepository(Transaction::class)->lastTransactionUser($this->getUser());
        return $this->render('transfer/confirmation.html.twig', ['controlNumber' => $transaction->getControlNumber()]);
    }
}
