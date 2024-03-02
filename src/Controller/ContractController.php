<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Contract;
use App\Entity\DrivingSchool;
use App\Form\ContractType;

use App\Service\PdfService;
use App\Service\MailerService;
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
            'contracts' => $contractRepository->findByDrivingSchool($schoolSelected),
            'drivingSchool' => $schoolSelected,
        ]);
    }

    #[Route('/new', name: 'app_contract_new', methods: ['GET', 'POST'])]
    #[Security('is_granted("ROLE_BOSS")')]
    public function new(Request $request, EntityManagerInterface $entityManager, MailerService $mailerService, PdfService $pdfService): Response
    {

        $session = $request->getSession();
        $schoolSelected = $session->get('driving-school-selected');
        $drivingSchool = $entityManager->getRepository(DrivingSchool::class)->findOneById($schoolSelected);

        $contract = new Contract();
        $form = $this->createForm(ContractType::class, $contract, array('drivingSchool' => $drivingSchool));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $productSelected = $form->get('product')->getData();

            $contract->setName($productSelected->getProductName());
            $contract->setPrice($productSelected->getProductPrice());
            $contract->setValidityDate($productSelected->getValidityDate());
            $contract->setDescription($productSelected->getProductDescription());
            $contract->setDrivingSchool($drivingSchool);

            $entityManager->persist($contract);
            $entityManager->flush();

            $html = $this->render('contract/pdf_contract.html.twig', [
                'drivingSchool' => $schoolSelected,
                'contract' => $contract,
            ]);

            $nomContrat = $this->getParameter('kernel.project_dir') .'/public/pdf/contrat/contrat_' . $contract->getClient()->getFirstname() .'_' . $contract->getName() . "_" . $contract->getDrivingSchool()->getName();
            $pdfService->generatePDFFile($html, $nomContrat);

            $mailerService->sendContract($this->getParameter('address_mailer'), $this->getParameter('kernel.project_dir') .'/assets/images/driving-school.png', $contract, $nomContrat . '.pdf', 'Contract');

            return $this->redirectToRoute('app_contract_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contract/new.html.twig', [
            'contract' => $contract,
            'form' => $form,
            'drivingSchool' => $schoolSelected,
        ]);
    }
    #[Route('/{id}', name: 'app_contract_show', methods: ['GET'])]
    public function show(Request $request, Contract $contract): Response
    {
        $session = $request->getSession();
        $schoolSelected = $session->get('driving-school-selected');

        return $this->render('contract/show.html.twig', [
            'drivingSchool' => $schoolSelected,
            'contract' => $contract,
        ]);
    }

    #[Route('/pdf/{id}', name: 'app_contract_pdf_show', methods: ['GET'])]
    public function showPdf(Request $request, Contract $contract, PdfService $pdfService)
    {
        $session = $request->getSession();
        $schoolSelected = $session->get('driving-school-selected');

        $html = $this->render('contract/pdf_contract.html.twig', [
            'drivingSchool' => $schoolSelected,
            'contract' => $contract,
        ]);

        $pdfService->showPdfFile($html);
    }
    #[Route('/new/{idClient}', name: 'app_contract_new_id_client', methods: ['GET', 'POST'])]
    #[Security('is_granted("ROLE_BOSS")')]
    public function newClient(Request $request, EntityManagerInterface $entityManager, Client $client, MailerService $mailerService, PdfService $pdfService): Response
    {

        $session = $request->getSession();
        $schoolSelected = $session->get('driving-school-selected');
        $drivingSchool = $entityManager->getRepository(DrivingSchool::class)->findOneById($schoolSelected);

        $contract = new Contract();
        $form = $this->createForm(ContractType::class, $contract, array('drivingSchool' => $drivingSchool));
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

            $html = $this->render('contract/pdf_contract.html.twig', [
                'drivingSchool' => $schoolSelected,
                'contract' => $contract,
            ]);

            $nomContrat = $this->getParameter('kernel.project_dir') .'/public/pdf/contrat/contrat_' . $contract->getClient()->getFirstname() .'_' . $contract->getName() . "_" . $contract->getDrivingSchool()->getName();
            $pdfService->generatePDFFile($html, $nomContrat);

            $mailerService->sendContract($this->getParameter('address_mailer'), $this->getParameter('kernel.project_dir') .'/assets/images/driving-school.png', $contract, $nomContrat . '.pdf', 'Contract');

            return $this->redirectToRoute('app_contract_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contract/new.html.twig', [
            'form' => $form,
            'drivingSchool' => $schoolSelected,
            'idClient' => $client->getId()
        ]);
    }
}
