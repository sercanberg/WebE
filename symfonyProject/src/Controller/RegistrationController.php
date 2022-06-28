<?php

namespace App\Controller;

use App\Entity\Account;
use App\Entity\Products;
use App\Entity\User;
use App\Form\RegistrationFormType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/registierung", name="app_register")
     */
    public function register(Request $request, UserPasswordHasherInterface
                                     $userPasswordHasher, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()));
            $entityManager->persist($user);
            $entityManager->flush();
            # create Account
            $entityManager = $doctrine->getManager();
            $account= new Account();
            $account->setUsername($user -> {"username"});
            $entityManager->persist($account);
            $entityManager->flush();

            return $this->redirectToRoute('login');
        }
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
