<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Entity\DrivingSchool;
use App\Form\ContractType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ContractRepository;

#[Route('/contract')]
class ContractController extends AbstractController
{
    #[Route('/', name: 'app_contract_index')]
    public function index(Request $request, ContractRepository $contractRepository): Response
    {

        $session = $request->getSession();
        $schoolSelected = $session->get('driving-school-selected');

        return $this->render('contract/index.html.twig', [
            'contracts' => $contractRepository->findAll(),
            'drivingSchool' => $schoolSelected,
        ]);
    }

    #[Route('/new', name: 'app_contract_new', methods: ['GET', 'POST'])]
    #[Security('is_granted("ROLE_BOSS")')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {

        $session = $request->getSession();
        $schoolSelected = $session->get('driving-school-selected');

        $contract = new Contract();
        $form = $this->createForm(ContractType::class, $contract);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $drivingSchool = $entityManager->getRepository(DrivingSchool::class)->findOneById($schoolSelected);

            if (!$drivingSchool) {
                throw $this->createNotFoundException('Driving school could not be found');
            }

            $productSelected = $form->get('product')->getData();

            $contract->setName($productSelected->getProductName());
            $contract->setPrice($productSelected->getProductPrice());
            $contract->setValidityDate($productSelected->getValidityDate());
            $contract->setDescription($productSelected->getProductDescription());
            $contract->setDrivingSchool($drivingSchool);

            $entityManager->persist($contract);
            $entityManager->flush();

            return $this->redirectToRoute('app_contract_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contract/new.html.twig', [
            'form' => $form,
            'drivingSchool' => $schoolSelected,
        ]);
    }
}
