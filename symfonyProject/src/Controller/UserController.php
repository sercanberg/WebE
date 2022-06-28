<?php

namespace App\Controller;
use PhpParser\Node\Expr\Array_;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractController
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
    /**
     * @Route("/account-set")
     */
    public function acc_set(Request $request, ManagerRegistry $doctrine): Response
    {
        $content = $request -> getContent();
        $split = explode("=", $content);
        $city = $split[2];
        $street = explode("&", $split[1])[0];
        print_r($city);
        print_r($street);
        $username = $this->get_user();

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