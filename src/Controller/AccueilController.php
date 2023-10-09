<?php

namespace App\Controller;

use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Description of AccueilController
 *
 * @author AurelienSauzet
 */
class AccueilController extends AbstractController {
    
    /**
     * 
     * @var VisiteRepository
     */
    private $repository;
    
    /**
     * 
     * @param VisiteRepository $repository
     */
    public function __construct(VisiteRepository $repository) {
        $this->repository = $repository;
    }
    
    /**
     * @Route("/", name="accueil")
     * @return Response
     */
    public function index(): Response {
        $visites = $this->repository->findLast('datecreation', 2);
        return $this->render('pages/accueil.html.twig', [
            'visites' => $visites
        ]);
    }
}
