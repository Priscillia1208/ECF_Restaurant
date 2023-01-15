<?php

namespace App\Controller;

use App\Entity\Allergene;
use App\Form\AllergeneType;
use App\Repository\AllergeneRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/allergene")
 */
class AdminAllergeneController extends AbstractController
{
    /**
     * @Route("/", name="app_admin_allergene_index", methods={"GET"})
     */
    public function index(AllergeneRepository $allergeneRepository): Response
    {
        return $this->render('admin_allergene/index.html.twig', [
            'allergenes' => $allergeneRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_admin_allergene_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AllergeneRepository $allergeneRepository): Response
    {
        $allergene = new Allergene();
        $form = $this->createForm(AllergeneType::class, $allergene);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $allergeneRepository->add($allergene, true);

            return $this->redirectToRoute('app_admin_allergene_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_allergene/new.html.twig', [
            'allergene' => $allergene,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_allergene_show", methods={"GET"})
     */
    public function show(Allergene $allergene): Response
    {
        return $this->render('admin_allergene/show.html.twig', [
            'allergene' => $allergene,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_admin_allergene_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Allergene $allergene, AllergeneRepository $allergeneRepository): Response
    {
        $form = $this->createForm(AllergeneType::class, $allergene);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $allergeneRepository->add($allergene, true);

            return $this->redirectToRoute('app_admin_allergene_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin_allergene/edit.html.twig', [
            'allergene' => $allergene,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_admin_allergene_delete", methods={"POST"})
     */
    public function delete(Request $request, Allergene $allergene, AllergeneRepository $allergeneRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$allergene->getId(), $request->request->get('_token'))) {
            $allergeneRepository->remove($allergene, true);
        }

        return $this->redirectToRoute('app_admin_allergene_index', [], Response::HTTP_SEE_OTHER);
    }
}
