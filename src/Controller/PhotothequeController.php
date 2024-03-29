<?php

namespace App\Controller;

use App\Entity\Parametre;
use App\Entity\Phototheque;
use App\Form\PhotothequeType;
use App\Service\RedimensionneService;
use App\Repository\PhotothequeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/phototheque')]
class PhotothequeController extends AbstractController
{
    public function __construct(Private RedimensionneService $redimensionneService)
    {
        
    }
    
    #[Route('/new-phototheque/{id}', name: 'app_phototheque', methods: ['POST','GET'])]
    public function index(Parametre $parametre,PhotothequeRepository $photothequeRepository, Request $request , SluggerInterface $slugger): Response
    {
        $phototheque = new Phototheque();
        $form = $this->createForm(PhotothequeType::class, $phototheque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
                $image = $form->get('libelle')->getData();
                if ($image)
                {
                    //récuperer la taille de l'image à inserrer
                    $size = $image->getSize();
                    //vérifier si l'image est supérieur à 2 Mo alors un message d'erreur
                    if($size > 2*1024*1024)
                    {
                        $this->addFlash("error", "Désolé la taille de l'image est > 2 Mo, veuillez compresser la photo !");
                        return $this->redirectToRoute('app_phototheque', ['id' => $parametre->getId()]);
                    }else{
                        $originalePhoto = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME); 
                        $safePhotoname = $slugger->slug($originalePhoto);
                        $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $image->guessExtension();
                        try {
                            $image->move(
                                $this->getParameter('image_phototheque'),
                                $newPhotoname
                            );
                        } catch (FileException $e){}

                        $directory= $this->getParameter('kernel.project_dir').'/public/phototheques'.'/'.$newPhotoname;
                        $this->redimensionneService->resize($directory);
                        $phototheque->setLibelle($newPhotoname);
                    }
                }

            $phototheque->setParametre($parametre);
            $photothequeRepository->save($phototheque, true);
            
            return $this->redirectToRoute('app_phototheque', [
                'id' => $parametre->getId()
            ]);
        }

        return $this->render('phototheque/index.html.twig', [
            'form' => $form->createView(),
            'parametre' => $parametre
        ]);
    }

    //la fonction qui supprime les plaques
    #[Route('/phototheque-supprimer/{id}', name: 'app_delete_plaque', methods: ['GET'])]
    public function deletePhototheque(Phototheque $phototheque, PhotothequeRepository $photothequeRepository): Response
    {
        $id = $phototheque->getParametre()->getId();
        if($phototheque)
        {
            $nom = $phototheque->getLibelle();
            unlink($this->getParameter('image_phototheque').'/'.$nom);
            $photothequeRepository->remove($phototheque, true);
            return $this->redirectToRoute('app_phototheque', ['id' => $id], Response::HTTP_SEE_OTHER);
        }
        else
        {
            return $this->redirectToRoute('app_phototheque', ['id' => $id], Response::HTTP_SEE_OTHER);
        } 
    }
}
