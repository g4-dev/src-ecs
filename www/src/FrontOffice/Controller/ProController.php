<?php


namespace FrontOffice\Controller;
use FrontOffice\Form\Accounting\DevisForm;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;



class ProController extends AbstractController
{
    /**
     * @Route("/services-pro", name="proServiceList")
     */
    public function index()
    {
        return $this->render('front_office/proServiceList.html.twig');
    }

    /**
     * @Route("/services-pro/devis", name="proDevis")
     * @return Response
     */
    public function devis(Request $request)
    {
        $form = $this->createForm(DevisForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Envoi du mail effectuer');
            return $this->redirectToRoute('proServiceList');
        }

        return $this->render('front_office/proDevis.html.twig', [
            'controller_name' => 'ProContoller',
            'active' => 'Pro-Devis',
            'Pro_Devis' => $form->createView(), ]);
    }
}

