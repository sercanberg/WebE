<?php

namespace App\Controller;


use App\Entity\Account;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Products;
use App\Entity\Cart;
use Doctrine\Persistence\ManagerRegistry;
class CartController extends AbstractController
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
     * @Route("/warenkorb/{id}", defaults={"page": 12, "title": "Hello world!"})
     */
    public function add_to_cart(ManagerRegistry $doctrine, $id): Response
    {
        $username = $this->get_user();
        $in_cart= $doctrine->getRepository(Cart::class)->findBy(
            [
                'productid' => $id,
                'user' => $username
            ]);

        # Add to cart or increase amount
        $entityManager = $doctrine->getManager();
        if ($in_cart != null){
            $newamount = $in_cart["0"]-> {"amount"} + 1;
            $in_cart["0"]-> setAmount($newamount);
        }
        else{

            $product = new Cart();
            $product->setProductId($id);
            $product->setAmount(1);
            $product->setUser($username);
            $entityManager->persist($product);
        }
        $entityManager->flush();
        # show product
        $product= $doctrine->getRepository(Products::class)->findBy(
            [
                'id' => $id,
            ]);

        return $this->render('bab/in_warenkorb.html.twig', [
            'products' => $product,
            'username' => $username

        ]);
    }

    /**
     * @Route("/warenkorb", defaults={"page": 12, "title": "Hello world!"})
     */
    public function cart(ManagerRegistry $doctrine): Response
    {
        $username = $this->get_user();
        $products= $doctrine->getRepository(Cart::class)->findBy(
            [
            'user' => $username,
            ]);
        $art = array();
        $amount = array();
        foreach ($products as $product) {
            $artnew= $doctrine->getRepository(Products::class)->findBy(
                [
                    'id' => $product -> {"productid"},
                ]);
            $amountnew = array(
                $product -> {"amount"},
            );
            $amount = array_merge($amount, $amountnew);
            $art = array_merge($art, $artnew);
        }

        $price = 0;
        for ($i = 0; $i < count($art); $i++) {
            $price += $art[$i]-> {"price"} * $amount[$i];
        }

        return $this->render('bab/warenkorb.html.twig', [
            'products' => $art,
            'price' => $price,
            'amounts' => $amount,
            'username' => $username

        ]);
    }
    /**
     * @Route("/finish", defaults={"page": 12, "title": "Hello world!"})
     */
    public function cart_clear(ManagerRegistry $doctrine): Response
    {
        $username = $this->get_user();
        $entityManager = $doctrine->getManager();
        $products= $doctrine->getRepository(Cart::class)->findAll();
        foreach ($products as $product){
            $entityManager->remove($product);
        }
        $entityManager->flush();
        return $this->render('bab/finished.html.twig', [
            'username' => $username
        ]);
    }

    /**
     * @Route("/delete/{id}", defaults={"page": 12, "title": "Hello world!"})
     */
    public function clear_item(ManagerRegistry $doctrine, $id): Response
    {
        $username = $this->get_user();
        $entityManager = $doctrine->getManager();
        $product= $doctrine->getRepository(Cart::class)->findBy(
            [
                'productid' => $id,
                'user' => $username
            ]);
        if ($product["0"]-> {"amount"} == 1){
            $entityManager->remove($product["0"]);
        }
        else{
            $new_amount = $product["0"]-> {"amount"} - 1;
            $product["0"]-> setAmount($new_amount);
        }
        $entityManager->flush();
        return $this->redirectToRoute('app_warenkorb');
    }
    /**
     * @Route("/add/{id}")
     */
    public function add_item(ManagerRegistry $doctrine, $id): Response{
        $username = $this->get_user();
        $in_cart= $doctrine->getRepository(Cart::class)->findBy(
            [
                'productid' => $id,
                'user' => $username
            ]);
        # Increase amount
        $entityManager = $doctrine->getManager();
        $new_amount = $in_cart["0"]-> {"amount"} + 1;
        $in_cart["0"]-> setAmount($new_amount);
        $entityManager->flush();

        return $this->redirectToRoute('app_warenkorb');
    }
    /**
     * @Route("/delete-all/{id}")
     */
    public function clear_items(ManagerRegistry $doctrine, $id): Response
    {
        $username = $this->get_user();
        $entityManager = $doctrine->getManager();
        $product= $doctrine->getRepository(Cart::class)->findBy(
            [
                'productid' => $id,
                'user' => $username
            ]);
        $entityManager->remove($product["0"]);
        $entityManager->flush();
        return $this->redirectToRoute('app_warenkorb');
    }

    /**
     * @Route("/kasse")
     */
    public function kasse(ManagerRegistry $doctrine): Response
    {
        $username = $this->get_user();
        $account = $doctrine->getRepository(Account::class)->findBy(
            [
                'username' => $username
            ]);

        if ($account == null){
            $account = array();
            $account["0"] = "n/a";
        }
        $products= $doctrine->getRepository(Cart::class)->findBy(
            [
                'user' => $username,
            ]);
        $art = array();
        $amount = array();
        foreach ($products as $product) {
            $artnew= $doctrine->getRepository(Products::class)->findBy(
                [
                    'id' => $product -> {"productid"},
                ]);
            $amountnew = array(
                $product -> {"amount"},
            );
            $amount = array_merge($amount, $amountnew);
            $art = array_merge($art, $artnew);
        }

        $price = 0;
        for ($i = 0; $i < count($art); $i++) {
            $price += $art[$i]-> {"price"} * $amount[$i];
        }
        return $this->render('bab/kasse.html.twig', [
            'products' => $art,
            'price' => $price,
            'amounts' => $amount,
            'username' => $username,
            'account' => $account["0"]

        ]);
    }

}