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
use Symfony\Component\Validator\Constraints\Optional;


class Bab extends AbstractController
{
    public function weatherdata(): string
    {
        # Get weatherdata and interpret it
        $client = HttpClient::create();
        $response = $client->request('GET', 'https://api.openweathermap.org/data/2.5/weather?lat=49.5&lon=8.5&appid=52f93fcb3972dd3f203176c66178aa35');
        // Grönland = lat=83&lon=-32 ; Mannheim lat=49.5&lon=8.5
        $statusCode = $response->getStatusCode();
        $contentType = $response->getHeaders()['content-type'][0];
        $content = $response->getContent();
        $content = $response->toArray();
        $content["main"]["temp"]=$content["main"]["temp"]-273.15;
        $tempe = $content["main"]["temp"];
        $sky = $content["weather"]["0"]["main"];

        if ($sky == "Rain"){
            $weather = "Regen";
        }
        else {
            if($tempe <= 10){
                $weather = "Kalt";
            }
            else{
                $weather = "Normal";
            }
        }
        return $weather;
    }

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

    # get different types of clothes depending on the site...

    /**
     * @Route("/bab")
     */
    public function home(ManagerRegistry $doctrine): Response
    {
        $username = $this->get_user();
        $weather = $this->weatherdata();
        $products= $doctrine->getRepository(Products::class)->findBy(
            [
                'weather' => $weather,
            ]);
        if (count($products)>=4){
            $products = array_slice($products, 0, 4);
        };
        return $this->render('bab/first.html.twig', [
            'products' => $products,
            'username' => $username
        ]);
    }
    /**
     * @Route("/herren")
     */
    public function herren_haupt(ManagerRegistry $doctrine): Response
    {
        $username = $this->get_user();
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
            'products' => $products,
            'username' => $username
        ]);
    }
    /**
     * @Route("/damen")
     */
    public function damen_haupt(ManagerRegistry $doctrine): Response
    {
        $username = $this->get_user();
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
            'products' => $products,
            'username' => $username
        ]);
    }

    /**
     * @Route("/kinder")
     */
    public function kinder_haupt(ManagerRegistry $doctrine): Response
    {
        $username = $this->get_user();
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
            'products' => $products,
            'username' => $username
        ]);
    }

    /**
    * @Route("/herren/accessoires")
    */
    public function hr_ac(ManagerRegistry $doctrine): Response
    {
        $username = $this->get_user();
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

        return $this->render('bab/herren/hr_ac.html.twig', [
            'articles' => $products,
            'username' => $username

        ]);
    }

    /**
     * @Route("/herren/oberteile")
     */
    public function hr_ob(ManagerRegistry $doctrine): Response
    {
        $username = $this->get_user();
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

        return $this->render('bab/herren/hr_ob.html.twig', [
            'articles' => $products,
            'username' => $username

        ]);
    }

    /**
     * @Route("/herren/hosen")
     */
    public function hr_ho(ManagerRegistry $doctrine): Response
    {
        $username = $this->get_user();
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

        return $this->render('bab/herren/hr_ho.html.twig', [
            'articles' => $products,
            'username' => $username

        ]);
    }
    /**
     * @Route("/herren/schuhe")
     */
    public function hr_sc(ManagerRegistry $doctrine): Response
    {
        $username = $this->get_user();
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

        return $this->render('bab/herren/hr_ho.html.twig', [
            'articles' => $products,
            'username' => $username

        ]);
    }

    /**
     * @Route("/damen/accessoires")
     */
    public function da_ac(ManagerRegistry $doctrine): Response
    {
        $username = $this->get_user();
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

        return $this->render('bab/damen/da_ac.html.twig', [
            'articles' => $products,
            'username' => $username

        ]);
    }

    /**
     * @Route("/damen/oberteile")
     */
    public function da_ob(ManagerRegistry $doctrine): Response
    {
        $username = $this->get_user();
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

        return $this->render('bab/damen/da_ob.html.twig', [
            'articles' => $products,
            'username' => $username

        ]);
    }

    /**
     * @Route("/damen/hosen")
     */
    public function da_ho(ManagerRegistry $doctrine): Response
    {
        $username = $this->get_user();
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

        return $this->render('bab/damen/da_ho.html.twig', [
            'articles' => $products,
            'username' => $username

        ]);
    }
    /**
     * @Route("/damen/schuhe")
     */
    public function da_sc(ManagerRegistry $doctrine): Response
    {
        $username = $this->get_user();
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

        return $this->render('bab/damen/da_sc.html.twig', [
            'articles' => $products,
            'username' => $username

        ]);
    }

    /**
     * @Route("/kinder/accessoires")
     */
    public function ki_ac(ManagerRegistry $doctrine): Response
    {
        $username = $this->get_user();
        $products= $doctrine->getRepository(Products::class)->findBy(
            [
                'categorie' => "Accessoires",
                'style' => 'Kinder'

            ]);

        return $this->render('bab/kinder/ki_ac.html.twig', [
            'articles' => $products,
            'username' => $username

        ]);
    }

    /**
     * @Route("/kinder/oberteile")
     */
    public function ki_ob(ManagerRegistry $doctrine): Response
    {
        $username = $this->get_user();
        $products= $doctrine->getRepository(Products::class)->findBy(
            [
                'categorie' => "Oberteile",
                'style' => 'Kinder'

            ]);

        return $this->render('bab/kinder/ki_ob.html.twig', [
            'articles' => $products,
            'username' => $username

        ]);
    }

    /**
     * @Route("/kinder/hosen")
     */
    public function ki_ho(ManagerRegistry $doctrine): Response
    {
        $username = $this->get_user();
        $products= $doctrine->getRepository(Products::class)->findBy(
            [
                'categorie' => "Hosen",
                'style' => 'Kinder'

            ]);

        return $this->render('bab/kinder/ki_ho.html.twig', [
            'articles' => $products,
            'username' => $username

        ]);
    }
    /**
     * @Route("/kinder/schuhe")
     */
    public function ki_sc(ManagerRegistry $doctrine): Response
    {
        $username = $this->get_user();
        $products= $doctrine->getRepository(Products::class)->findBy(
            [
                'categorie' => "Schuhe",
                'style' => 'Kinder'

            ]);

        return $this->render('bab/kinder/ki_sc.html.twig', [
            'articles' => $products,
            'username' => $username

        ]);
    }


}