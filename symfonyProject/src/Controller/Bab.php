<?php
namespace App\Controller;
use PhpParser\Node\Expr\Array_;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\Products;
use Doctrine\Persistence\ManagerRegistry;


class Bab extends AbstractController
{
    public function weatherdata(): string
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://api.openweathermap.org/data/2.5/weather?lat=49.5&lon=8.5&appid=52f93fcb3972dd3f203176c66178aa35');
        // Grönland = lat=83&lon=-32 ; Mannheim lat=49.5&lon=8.5
        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]
        $content["main"]["temp"]=$content["main"]["temp"]-273.15;
        $tempe = $content["main"]["temp"];
        $sky = $content["weather"]["0"]["main"];

        if ($sky == "Rain"){
            #echo 'its Raining';
            $weather = "Regen";
        }
        else {
            if($tempe <= 10){
                #    echo "UAAAAA";
                $weather = "Kalt";
            }
            # elseif($tempe <= 25){
            #    echo "MUAAA";
            #   $weather = "Normal";
            #}
            else{
                #echo "I am melting";
                $weather = "Normal";
            }
        }
        return $weather;
    }


    /**
     * @Route("/bab")
     */
    public function number(ManagerRegistry $doctrine): Response
    {
        $weather = $this->weatherdata();
        $products= $doctrine->getRepository(Products::class)->findBy(
            [
                'weather' => $weather,
            ]);
        if (count($products)>=4){
            $products = array_slice($products, 0, 4);
        };
        return $this->render('bab/first.html.twig', [
            'products' => $products
        ]);
    }
    /**
     * @Route("/herren")
     */
    public function number1(ManagerRegistry $doctrine): Response
    {
        $weather = $this->weatherdata();
        $products1= $doctrine->getRepository(Products::class)->findBy(
            [
                'weather' => $weather,
                'style' => 'Herren'

            ]);
        $products2 = $doctrine->getRepository(Products::class)->findBy(
            [
                'weather' => $weather,
                'style' => 'Unisex'
            ]);
        $products = array_merge($products1, $products2);
        if (count($products)>=4){
            $products = array_slice($products, 0, 4);
        };

        return $this->render('bab/herren.html.twig', [
            'products' => $products
        ]);
    }
    /**
     * @Route("/damen")
     */
    public function number2(ManagerRegistry $doctrine): Response
    {
        $weather = $this->weatherdata();
        $products1= $doctrine->getRepository(Products::class)->findBy(
            [
                'weather' => $weather,
                'style' => 'Damen'

            ]);
        $products2 = $doctrine->getRepository(Products::class)->findBy(
            [
                'weather' => $weather,
                'style' => 'Unisex'
            ]);
        $products = array_merge($products1, $products2);
        if (count($products)>=4){
            $products = array_slice($products, 0, 4);
        };

        return $this->render('bab/damen.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/kinder")
     */
    public function number3(ManagerRegistry $doctrine): Response
    {
        $weather = $this->weatherdata();
        $products= $doctrine->getRepository(Products::class)->findBy(
            [
                'weather' => $weather,
                'style' => 'Kinder'

            ]);

        if (count($products)>=4){
            $products = array_slice($products, 0, 4);
        };

        return $this->render('bab/kinder.html.twig', [
            'products' => $products
        ]);
    }

    /**
    * @Route("/herren/accessoires")
    */
    public function number4(ManagerRegistry $doctrine): Response
    {

        $repository= $doctrine->getRepository(Products::class);

        $products1= $doctrine->getRepository(Products::class)->findBy(
            [
                'categorie' => "Accessoires",
                'style' => 'Herren'

            ]);
        $products2 = $doctrine->getRepository(Products::class)->findBy(
            [
                'categorie' => "Accessoires",
                'style' => 'Unisex'
            ]);
        $products = array_merge($products1, $products2);
        if (count($products)>=3){
            $products = array_slice($products, 0, 3);
        };

        return $this->render('bab/herren/hr_ac.html.twig', [
            'articles' => $products

        ]);
    }

    /**
     * @Route("/herren/oberteile")
     */
    public function number5(ManagerRegistry $doctrine): Response
    {

        $products1= $doctrine->getRepository(Products::class)->findBy(
            [
                'categorie' => "Oberteile",
                'style' => 'Herren'

            ]);
        $products2 = $doctrine->getRepository(Products::class)->findBy(
            [
                'categorie' => "Oberteile",
                'style' => 'Unisex'
            ]);
        $products = array_merge($products1, $products2);
        if (count($products)>=3){
            $products = array_slice($products, 0, 3);
        };
        return $this->render('bab/herren/hr_ob.html.twig', [
            'articles' => $products

        ]);
    }

    /**
     * @Route("/herren/hosen")
     */
    public function number6(ManagerRegistry $doctrine): Response
    {

        $products1= $doctrine->getRepository(Products::class)->findBy(
            [
                'categorie' => "Hosen",
                'style' => 'Herren'

            ]);
        $products2 = $doctrine->getRepository(Products::class)->findBy(
            [
                'categorie' => "Hosen",
                'style' => 'Unisex'
            ]);
        $products = array_merge($products1, $products2);
        if (count($products)>=3){
            $products = array_slice($products, 0, 3);
        };
        return $this->render('bab/herren/hr_ho.html.twig', [
            'articles' => $products

        ]);
    }
    /**
     * @Route("/herren/schuhe")
     */
    public function number7(ManagerRegistry $doctrine): Response
    {

        $products1= $doctrine->getRepository(Products::class)->findBy(
            [
                'categorie' => "Schuhe",
                'style' => 'Herren'

            ]);
        $products2 = $doctrine->getRepository(Products::class)->findBy(
            [
                'categorie' => "Schuhe",
                'style' => 'Unisex'
            ]);
        $products = array_merge($products1, $products2);
        if (count($products)>=3){
            $products = array_slice($products, 0, 3);
        };
        return $this->render('bab/herren/hr_ho.html.twig', [
            'articles' => $products

        ]);
    }

    /**
     * @Route("/damen/accessoires")
     */
    public function number8(ManagerRegistry $doctrine): Response
    {

        $repository= $doctrine->getRepository(Products::class);

        $products1= $doctrine->getRepository(Products::class)->findBy(
            [
                'categorie' => "Accessoires",
                'style' => 'Damen'

            ]);
        $products2 = $doctrine->getRepository(Products::class)->findBy(
            [
                'categorie' => "Accessoires",
                'style' => 'Unisex'
            ]);
        $products = array_merge($products1, $products2);
        if (count($products)>=3){
            $products = array_slice($products, 0, 3);
        };

        return $this->render('bab/damen/da_ac.html.twig', [
            'articles' => $products

        ]);
    }

    /**
     * @Route("/damen/oberteile")
     */
    public function number9(ManagerRegistry $doctrine): Response
    {

        $repository= $doctrine->getRepository(Products::class);

        $products1= $doctrine->getRepository(Products::class)->findBy(
            [
                'categorie' => "Oberteile",
                'style' => 'Damen'

            ]);
        $products2 = $doctrine->getRepository(Products::class)->findBy(
            [
                'categorie' => "Oberteile",
                'style' => 'Unisex'
            ]);
        $products = array_merge($products1, $products2);
        if (count($products)>=3){
            $products = array_slice($products, 0, 3);
        };
        return $this->render('bab/damen/da_ob.html.twig', [
            'articles' => $products

        ]);
    }

    /**
     * @Route("/damen/hosen")
     */
    public function number10(ManagerRegistry $doctrine): Response
    {

        $repository= $doctrine->getRepository(Products::class);

        $products1= $doctrine->getRepository(Products::class)->findBy(
            [
                'categorie' => "Hosen",
                'style' => 'Damen'

            ]);
        $products2 = $doctrine->getRepository(Products::class)->findBy(
            [
                'categorie' => "Hosen",
                'style' => 'Unisex'
            ]);
        $products = array_merge($products1, $products2);
        if (count($products)>=3){
            $products = array_slice($products, 0, 3);
        };
        return $this->render('bab/damen/da_ho.html.twig', [
            'articles' => $products

        ]);
    }
    /**
     * @Route("/damen/schuhe")
     */
    public function number11(ManagerRegistry $doctrine): Response
    {

        $repository= $doctrine->getRepository(Products::class);

        $products1= $doctrine->getRepository(Products::class)->findBy(
            [
                'categorie' => "Schuhe",
                'style' => 'Damen'

            ]);
        $products2 = $doctrine->getRepository(Products::class)->findBy(
            [
                'categorie' => "Schuhe",
                'style' => 'Unisex'
            ]);
        $products = array_merge($products1, $products2);
        if (count($products)>=3){
            $products = array_slice($products, 0, 3);
        };
        return $this->render('bab/damen/da_sc.html.twig', [
            'articles' => $products

        ]);
    }

    /**
     * @Route("/kinder/accessoires")
     */
    public function number12(ManagerRegistry $doctrine): Response
    {

        $products= $doctrine->getRepository(Products::class)->findBy(
            [
                'categorie' => "Accessoires",
                'style' => 'Kinder'

            ]);
        if (count($products)>=3){
            $products = array_slice($products, 0, 3);
        };

        return $this->render('bab/kinder/ki_ac.html.twig', [
            'articles' => $products

        ]);
    }

    /**
     * @Route("/kinder/oberteile")
     */
    public function number13(ManagerRegistry $doctrine): Response
    {

        $products= $doctrine->getRepository(Products::class)->findBy(
            [
                'categorie' => "Oberteile",
                'style' => 'Kinder'

            ]);
        if (count($products)>=3){
            $products = array_slice($products, 0, 3);
        };
        return $this->render('bab/kinder/ki_ob.html.twig', [
            'articles' => $products

        ]);
    }

    /**
     * @Route("/kinder/hosen")
     */
    public function number14(ManagerRegistry $doctrine): Response
    {

        $products= $doctrine->getRepository(Products::class)->findBy(
            [
                'categorie' => "Hosen",
                'style' => 'Kinder'

            ]);
        if (count($products)>=3){
            $products = array_slice($products, 0, 3);
        };
        return $this->render('bab/kinder/ki_ho.html.twig', [
            'articles' => $products

        ]);
    }
    /**
     * @Route("/kinder/schuhe")
     */
    public function number15(ManagerRegistry $doctrine): Response
    {

        $products= $doctrine->getRepository(Products::class)->findBy(
            [
                'categorie' => "Schuhe",
                'style' => 'Kinder'

            ]);
        if (count($products)>=3){
            $products = array_slice($products, 0, 3);
        };
        return $this->render('bab/kinder/ki_sc.html.twig', [
            'articles' => $products

        ]);
    }


}