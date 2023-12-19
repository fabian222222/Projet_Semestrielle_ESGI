<?php

namespace App\Controller;

use App\Entity\DrivingSchool;
use App\Entity\Formula;
use App\Form\FormulaType;
use App\Repository\FormulaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

#[Route('/driving-school/{idS}/formula')]
class FormulaController extends AbstractController
{
    #[Route('/', name: 'app_formula_index', methods: ['GET'])]
    public function index(FormulaRepository $formulaRepository, DrivingSchool $idS): Response
    {
        return $this->render('formula/index.html.twig', [
            'formulas' => $formulaRepository->findByFormulasDrivingSchoolId($idS->getId()),
            'drivingSchool' => $idS->getId(),
        ]);
    }

    #[Route('/new', name: 'app_formula_new', methods: ['GET', 'POST'])]
    #[Security('is_granted("ROLE_BOSS")')]
    public function new(Request $request, EntityManagerInterface $entityManager, DrivingSchool $idS): Response
    {
        $formula = new Formula();
        $form = $this->createForm(FormulaType::class, $formula);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formula->setDrivingSchool($idS);
            $entityManager->persist($formula);
            $entityManager->flush();

            return $this->redirectToRoute('app_formula_index', ["idS" => $idS->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('formula/new.html.twig', [
            'drivingSchool' => $idS,
            'formula' => $formula,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_formula_show', methods: ['GET'])]
    #[Security('is_granted("ROLE_BOSS")')]
    public function show(Formula $formula, DrivingSchool $idS): Response
    {
        return $this->render('formula/show.html.twig', [
            'formula' => $formula,
            'drivingSchool' => $idS->getId(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_formula_edit', methods: ['GET', 'POST'])]
    #[Security('is_granted("ROLE_ADMIN") or (is_granted("ROLE_BOSS") && user.getDrivingSchools().contains(formula.getDrivingSchool()))')]
    public function edit(Request $request, Formula $formula, EntityManagerInterface $entityManager, DrivingSchool $idS): Response
    {
        $form = $this->createForm(FormulaType::class, $formula);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_formula_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('formula/edit.html.twig', [
            'formula' => $formula,
            'form' => $form,
            'drivingSchool' => $idS->getId(),
        ]);
    }

    #[Route('/{id}', name: 'app_formula_delete', methods: ['POST'])]
    #[Security('is_granted("ROLE_ADMIN") or (is_granted("ROLE_BOSS") && user.getDrivingSchools().contains(formula.getDrivingSchool()))')]
    public function delete(Request $request, Formula $formula, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$formula->getId(), $request->request->get('_token'))) {
            $entityManager->remove($formula);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_formula_index', [], Response::HTTP_SEE_OTHER);
    }
}
