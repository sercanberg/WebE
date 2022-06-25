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
        $entityManager = $doctrine->getManager();
        $product = new Cart();
        $product->setProductId($id);
        $product->setAmount(1);
        $entityManager->persist($product);
        $entityManager->flush();
        echo "Produkt wurde im Warenkorb gespeichert";

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
        foreach ($products as $product) {
            $artnew= $doctrine->getRepository(Products::class)->findBy(
                [
                    'id' => $product -> {"productid"},
                ]);
            $art = array_merge($art, $artnew);
        }
        //print_r($art);
        return $this->render('bab/warenkorb.html.twig', [
            'products' => $art

        ]);
    }
}