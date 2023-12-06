<?php

namespace App\Controller;

use App\Entity\Remarque;
use App\Form\RemarqueType;
use App\Repository\RemarqueRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[Route('/remarque')]
class RemarqueController extends AbstractController
{
    #[Route('/aides', name: 'app_remarque_index', methods: ['GET','POST'])]
    public function index(): Response
    {
        return $this->render('home/aides.html.twig', [
            'aides' => 'aides',
        ]);
    }

    #[Route('/new', name: 'app_remarque_new', methods: ['GET', 'POST'])]
    public function new(Request $request, RemarqueRepository $remarqueRepository): Response
    {
        $remarque = new Remarque();
        $form = $this->createForm(RemarqueType::class, $remarque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $remarqueRepository->save($remarque, true);

            return $this->redirectToRoute('app_remarque_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('remarque/new.html.twig', [
            'remarque' => $remarque,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_remarque_show', methods: ['GET'])]
    public function show(Remarque $remarque): Response
    {
        return $this->render('remarque/show.html.twig', [
            'remarque' => $remarque,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_remarque_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Remarque $remarque, RemarqueRepository $remarqueRepository,SluggerInterface $slugger): Response
    {
        $form = $this->createForm(RemarqueType::class, $remarque);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        { 
            $image = $form->get('image')->getData();
          
            if ($image) {
                $originalePhoto = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME); 
                $safePhotoname = $slugger->slug($originalePhoto);
                $newPhotoname = $safePhotoname . '-' . uniqid() . '.' . $image->guessExtension();
                try {
                    $image->move(
                        $this->getParameter('images_remarque'),
                        $newPhotoname
                    );
                } catch (FileException $e){}
                $remarque->setImage($newPhotoname); 
            }
            $remarqueRepository->save($remarque, true);

            return $this->redirectToRoute('app_remarque_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('remarque/edit.html.twig', [
            'remarque' => $remarque,
            'form' => $form,
        ]);
    }

    #[Route('/delete-remarque/{id}', name: 'app_remarque_delete', methods: ['GET','POST'])]
    public function delete(Request $request, Remarque $remarque, RemarqueRepository $remarqueRepository): Response
    {
        if ($remarque)
        {
            $nom = $remarque->getImage();
            unlink($this->getParameter('images_remarque').'/'.$nom);
            $remarqueRepository->remove($remarque, true);
        }

        return $this->redirectToRoute('app_remarque_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/valider-remarque/{id}', name: 'app_remarque_cloture', methods: ['GET','POST'])]
    public function valider(Request $request, Remarque $remarque, RemarqueRepository $remarqueRepository, EntityManagerInterface $em): Response
    {
        if ($remarque)
        {
            if ($remarque->isEtat() == 0)
            {
                $remarque->setEtat(1);
                $em->persist($remarque);
                $em->flush();
            }
        }

        return $this->redirectToRoute('app_remarque_index', [], Response::HTTP_SEE_OTHER);
    }
}