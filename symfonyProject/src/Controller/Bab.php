<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use App\Entity\Products;
use Doctrine\Persistence\ManagerRegistry;


class Bab extends AbstractController
{
    /**
     * @Route("/bab")
     */
    public function number(ManagerRegistry $doctrine): Response
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://api.openweathermap.org/data/2.5/weather?lat=48&lon=8&appid=52f93fcb3972dd3f203176c66178aa35');
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
            echo 'its Raining';
            $weather = "Regen";
        }
        else {
            if($tempe <= 10){
                echo "UAAAAA";
                $weather = "Kalt";
            }
            elseif($tempe <= 25){
                echo "MUAAA";
                $weather = "Normal";
            }
            else{
                echo "I am melting";
                $weather = "Warm";
            }
        }

        $repository= $doctrine->getRepository(Products::class);

        $products= $doctrine->getRepository(Products::class)->findBy(
            [
                'weather' => $weather,
            ]);






        $articles = [
            '0' => ['title' => 'Frühling', 'body' => 'Der Frühling beginnt ...'],
            '1' => ['title' => 'Sommer', 'body' => 'Der Sommert ist ...'],
            '2' => ['title' => 'Herbst', 'body' => 'Der Herbst wird...'],
            '3' => ['title' => 'Winter', 'body' => 'Der Winter war...']
        ];
        return $this->render('bab/first.html.twig', [
            'articles' => $articles,
            'products' => $products
        ]);
    }
    /**
     * @Route("/herren")
     */
    public function number1(ManagerRegistry $doctrine): Response
    {



        $articles = [
            '0' => ['title' => 'Frühling', 'body' => 'Der Frühling beginnt ...'],
            '1' => ['title' => 'Sommer', 'body' => 'Der Sommert ist ...'],
            '2' => ['title' => 'Herbst', 'body' => 'Der Herbst wird...'],
            '3' => ['title' => 'Winter', 'body' => 'Der Winter war...']
        ];
        return $this->render('bab/herren.html.twig', [
            'articles' => $articles

        ]);
    }
    /**
     * @Route("/damen")
     */
    public function number2(): Response
    {
        $articles = [
            '0' => ['title' => 'Frühling', 'body' => 'Der Frühling beginnt ...'],
            '1' => ['title' => 'Sommer', 'body' => 'Der Sommert ist ...'],
            '2' => ['title' => 'Herbst', 'body' => 'Der Herbst wird...'],
            '3' => ['title' => 'Winter', 'body' => 'Der Winter war...']
        ];
        return $this->render('bab/damen.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/kinder")
     */
    public function number3(): Response
    {
        $articles = [
            '0' => ['title' => 'Frühling', 'body' => 'Der Frühling beginnt ...'],
            '1' => ['title' => 'Sommer', 'body' => 'Der Sommert ist ...'],
            '2' => ['title' => 'Herbst', 'body' => 'Der Herbst wird...'],
            '3' => ['title' => 'Winter', 'body' => 'Der Winter war...']
        ];
        return $this->render('bab/kinder.html.twig', [
            'articles' => $articles
        ]);
    }
}