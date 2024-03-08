<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasherInterface)
    {
        $this->passwordHasher = $userPasswordHasherInterface;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User;
        $admin
            ->setEmail('admin@todolist.com')
            ->setUsername('admin')
            ->setPassword($this->passwordHasher->hashPassword($admin, 'admin'))
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($admin);


        $userTest = new User;
        $userTest
            ->setEmail('test@todolist.com')
            ->setUsername('test')
            ->setPassword($this->passwordHasher->hashPassword($userTest, 'test'));

        $manager->persist($userTest);


        $user = new User;
        $user
            ->setEmail('anonymous@todolist.com')
            ->setUsername('anonymous')
            ->setPassword($this->passwordHasher->hashPassword($user, 'anonymous'));

        $manager->persist($user);

        $tasks = [
            [
                'title' => 'Faire les courses',
                'description' => 'Acheter des fruits, l\'égumes, et produits de première nécessité.',
                'done' => 1
            ],
            [
                'title' => 'Répondre aux e-mails',
                'description' => 'Vérifier et répondre aux e-mails professionnels et personnels.',
                'done' => 1
            ],
            [
                'title' => 'Préparer la présentation',
                'description' => 'Compiler les données et créer une présentation pour la réunion de demain.',
                'done' => 1
            ],
            [
                'title' => 'Faire de l\'exercice',
                'description' => 'Aller à la salle de sport ou faire une séance d\'exercices à la maison.',
                'done' => 1
            ],
            [
                'title' => 'Lire un livre',
                'description' => 'Passer du temps à lire un livre intéressant pour se détendre.',
                'done' => 0
            ],
            [
                'title' => 'Mettre à jour le site web',
                'description' => 'Ajouter de nouveaux contenus et effectuer des mises à jour sur le site internet.',
                'done' => 0
            ],
            [
                'title' => 'Organiser le bureau',
                'description' => 'Nettoyer et organiser le bureau pour une meilleure productivité.',
                'done' => 1
            ],
            [
                'title' => 'Apprendre une nouvelle compétence',
                'description' => 'Allouer du temps pour apprendre quelque chose de nouveau, comme une langue ou une compétence technique.',
                'done' => 0
            ],
            [
                'title' => 'Planifier les vacances',
                'description' => 'Commencer à planifier les prochaines vacances, y compris la réservation de l\'hébergement.',
                'done' => 0
            ],
            [
                'title' => 'Rendre visite à un ami',
                'description' => 'Prendre le temps de rendre visite à un ami ou un membre de la famille.',
                'done' => 1
            ],
        ];

        foreach ($tasks as $task) {
            $taskEntity = new Task;
            $taskEntity
                ->setTitle($task['title'])
                ->setContent($task['description'])
                ->setUser($user)
                ->toggle($task['done']);

            $manager->persist($taskEntity);
        }

        $manager->flush();
    }
}
