<?php

namespace App\Controller;

use App\Entity\DrivingSchool;
use App\Form\DrivingSchoolType;
use App\Repository\DrivingSchoolRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

#[Route('/driving-school')]
class DrivingSchoolController extends AbstractController
{

    #[Route('/', name: 'app_driving_school_index', methods: ['GET'])]
    public function index(DrivingSchoolRepository $drivingSchoolRepository): Response
    {
        if ($this->isGranted("ROLE_ADMIN")) {
            return $this->render('driving_school/index.html.twig', [
                'driving_schools' => $drivingSchoolRepository->findAll(),
            ]);
        } else {
            $filtredDrivingSchools = [];
            $drivingSchools = $drivingSchoolRepository->findAll();
            foreach($drivingSchools as $drivingSchool) {
                if ($drivingSchool->getUsers()->contains($this->getUser())) {
                    $filtredDrivingSchools[] = $drivingSchool;
                }
            }
            return $this->render('driving_school/index.html.twig', [
                'driving_schools' => $filtredDrivingSchools,
            ]);
        }
    }

    #[IsGranted("ROLE_BOSS")]
    #[Route('/new', name: 'app_driving_school_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $drivingSchool = new DrivingSchool();
        $form = $this->createForm(DrivingSchoolType::class, $drivingSchool);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $drivingSchool->addUser($user);
            $entityManager->persist($drivingSchool);
            $entityManager->flush();

            return $this->redirectToRoute('app_driving_school_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('driving_school/new.html.twig', [
            'driving_school' => $drivingSchool,
            'form' => $form,
        ]);
    }

    #[Security('is_granted("ROLE_ADMIN") or (is_granted("ROLE_BOSS") && drivingSchool.getUsers().contains(user))')]
    #[Route('/{id}', name: 'app_driving_school_show', methods: ['GET'])]
    public function show(DrivingSchool $drivingSchool, Request $request): Response
    {
        $session = $request->getSession();
        $session->set('driving-school-selected', $drivingSchool->getId());

        return $this->render('driving_school/show.html.twig', [
            'drivingSchool' => $drivingSchool->getId(),
        ]);
    }

    #[Security('is_granted("ROLE_ADMIN") or (is_granted("ROLE_BOSS") && drivingSchool.getUsers().contains(user))')]
    #[Route('/{id}/edit', name: 'app_driving_school_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DrivingSchool $drivingSchool, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DrivingSchoolType::class, $drivingSchool);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_driving_school_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('driving_school/edit.html.twig', [
            'drivingSchool' => $drivingSchool->getId(),
            'form' => $form,
        ]);
    }

    #[Security('is_granted("ROLE_ADMIN") or (is_granted("ROLE_BOSS") && drivingSchool.getUsers().contains(user))')]
    #[Route('/{id}', name: 'app_driving_school_delete', methods: ['POST'])]
    public function delete(Request $request, DrivingSchool $drivingSchool, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $drivingSchool->getId(), $request->request->get('_token'))) {
            $entityManager->remove($drivingSchool);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_driving_school_index', [], Response::HTTP_SEE_OTHER);
    }
}
