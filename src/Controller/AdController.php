<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Repository\AdRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;

class AdController extends AbstractController
{
    #[Route('/new', name: 'app_new')]
    public function new(Request $request, EntityManagerInterface $entityManager, AdRepository $adRepository, FileUploader $fileUploader): Response
    {
        $ad  = new Ad();

        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);
        $ad->setAuthor($this->getUser())
            ->setDate(new \DateTime());

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $pictureFile */
            $pictureFile = $form->get('picture')->getData();
            if ($pictureFile) {
                $pictureFileName = $fileUploader->upload($pictureFile);
                $ad->setPictureFilename($pictureFileName);
            }

            $entityManager->persist($ad);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Votre annonce a été publiée avec succès !'
            );

            return $this->redirectToRoute('app_home');
        }

        return $this->render('ad/new.html.twig', [
            'form' => $form->createView(),
            'ad' => $ad
        ]);
    }
}
