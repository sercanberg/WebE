<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Products;
use App\Entity\Cart;
use Doctrine\Persistence\ManagerRegistry;
class CartController extends AbstractController
{
    /**
     * @Route("/in_cart")
     */
    public function insertProduct(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $product = new Cart();
        $product->setProductId(1);
        $product->setAmount(1);
// erzähle der Doctrine, dass Sie das Produkt speichern wollen
        $entityManager->persist($product);
// führt die aktuelle Anfrage aus
        $entityManager->flush();
// gibt die aktuelle ID zurück
        return new Response('Neues Produkt mit der id ' . $product->getId() . ' gespeichert.');
    }

    /**
     * @Route("/warenkorb/{id}", defaults={"page": 12, "title": "Hello world!"})
     */
    public function number16(ManagerRegistry $doctrine, $id): Response
    {
        $in_cart= $doctrine->getRepository(Cart::class)->findBy(
            [
                'productid' => $id,
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
            $entityManager->persist($product);
        }
        $entityManager->flush();
        # show product
        $product= $doctrine->getRepository(Products::class)->findBy(
            [
                'id' => $id,
            ]);

        return $this->render('bab/in_warenkorb.html.twig', [
            'products' => $product

        ]);
    }

    /**
     * @Route("/warenkorb", defaults={"page": 12, "title": "Hello world!"})
     */
    public function number17(ManagerRegistry $doctrine): Response
    {

        $products= $doctrine->getRepository(Cart::class)->findAll();
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
            'amounts' => $amount

        ]);
    }
    /**
     * @Route("/finish", defaults={"page": 12, "title": "Hello world!"})
     */
    public function cart_clear(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $products= $doctrine->getRepository(Cart::class)->findAll();
        foreach ($products as $product){
            $entityManager->remove($product);
        }
        $entityManager->flush();
        return $this->render('bab/finished.html.twig', [

        ]);
    }

    /**
     * @Route("/delete/{id}", defaults={"page": 12, "title": "Hello world!"})
     */
    public function clearitem(ManagerRegistry $doctrine, $id): Response
    {
        $entityManager = $doctrine->getManager();
        $product= $doctrine->getRepository(Cart::class)->findBy(
            [
                'productid' => $id
            ]);
        $entityManager->remove($product["0"]);
        $entityManager->flush();
        return $this->forward('App\Controller\CartController::number17');
    }
}