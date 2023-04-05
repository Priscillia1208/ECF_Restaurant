<?php

namespace App\Service;

use App\Entity\Horaire;
use App\Entity\Reservation;
use App\Repository\HoraireRepository;
use App\Repository\ReservationRepository;
use App\Repository\TableRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\True_;

class ReservationService
{
    private $horaireRep;
    private $tableRep;
    private $reservationRep;
    private $em;

    public function __construct(HoraireRepository $horaireRepository, TableRepository $tableRepository,
                                ReservationRepository $reservationRepository, EntityManagerInterface $entityManager)
    {
        $this->horaireRep = $horaireRepository;
        $this->tableRep = $tableRepository;
        $this->reservationRep = $reservationRepository;
        $this->em = $entityManager;
    }


    /**
     * Renvoie un tableau associatif:
     * 'midi': [12,12h15,13,]
     * 'soir': [19h,19h45,21]
     * @param \DateTime $dateTime
     * @param boolean $midi
     * @param int $nbCouverts
     * @return array
     * @throws \Exception
     */
    public function rechercherDispos (\DateTime $debut, \DateTime $fin, int $nbCouverts): array{
        $tablesAReserver = [];

        #$tables = Lister tables sans resa ou  annulées à la date donnée, dans l'ordre croissant du nbre de couverts
        /*$jourMoisAnnee=$dateTime->format("d-m-Y");
        if($midi){

            // Récupère date minuit et date 23:59:59    Y-m-d H:i:s

            $debut = \DateTime::createFromFormat("d-m-Y H:i:s", $jourMoisAnnee . ' 12:00:00');
            $fin = \DateTime::createFromFormat("d-m-Y H:i:s", $jourMoisAnnee . ' 14:00:00');
        }else {
            $debut = \DateTime::createFromFormat("d-m-Y H:i:s", $jourMoisAnnee . ' 19:00:00');
            $fin = \DateTime::createFromFormat("d-m-Y H:i:s", $jourMoisAnnee . ' 22:00:00');
        }*/

        $tables = $this->tableRep->listeTablesDispoParNbCouvertsCroissant($debut, $fin);

        #quitte la fonction si $tables est vide

        if (count($tables) == 0){
            throw new \Exception("Aucune table disponible");
        }

        #$tablesNbCouvertsRequisOuPlus : filtre celles qui ont le nbre de couverts requis ou plus
        $tablesNbCouvertsRequisOuPlus = array_filter($tables, function($tableActuelle) use ($nbCouverts){
            if ($tableActuelle->getNbPlaces() >= $nbCouverts){
                return true;
            } else {
                return false;
            }
        });

        #Si pas de table trouvée, sélectionne plusieurs tables pour assurer la réservation ou quitte si il n'y en a pas assez
        if (count($tablesNbCouvertsRequisOuPlus) == 0) {
            $nbPlacesReservees = 0;
            foreach ($tables as $table){
                if ($nbPlacesReservees < $nbCouverts){
                    $nbPlacesReservees += $table->getNbPlaces();
                    $tablesAReserver[] = $table;
                }
            }

            #quitte si pas assez de couverts dispo
            if ($nbPlacesReservees < $nbCouverts){
                throw new \Exception("Aucune combinaison de table suffisante");
            }
        } else { #si il existe une table de disponible, prends la première de la liste

            $tablesAReserver[] = $tablesNbCouvertsRequisOuPlus[0];
        }

        #Création réservation et lui asocie les tables à réserver
        $nouvelleResa = new Reservation();
        $nouvelleResa->setDateEtHeureArrivee();



    }

}