<?php

namespace App\Controller;

use App\Repository\DeadlineRepository;
use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'api_')]
class ApiController extends AbstractController
{

    public function __construct(private EntityManagerInterface $em, private DeadlineRepository $deadlineRepository)
    {  
    }

    #[Route('/nextdeadlines', name: 'next_deadlines')]
    public function nextDeadlines(): Response
    {

        //calculates the number of days until Friday of next week
        $today = new DateTime();
        $nbDayNextFriday = 0;

        if($today->format('w') < 5) {
            $nbDayNextFriday = 5 - $today->format('w') + 7;
        } else if($today->format('w') > 5) {
            $nbDayNextFriday = 7 - 1;
        } else {
            $nbDayNextFriday = 7;
        }

        $nextFriday = new DateTime();
        $nextFriday = $nextFriday->modify('+' . $nbDayNextFriday . ' days');

        //Use Doctrine to retrieve deadlines until Friday of next week that are not yet closed
        $deadlinesDoctrine = $this->deadlineRepository->findByNotDoneAndNextFriday($nextFriday);
        $deadlines = [];


        //Loop to build the next deadlines table
        foreach($deadlinesDoctrine as $deadline) {

    
            $interval = $deadline->getDueDate()->diff($today);

            $deadlineTemp = [
                'title' => $deadline->getTitle(),
                'nb_day' => $today > $deadline->getDueDate() ? $interval->days . ' jour(s) de retard' : $interval->days . ' jour(s)',
                'flag' => $today > $deadline->getDueDate() ? 'EN RETARD' : '',
                'due_date' => $deadline->getDueDate()->format('d/m/Y')
            ];

            array_push($deadlines, $deadlineTemp);
        }


        //returns the table in json format
        return $this->json($deadlines);
    }

    #[Route('/alldeadlines', name: 'all_deadlines')]
    public function allDeadlines(): Response
    {

        $today = new DateTime();

        //Use Doctrine to retrieve all unclosed deadlines
        $deadlinesDoctrine = $this->deadlineRepository->findBy([
            'is_done' => false
        ]);
        $deadlines = [];


        //Loop to build the next deadlines table
        foreach($deadlinesDoctrine as $deadline) {

    
            $interval = $deadline->getDueDate()->diff($today);

            $deadlineTemp = [
                'title' => $deadline->getTitle(),
                'nb_day' => $today > $deadline->getDueDate() ? $interval->days . ' jour(s) de retard' : $interval->days . ' jour(s)',
                'flag' => $today > $deadline->getDueDate() ? 'EN RETARD' : '',
                'due_date' => $deadline->getDueDate()->format('d/m/Y')
            ];

            array_push($deadlines, $deadlineTemp);
        }


        //returns the table in json format
        return $this->json($deadlines);
    }
}
