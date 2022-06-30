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
        # Nur zum Produkte erstellen
        $entityManager = $doctrine->getManager();
        $product = new Products();
        $product->setName('Frauen Kappe');
        $product->setPrice(45);
        $product->setWeather('Normal');
        $product->setCategorie('Accessoires');
        $product->setPicture('f_kappe.jpeg');
        $product->setStyle('Damen');
        $entityManager->persist($product);
        $entityManager->flush();
        return new Response('Neues Produkt mit der id ' . $product->getId() . ' gespeichert.');
    }}