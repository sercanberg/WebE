<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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