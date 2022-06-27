<?php

namespace App\Controller;
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

        return $this->render('bab/account.html.twig', [
            'username' => $current_user
        ]);
    }
}