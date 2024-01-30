<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\DrivingSchool;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/client')]
class ClientController extends AbstractController
{
    #[Route('/', name: 'app_client_index', methods: ['GET'])]
    #[Security('is_granted("ROLE_BOSS")')]
    public function index(ClientRepository $clientRepository, Request $request): Response
    {

        $session = $request->getSession();
        $schoolSelected = $session->get('driving-school-selected');

        return $this->render('client/index.html.twig', [
            'clients' => $clientRepository->findByDrivingSchool($schoolSelected),
            'drivingSchool' => $schoolSelected,
        ]);
    }

    #[Route('/new', name: 'app_client_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $session = $request->getSession();
        $schoolSelected = $session->get('driving-school-selected');

        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $drivingSchool = $entityManager->getRepository(DrivingSchool::class)->findOneById($schoolSelected);
            $client->setDrivingSchool($drivingSchool);
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('app_client_index');
        }

        return $this->render('client/new.html.twig', [
            'drivingSchool' => $schoolSelected,
            'client' => $client,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_client_show', methods: ['GET'])]
    public function show(Client $client, Request $request): Response
    {

        $session = $request->getSession();
        $schoolSelected = $session->get('driving-school-selected');

        return $this->render('client/show.html.twig', [
            'client' => $client,
            'drivingSchool' => $schoolSelected,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_client_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Client $client, EntityManagerInterface $entityManager): Response
    {

        $session = $request->getSession();
        $schoolSelected = $session->get('driving-school-selected');

        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('client/edit.html.twig', [
            'client' => $client,
            'form' => $form,
            'drivingSchool' => $schoolSelected,
        ]);
    }

    #[Route('/{id}', name: 'app_client_delete', methods: ['POST'])]
    public function delete(Request $request, Client $client, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$client->getId(), $request->request->get('_token'))) {
            $entityManager->remove($client);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_client_index', [], Response::HTTP_SEE_OTHER);
    }
}
