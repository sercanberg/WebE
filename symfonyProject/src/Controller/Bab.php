<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;




class Bab extends AbstractController
{
    /**
     * @Route("/bab")
     */
    public function number(): Response
    {
        $articles = [
            '0' => ['title' => 'Frühling', 'body' => 'Der Frühling beginnt ...'],
            '1' => ['title' => 'Sommer', 'body' => 'Der Sommert ist ...'],
            '2' => ['title' => 'Herbst', 'body' => 'Der Herbst wird...'],
            '3' => ['title' => 'Winter', 'body' => 'Der Winter war...']
        ];
        return $this->render('bab/first.html.twig', [
            'articles' => $articles
        ]);
    }
    /**
     * @Route("/herren")
     */
    public function number1(): Response
    {
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://api.wheretheiss.at/v1/satellites/25544');
        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]



        $articles = [
            '0' => ['title' => 'Frühling', 'body' => 'Der Frühling beginnt ...'],
            '1' => ['title' => 'Sommer', 'body' => 'Der Sommert ist ...'],
            '2' => ['title' => 'Herbst', 'body' => 'Der Herbst wird...'],
            '3' => ['title' => 'Winter', 'body' => 'Der Winter war...']
        ];
        return $this->render('bab/herren.html.twig', [
            'articles' => $articles,
            'response' => $content
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