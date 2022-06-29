<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Cart;
use App\Entity\Products;
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
        $split = explode("street=", $content);
        $split2 = explode("&city=", $split[1]);
        $split3 = explode("&konto=", $split2[1]);
        $streetraw = $split2[0];
        $street = str_replace("+", "_", $streetraw);
        $city = $split3[0];
        $konto = $split3[1];

        $username = $this->get_user();


        $account = $doctrine->getRepository(Account::class)->findBy(
            [
                'username' => $username
            ]);

        $entityManager = $doctrine->getManager();

        $account["0"] -> setStreet($street);
        if ($city!= null) {
            $account["0"]->setCity($city);
        }
        else{
            $account["0"]->setCity(null);
        }
        if ($konto!= null) {
            $account["0"] -> setKonto($konto);
        }
        else{
            $account["0"]->setKonto(null);
        }
        $entityManager->flush();

        return $this->redirectToRoute('app_account');

    }

    /**
     * @Route("/account-set-kasse")
     */
    public function acc_set_kasse(Request $request, ManagerRegistry $doctrine): Response
    {
        # interpret form input
        $content = $request -> getContent();
        $check = substr($content, -1);
        $req = $request -> request;
        $split = explode("street=", $content);
        $split2 = explode("&city=", $split[1]);
        $split3 = explode("&konto=", $split2[1]);
        $split4 = explode("&save=", $split3[1]);
        $streetraw = $split2[0];
        $street = str_replace("+", "_", $streetraw);
        $city = $split3[0];
        $konto = $split4[0];

        $username = $this->get_user();
        $account = $doctrine->getRepository(Account::class)->findBy(
            [
                'username' => $username
            ]);

        if ($check == "1" and $username != "n/a"){
            $entityManager = $doctrine->getManager();

            $account["0"] -> setStreet($street);
            if ($city!= null) {
                $account["0"]->setCity($city);
            }
            else{
                $account["0"]->setCity(null);
            }
            if ($konto!= null) {
                $account["0"] -> setKonto($konto);
            }
            else{
                $account["0"]->setKonto(null);
            }
            $entityManager->flush();
        }


        return $this->redirectToRoute('app_finish');


    }

}
