<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\User;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * L'utilisateur est l'auteur ?
     */
    public function isAuthor(Task $task): bool
    {
        /* Si l'auteur n'est pas le même, on empêche la modification */
        if ($task->getUser() != $this->getUser()) {
            return false;
        }

        return true;
    }

    #[Route(path: '/tasks', name: 'task_list', methods: ['GET'])]
    public function listAction(TaskRepository $taskRepository)
    {
        return $this->render('task/list.html.twig', ['tasks' => $taskRepository->findAll()]);
    }

    #[Route(path: '/tasks/create', name: 'task_create', methods: ['GET', 'POST'])]
    public function createAction(Request $request)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setUser($this->getUser());

            $this->em->persist($task);
            $this->em->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route(path: '/tasks/{id}/edit', name: 'task_edit', methods: ['GET', 'POST'])]
    public function editAction(Task $task, Request $request)
    {
        /* Si l'auteur n'est pas le même, on empêche la modification */
        if (!$this->isAuthor($task)) {
            $this->addFlash('error', 'Vous n\'êtes pas l\'auteur de cette tâche.');
            return $this->redirectToRoute('task_list');
        }

        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    #[Route(path: '/tasks/{id}/toggle', name: 'task_toggle', methods: ['GET', 'POST'])]
    public function toggleTaskAction(Task $task)
    {
        /* Si l'auteur n'est pas le même, on empêche la modification */
        if (!$this->isAuthor($task)) {
            $this->addFlash('error', 'Vous n\'êtes pas l\'auteur de cette tâche.');
            return $this->redirectToRoute('task_list');
        }

        $task->toggle(!$task->isDone());
        $this->em->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    #[Route(path: '/tasks/{id}/delete', name: 'task_delete', methods: ['GET', 'POST', 'DELETE'])]
    public function deleteTaskAction(Task $task)
    {

        /* --> Si l'utilisateur est admin et que l'auteur est anonyme, on peut supprimer */
        if ($this->isGranted('ROLE_ADMIN') && $task->getUser()->getUsername() == 'anonymous') {
            $this->em->remove($task);
            $this->em->flush();

            $this->addFlash('success', 'La tâche a bien été supprimée.');
            return $this->redirectToRoute('task_list');
        }

        /* --> Si l'auteur n'est pas le même, on empêche la modification */
        if (!$this->isAuthor($task)) {
            $this->addFlash('error', 'Vous n\'êtes pas l\'auteur de cette tâche.');
            return $this->redirectToRoute('task_list');
        }

        $this->em->remove($task);
        $this->em->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}
