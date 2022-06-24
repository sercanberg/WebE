<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\Products;
use Doctrine\Persistence\ManagerRegistry;
class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="create_product")
     */
    public function createProduct(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $product = new Products();
        $product->setName('Sonnenbrille');
        $product->setPrice(30);
        $product->setWeather('Normal');
        $product->setCategorie('Accessoires');
        $product->setPicture('sunglasses.jpg');
        $product->setStyle('Unisex');
// erzähle der Doctrine, dass Sie das Produkt speichern wollen
        $entityManager->persist($product);
// führt die aktuelle Anfrage aus
        $entityManager->flush();
// gibt die aktuelle ID zurück
        return new Response('Neues Produkt mit der id ' . $product->getId() . ' gespeichert.');
    }}