<?php

namespace App\Controller;

use App\Entity\Formule;
use App\Entity\Plat;
use App\Entity\Horaire;
use App\Repository\HoraireRepository;
use App\Repository\ImageRepository;
use App\Repository\PlatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class VisiteurController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function index(ImageRepository $imageRepository, HoraireRepository $horaireRepository): Response
    {
        $images = $imageRepository->findAll();
        $horaires = $horaireRepository->findAll();
        return $this->render('visiteur/index.html.twig', [
            'images' => $images,
            'horaires' => $horaires
        ]);
    }

    /**
     * @Route("/carte", name="app_carte")
     */

    public function show(PlatRepository $platRepository, HoraireRepository $horaireRepository): Response
    {
        $entrees = $platRepository->findBy(['categorie' => 'Entrée']);
        $plats = $platRepository->findBy(['categorie'=> 'Plat']);
        $desserts = $platRepository->findBy(['categorie'=> 'Dessert']);
        $horaires = $horaireRepository->findAll();
        return $this->render('visiteur/show.html.twig', [
            'entrees' => $entrees,
            'plats' => $plats,
            'desserts' => $desserts,
            'horaires' => $horaires
            ]);
    }

}




