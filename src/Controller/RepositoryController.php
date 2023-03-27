<?php

namespace App\Controller;

use App\Entity\Allergene;
use App\Entity\Plat;
use App\Entity\Reservation;
use App\Repository\AllergeneRepository;
use App\Repository\PlatRepository;
use App\Repository\ReservationRepository;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RepositoryController extends AbstractController
{
    private $myreservationRepository;
    public function __construct(ReservationRepository $reservationRepository)
    {
        $this->myreservationRepository = $reservationRepository;
    }


    /**
     * @Route("/repository", name="app_repository")
     */
    public function index(): Response
    {
        $reservations = $this->myreservationRepository->findBy(['etat'=> Reservation::ETAT_ANNULE, 'utilisateur'=> 2]);
        dump($reservations);
    }


    /**
     * @Route("/count-reservation")
     */
    //Compter les réservations annulées
    public function countResaAnnulee (ReservationRepository $repository): Response
    {
        $countResa = $repository->count(['etat'=> Reservation::ETAT_ANNULE]);
        dump($countResa);
    }

    /**
     * @Route("/count-resa-utils")
     */
    //compter les réservations d'un utilisateur
    public function countResaParUtils (ReservationRepository $repository): Response
    {
        $resaUtils = $repository->count(['utilisateur'=> 2]);
        dump($resaUtils);
    }

    /**
     * @Route("/trouver-utilisateur")
     */
    //trouver resa dont le nom du client est priscillia
    public function trouverUtilsResa (ReservationRepository $repository)
    {
        $trouverUtils = $repository->findBy(['nomClient'=>'Prisci']);
        dump($trouverUtils);
    }

    /**
     * @Route("/trouver-utils")
     */
    //trouver tout les utilisateurs
    public function listUtils (UtilisateurRepository $repository): Response
    {
        $listUtils = $repository->findAll();
        dump($listUtils);
    }

    /**
     * @Route("/recup-utils-par-id")
     */
    //Recupérer l'utilisateur d'id 1
    public function recupUtilsParId (UtilisateurRepository $repository): Response
    {
        $utilsParId = $repository->findOneBy(['id'=>1]);
        dump($utilsParId);
    }

    /**
     * @Route("/ajout-resa")
     */
    //dans une fonction, ajouter une nouvelle réservation pour priscillia (utiliser les repository utilisateur et reservation)
    public function ajoutResa (ReservationRepository $reservationRepository, UtilisateurRepository $utilisateurRepository):Response
    {
        $utilisateur = $utilisateurRepository->findOneBy(['email'=>'priscillia.epiphane@gmail.com']);
        dump($utilisateur);
        $newResa = new Reservation();
        $newResa->setNomClient('Priscillia');
        $newResa->setDateEtHeureArrivee(new \DateTime());
        $newResa->setCommentaire('ma réservation');
        $newResa->setEtat(Reservation::ETAT_CONFIRME);
        $newResa->setUtilisateur($utilisateur);
        $reservationRepository->add($newResa, true);
        //ajoute une entité pb
        /*$newResa = $reservationRepository->add(['utilisateurId'=> $trouverId['id'],'date'=> new \DateTime(), 'etat'=>Reservation::ETAT_CONFIRME, 'commentaire'=> 'blabla'
        , 'nomClient'=> 'priscillia']);*/
    }

    /**
     * @Route("/supp-resa")
     */
    public function suppResa (ReservationRepository $reservationRepository): Response
    {
        $suppResa = $reservationRepository->find(7);
        $reservationRepository->remove($suppResa, true);
    }

    /**
     * @Route("/inject-plat-allergene")
     */
    //injecter des repository pour persister un plat et deux allergènes en injectant un EM qui fera le flush final
    public function injectPlatAllergene (PlatRepository $platRepository, AllergeneRepository $allergeneRepository, EntityManagerInterface $entityManager):Response
    {
        //utiliser add sur les repository et mettre false en bool?
        $newPlat = new Plat();
        $newPlat->setNom('Hamburger');
        $newPlat->setCategorie('plat');
        $newPlat->setDescription('Steach haché AOP, Gruyère suisse');
        $newPlat->setPrix(25);
        $platRepository->add($newPlat, false);
        $newAllergene = new Allergene();
        $newAllergene->setNom('crevette');
        $allergeneRepository->add($newAllergene, false);

        $entityManager->flush();
    }
}
