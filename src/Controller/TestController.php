<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Utilisateur;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test-delete")
     */
    public function delete (EntityManagerInterface $entityManager){
        $resa = $entityManager->find(Reservation::class, 2);
        $entityManager->remove($resa);
        $entityManager->flush();

    }


    /**
     * @Route("/test-persist")
     */
    public function persist (EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservation();
        $reservation->setEtat(Reservation::ETAT_CONFIRME);
        $reservation->setCommentaire('blabla');
        $reservation->setDateEtHeureArrivee(new \DateTime())->setNomClient('Prisci');
        $thomas = $entityManager->find(Utilisateur::class, 1);
        $thomas->addReservation($reservation);
        $entityManager->persist($reservation);
        $entityManager->flush();
    }

    /**
     * @Route("/test-entity-manager")
     */
    public function testEntityManager(EntityManagerInterface $entityManager): Response
    {
       $reservation = $entityManager->find(Reservation::class, 1);
       $utilisateur = $entityManager->find(Utilisateur::class, 2);
       $reservation->setUtilisateur($utilisateur);
       $reservation->setEtat(Reservation::ETAT_ANNULE);

       $entityManager->flush();
    }

    /**
     * @Route("/test-add-utilisateur")
     */
    public function addIdUtilisateur (EntityManagerInterface $entityManager): Response
    {
        $utilisateur = new Utilisateur();
        $utilisateur->setEmail('nb@gmail.com');
        $utilisateur->setRoles([]);
        $utilisateur->setPassword('123');
        $entityManager->persist($utilisateur);
        $entityManager->flush();
    }

    /**
     * @Route("/test-ajout-id-utilisateur")
     */
    public function testAjoutUtilisateurResa (EntityManagerInterface $entityManager): Response
    {
        $reservation = $entityManager->find(Reservation::class, 5);
        $utilisateur = $entityManager->find(Utilisateur::class, 2);
        $reservation->setUtilisateur($utilisateur);
        $entityManager->flush();
    }
}
