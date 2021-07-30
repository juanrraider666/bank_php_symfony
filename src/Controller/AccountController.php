<?php


namespace App\Controller;


use App\Entity\Account;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/account")
 * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
 */
class AccountController extends BaseController
{

    /**
     * @Route("/my-accounts", name="my_accounts")
     */
    public function myAccounts(Request $request)
    {
        $user = $this->getUser();

//        $this->getDoctrine()->getManager()->find(Account::class, 1);
        $accountsActives = $this->getDoctrine()->getManager()->getRepository(Account::class)->getActivesUserQb($user)
            ->getQuery()
            ->getResult();

        /** @var Account $pagination */
        $pagination = $this->getPaginator()->paginate($accountsActives,
            $request->query->getInt('page', 1));

        return $this->render('account/my_accounts.html.twig',[
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/index", name="index_account")
     */
    public function index()
    {
        return $this->render('account/index.html.twig');
    }

}