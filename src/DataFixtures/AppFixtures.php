<?php

namespace App\DataFixtures;

use App\Entity\Allergene;
use App\Entity\Utilisateur;
use App\Repository\AllergeneRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private $myAllergeneRepository;
    private $hasher;

    /**
     * @param $hasher
     */
    public function __construct(UserPasswordHasherInterface $hasher, AllergeneRepository $allergeneRepository)
    {
        $this->myAllergeneRepository = $allergeneRepository;
        $this->hasher = $hasher;
    }


    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $newAllergene = new Allergene();
        $newAllergene->setNom('Sucre');
        $this->myAllergeneRepository->add($newAllergene, false);
        $newAllergene = new Allergene();
        $newAllergene->setNom('Gluten');
        $manager->persist($newAllergene);
        $newAllergene = new Allergene();
        $newAllergene->setNom('Lactose');
        $manager->persist($newAllergene);

        $newAdmin = new Utilisateur();
        $newAdmin->setEmail('prisci@gmail.com')->setRoles(['ROLE_ADMIN']);
        $passwordCrypte = $this->hasher->hashPassword($newAdmin, '123456');
        $newAdmin->setPassword($passwordCrypte);
        $manager->persist($newAdmin);

        $manager->flush();


    }
}
