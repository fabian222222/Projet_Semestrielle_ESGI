<?php

namespace App\Controller;

use App\Form\ChooseDateType;
use App\Model\DateData;
use App\Repository\ClientRepository;
use App\Repository\ContractRepository;
use App\Repository\InvoiceRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
#[Route('/comptable')]
class ComptableController extends AbstractController
{

    #[Route('/', name: 'app_comptable_index', methods: ['GET', 'POST'])]
    #[Security('is_granted("ROLE_BOSS")')]
    public function index(InvoiceRepository $invoiceRepository, Request $request, ClientRepository $clientRepository, ContractRepository $contractRepository): Response
    {
        $session = $request->getSession();
        $schoolSelected = $session->get('driving-school-selected');

        $date = new DateData();
        $form = $this->createForm(ChooseDateType::class, $date);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $date->page = $request->query->getInt('page', 1);

            $invoices = $invoiceRepository->findInvoicesCreatedAfterDate($date->date);
            $invoicesPrices = $invoiceRepository->findTotalPriceOfInvoicesCreatedAfterDate($date->date);

            $contracts = $contractRepository->findContractsCreatedAfterDate($date->date);
            $contractsPrices = $contractRepository->findTotalPriceOfContractsCreatedAfterDate($date->date);

            $clients = $clientRepository->findClientCreatedAfterDate($date->date);

            return $this->render('comptable/stats.html.twig', [
                'form' => $form->createView(),

                'invoices' => $invoices,
                'invoicesCount' => count($invoices),
                'invoicesPrices' => $invoicesPrices,

                'contracts' => $contracts,
                'contractsCount' => count($contracts),
                'contractsPrices' =>$contractsPrices,

                'clients' => $clients,
                'clientCount' => count($clients),
            ]);
        }

        return $this->render('comptable/stats.html.twig', [
            'form' => $form->createView(),

            'invoices' => $invoiceRepository->findAll(),
            'invoicesCount' => count($invoiceRepository->findAll()),
            'invoicesPrices' => $invoiceRepository->getTotalPriceOfAllInvoices(),

            'contracts' => $contractRepository->findAll(),
            'contractsCount' => count($contractRepository->findAll()),
            'contractsPrices' => $contractRepository->getTotalPriceOfAllContracts(),

            'clients' => $clientRepository->findAll(),
            'clientCount' => count($clientRepository->findAll()),

            'drivingSchool' => $schoolSelected,
        ]);
    }

}