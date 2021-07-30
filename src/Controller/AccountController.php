<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{

    /**
     * @Route("/my-accounts", name="my_accounts")
     */
    public function myAccounts()
    {
        return $this->render('account/my_accounts.html.twig');
    }

}