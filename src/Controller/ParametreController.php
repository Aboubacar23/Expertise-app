<?php

namespace App\Controller;

use App\Service\PdfServiceP;
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Snappy\Pdf;
use App\Entity\Affaire;
use App\Entity\Machine;
use App\Entity\Parametre;
use App\Entity\Type;
use App\Form\ParametreType;
use App\Repository\PhotoRepository;
use App\Repository\CritereRepository;
use App\Repository\ParametreRepository;
use App\Repository\CorrectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AppareilMesureRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ReleveDimmensionnelRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/parametre')]
class ParametreController extends AbstractController
{
    #[Route('/', name: 'app_parametre_index', methods: ['GET'])]
    public function index(ParametreRepository $parametreRepository): Response
    {
        return $this->render('parametre/index.html.twig', [
            'parametres' => $parametreRepository->findAll(),
        ]);
    }

    #[Route('/new/{id}', name: 'app_parametre_new', methods: ['GET', 'POST'])]
    public function new(Request $request, Affaire $affaire, ParametreRepository $parametreRepository, CritereRepository $critereRepository, CorrectionRepository $correctionRepository): Response
    {
        $parametre = new Parametre();
        $form = $this->createForm(ParametreType::class, $parametre);
        $form->handleRequest($request);

        $criteres = $critereRepository->findAll();
        $critere = 0;
        foreach ($criteres as $item) {
            if ($item->isEtat() == 1) {
                $critere = $item->getMontant();
            }
        }

        $corrections = $correctionRepository->findAll();
        $correction = 0;
        foreach ($corrections as $item2) {
            if ($item2->isEtat() == 1) {
                $correction = $item2->getTemperature();
            }
        }

        if ($form->isSubmitted() && $form->isValid()) {
            //cette 
            if ($parametre->getStatorTension2() == null) {
                $parametre->setStatorTension2(0);
            }
            if ($parametre->getStatorTension() == null) {
                $parametre->setStatorTension(0);
            }

            if ($parametre->getRotorTension2() == null) {
                $parametre->setRotorTension2(0);
            }

            if ($parametre->getRotorTension() == null) {
                $parametre->setRotorTension(0);
            }

            $parametre->setAffaire($affaire);
            $parametreRepository->save($parametre, true);

            return $this->redirectToRoute('app_affaire_show', [
                'id' => $affaire->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('parametre/new.html.twig', [
            'parametre' => $parametre,
            'form' => $form,
            'affaire' => $affaire,
            'critere' => $critere,
            'correction' => $correction,
        ]);
    }

    #[Route('/{id}', name: 'app_parametre_show', methods: ['GET'])]
    public function show(Parametre $parametre): Response
    {
        return $this->render('parametre/show.html.twig', [
            'parametre' => $parametre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_parametre_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Parametre $parametre, ParametreRepository $parametreRepository): Response
    {
        $form = $this->createForm(ParametreType::class, $parametre);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($parametre->getStatorTension2() == null) {
                $parametre->setStatorTension2(0);
            }
            if ($parametre->getStatorTension() == null) {
                $parametre->setStatorTension(0);
            }

            if ($parametre->getRotorTension2() == null) {
                $parametre->setRotorTension2(0);
            }

            if ($parametre->getRotorTension() == null) {
                $parametre->setRotorTension(0);
            }

            $parametreRepository->save($parametre, true);

            return $this->redirectToRoute('app_affaire_show', [
                'id' => $parametre->getAffaire()->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('parametre/edit.html.twig', [
            'parametre' => $parametre,
            'form' => $form,
        ]);
    }

    #[Route('delete-parametre/{id}', name: 'app_parametre_delete', methods: ['GET'])]
    public function delete(
        Request $request,
        Parametre $parametre,
        EntityManagerInterface $em,
        ParametreRepository $parametreRepository,
        AppareilMesureRepository $appareilMesureRepository,
        ReleveDimmensionnelRepository $releveDimmensionnelRepository,
        PhotoRepository $photoRepository,
    ): Response {
        if ($parametre) {
            $id = $parametre->getAffaire()->getId();
            //appareil de mesure mecanique
            foreach ($parametre->getAppareilMesureMecaniques() as $item) {
                $em->remove($item, true);
            }

            //photos expertiss mécanique
            foreach ($parametre->getPhotoExpertiseMecaniques() as $item) {
                $em->remove($item, true);
            }

            //constat électrique après lavage
            foreach ($parametre->getConstatElectriqueApresLavages() as $item) {
                $em->remove($item, true);
            }
            //constat mécanique
            foreach ($parametre->getConstatMecaniques() as $item) {
                $em->remove($item, true);
            }

            //constat électrique avant lavage
            foreach ($parametre->getConstatElectriques() as $item) {
                $em->remove($item, true);
            }
            //caractéristique
            foreach ($parametre->getCaracteristiques() as $item) {
                $em->remove($item, true);
            }

            //point de fonctionnement
            foreach ($parametre->getPointFonctionnements() as $item) {
                $em->remove($item);
            }

            //point de fonctionnement à vide
            foreach ($parametre->getPointFonctionnementVides() as $item) {
                $em->remove($item);
            }

            ///point de fonctionnement rotor
            foreach ($parametre->getPointFonctionnementRotors() as $item) {
                $em->remove($item);
            }

            ///remontage photo
            foreach ($parametre->getRemontagePhotos() as $item) {
                $em->remove($item);
            }

            ///plauqe
            foreach ($parametre->getPlaques() as $item) {
                $em->remove($item);
            }
            ///controle de recensement
            foreach ($parametre->getControleRecensements() as $item) {
                $em->remove($item);
            }

            ///photo
            if ($parametre->getPhoto()) {
                if ($parametre->getPhoto()->getImages()) {
                    foreach ($parametre->getPhoto()->getImages() as $item) {
                        $em->remove($item);
                    }
                }

                foreach ($photoRepository->findAll() as $ph) {
                    if ($ph->getParametre()->getId() == $parametre->getId()) {
                        $em->remove($ph);
                    }
                }
            }

            ///mesure isolement
            if ($parametre->getMesureIsolement()) {
                if ($parametre->getMesureIsolement()->getLMesureIsolements()) {
                    foreach ($parametre->getMesureIsolement()->getLMesureIsolements() as $item) {
                        $em->remove($item);
                    }
                }
                $em->remove($parametre->getMesureIsolement());
            }

            ///mesure essais
            if ($parametre->getMesureIsolementEssai()) {
                if ($parametre->getMesureIsolementEssai()->getLMesureIsolementEssais()) {
                    foreach ($parametre->getMesureIsolementEssai()->getLMesureIsolementEssais() as $item) {
                        $em->remove($item);
                    }
                }
                $em->remove($parametre->getMesureIsolementEssai());
            }

            ///mesure essais
            if ($parametre->getMesureResistanceEssai()) {
                if ($parametre->getMesureResistanceEssai()->getLMesureResistanceEssais()) {
                    foreach ($parametre->getMesureResistanceEssai()->getLMesureResistanceEssais() as $item) {
                        $em->remove($item);
                    }
                }
                $em->remove($parametre->getMesureResistanceEssai());
            }

            ///mesure resistance
            if ($parametre->getMesureResistance()) {
                if ($parametre->getMesureResistance()->getLMesureResistances()) {
                    foreach ($parametre->getMesureResistance()->getLMesureResistances() as $item) {
                        $em->remove($item);
                    }
                }
                $em->remove($parametre->getMesureResistance());
            }

            ///sonde et bobinage
            if ($parametre->getSondeBobinage()) {
                if ($parametre->getSondeBobinage()->getLSondeBobinages()) {
                    foreach ($parametre->getSondeBobinage()->getLSondeBobinages() as $item) {
                        $em->remove($item);
                    }
                }
                $em->remove($parametre->getSondeBobinage());
            }

            //stator après lavage
            if ($parametre->getStatorApresLavage()) {
                if ($parametre->getStatorApresLavage()->getLStatorApresLavages()) {
                    foreach ($parametre->getStatorApresLavage()->getLStatorApresLavages() as $item) {
                        $em->remove($item);
                    }
                }
                $em->remove($parametre->getStatorApresLavage());
            }

            ///controle visuel
            if ($parametre->getControleVisuelMecanique()) {
                if ($parametre->getControleVisuelMecanique()->getAccessoireSupplementaires()) {
                    foreach ($parametre->getControleVisuelMecanique()->getAccessoireSupplementaires() as $item) {
                        $em->remove($item);
                    }
                }
                $em->remove($parametre->getControleVisuelMecanique());
            }

            foreach ($releveDimmensionnelRepository->findAll() as $item) {
                if ($item->getParametre()->getId() == $parametre->getId()) {
                    $em->remove($item);
                }
                $em->remove($item);
            }

            foreach ($parametre->getAppareilMesureElectriques() as $item) {
                $em->remove($item);
            }

            if ($parametre->getAppareilMesures()) {
                foreach ($appareilMesureRepository->findAll() as $item) {
                    if ($item->getParametre()->getId() ==  $parametre->getId()) {
                        $em->remove($item);
                    }
                }
            }

            $em->remove($parametre);
            $em->flush();
        }

        return $this->redirectToRoute('app_affaire_show', [
            'id' => $id
        ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/print/rapport-expertise/{id}', name: 'app_parametre_expertise', methods: ['POST', 'GET'])]
    public function rapportExpertise(Parametre $parametre, PdfServiceP $pdfServiceP): Response
    {
        // On génère un nom de fichier
        $fichier = $parametre->getAffaire()->getNomRapport();
        $html = $this->renderView('parametre/rapport_expertise.html.twig', [
            'parametre' => $parametre
        ]);
        return  $pdfServiceP->showPdfFile($html, $fichier);
    }

    #[Route('/print/rapport-final/{id}', name: 'app_parametre_final', methods: ['POST', 'GET'])]
    public function rapporFinal(Parametre $parametre, PdfServiceP $pdfServiceP): Response
    {
        $fichier = $parametre->getAffaire()->getNomRapport();
        $html = $this->renderView('parametre/rapport_final.html.twig', [
            'parametre' => $parametre
        ]);
        return  $pdfServiceP->showPdfFile($html, $fichier);
    }

    #[Route('/reunion-validation/{id}', name: 'app_parametre_valided', methods: ['GET'])]
    public function reunion(Request $request, Parametre $parametre, ParametreRepository $parametreRepository, EntityManagerInterface $em): Response
    {
        $id = $parametre->getAffaire()->getId();
        if ($parametre) {
            $parametre->setEtat(1);
            $em->persist($parametre);
            $em->flush();
        }
        return $this->redirectToRoute('app_affaire_show', [
            'id' => $id
        ], Response::HTTP_SEE_OTHER);
    }

    //la fonction qui permet d'activer et réactiver une affaire
    #[Route('/info/{id}', name: 'get_info', methods: ['GET'])]
    public function test(Type $machine): JsonResponse
    {
        if (!$machine) {
            return new JsonResponse(['erreur' => 'type machine non trouvée'], 404);
        }
        return new JsonResponse([
            'machine' => $machine->getMachine()->getId(),
            'type_machine' => $machine->getTypeMachine(),
            'puissance' => $machine->getPuissance(),
            'montage' => $machine->getMontage(),
            'fabricant' => $machine->getFabricant(),
            'vitesse' => $machine->getVitesse(),
            'masse' => $machine->getMasse(),
            'type_palier' => $machine->getTypepalier(),
            'presence_balais' => $machine->isPresenceBalais(),
            'presence_masse_balais' => $machine->isPresenceBalaisMasse(),
            'stator_tension' => $machine->getStatorTension(),
            'stator_tension2' => $machine->getStatorTension2(),
            'stator_frequence' => $machine->getStatorFrequence(),
            'stator_courant' => $machine->getStatorCourant(),
            'stator_couplage' => $machine->getStatorCouplage(),
            'date_arrivee' => $machine->getDateArrivee(),
            'rotor_tension' => $machine->getRotorTension(),
            'rotor_tension2' => $machine->getRotorTension2(),
            'rotor_expertise_refrigeant' => $machine->getRotorExpertiseRefrigeant(),
            'rotor_courant' => $machine->getRotorCourant(),
            'presence_plans' => $machine->isPresencePlans(),
        ]);
    }


    //la fonction qui permet d'activer et réactiver une affaire
    #[Route('/frequence/{id}', name: 'app_frequence', methods: ['GET'])]
    public function frequence(Machine $machine): JsonResponse
    {
        if (!$machine) {
            return new JsonResponse(['erreur' => 'Machine non trouvée'], 404);
        }
        return new JsonResponse([
            'name' => $machine->getCategorie(),
        ]);
    }
}
