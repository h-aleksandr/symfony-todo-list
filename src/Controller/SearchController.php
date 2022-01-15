<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\HttpFoundation\JsonResponse;

class SearchController extends AbstractController
{
     #[Route('/search', name: 'task_search', methods: ['GET', 'POST'])]
    public function searchByDate(Request $request, TaskRepository $taskRepository): Response
    {
        if ($request){
                // $searched = $taskRepository->findByDate(new \DateTime($request->getContent()));
                
        }
            $searched = 'Noting was found';

            return new JsonResponse(['url' => $this->generateUrl('home'), 'tasks' => $taskRepository->findByDate(new \DateTime($request->getContent())),]
    );

        return $this->render('base.html.twig', [
                'searched' => $searched,
                'title' => 'Searched task',
        ]);
    }
}
