<?php

namespace App\Controller;

use App\Repository\AdRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_ads')]
    public function index(AdRepository $adRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $donnees = $adRepository->findAll();
        $ads = $paginator->paginate(
            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3 // Nombre de résultats par page
        );

        return $this->render('home/index.html.twig', [
            'ads' => $ads,
        ]);
    }

    #[Route('/ad/{id}', name: 'app_show')]
    public function show(AdRepository $adRepository, int $id): Response
    {
        $ad = $adRepository->findOneBy(['id' => $id]);

        return $this->render('home/show.html.twig', [
            'ad' => $ad,
        ]);
    }
}

