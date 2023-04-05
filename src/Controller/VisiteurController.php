<?php

namespace App\Controller;

use App\Entity\Formule;
use App\Entity\Plat;
use App\Entity\Horaire;
use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Form\ReservationVisiteurType;
use App\Repository\FormuleRepository;
use App\Repository\HoraireRepository;
use App\Repository\ImageRepository;
use App\Repository\PlatRepository;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

    public function show(PlatRepository $platRepository, HoraireRepository $horaireRepository, FormuleRepository $formuleRepository): Response
    {
        $entrees = $platRepository->findBy(['categorie' => 'Entrée']);
        $plats = $platRepository->findBy(['categorie'=> 'Plat']);
        $desserts = $platRepository->findBy(['categorie'=> 'Dessert']);
        $formules = $formuleRepository->findAll();
        $horaires = $horaireRepository->findAll();
        return $this->render('visiteur/show.html.twig', [
            'entrees' => $entrees,
            'plats' => $plats,
            'desserts' => $desserts,
            'formules' => $formules,
            'horaires' => $horaires
            ]);
    }

    /**
     * @Route("/reservation", name="app_reservation")
     *
     */

    public function reservation(ReservationRepository $reservationRepository, PlatRepository $platRepository, HoraireRepository $horaireRepository, Request $request){
        $horaires = $horaireRepository->findAll();

        $reservation = new Reservation();
        $form = $this->createForm(ReservationVisiteurType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted()){

        }

        return $this->renderForm('visiteur/reservationVisiteur.html.twig', [
            'horaires'=> $horaires,
            'heuresReservationMidi' => ['12:00', '12:15', '12:30', '12h45', '13:00', '13:15', '13:30'],
            'heuresReservationSoir' => ['19:00', '19:15', '19:30', '19h45', '20:00', '20:15', '20:30', '20:45','21:00', '21:15', '21:30'],
            'formulaire'=> $form
        ]);
    }

}




