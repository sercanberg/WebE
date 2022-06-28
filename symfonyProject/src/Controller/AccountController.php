<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountController extends AbstractController
{
    public function get_user(): string{
        $user = $this->getUser();
        if ($user == null){
            $username = "n/a";
        }
        else{
            $username = $user -> {"username"};
        }
        return $username;
    }
    /**
     * @Route("/account")
     */
    public function user_acc(ManagerRegistry $doctrine): Response
    {
        $username = $this->get_user();
        $account = $doctrine->getRepository(Account::class)->findBy(
            [
                'username' => $username
            ]);
        return $this->render('bab/account.html.twig', [
            'username' => $username,
            'account' => $account["0"]
        ]);
    }
    /**
     * @Route("/account-set")
     */
    public function acc_set(Request $request, ManagerRegistry $doctrine): Response
    {
        $content = $request -> getContent();
        //$split = explode("=", $content);
        //$city = $split[2];
        //$street = explode("&", $split[1])[0];
        //print_r($city);
        //print_r($street);
        $username = $this->get_user();

        print_r($content);

        $current_user= $doctrine->getRepository(User::class)->findBy(
            [
                'username' => $username
            ]);
        if ($current_user == null){
            $current_user = array();
            $current_user["0"] = "n/a";
        }
        return $this->render('bab/account.html.twig', [
            'username' => $username,
            'user' => $current_user["0"]

        ]);

    }
}
