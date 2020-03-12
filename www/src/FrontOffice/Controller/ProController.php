<?php


namespace FrontOffice\Controller;

use FrontOffice\Form\Accounting\DevisForm;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Core\Service\MailerService;




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
     * @param MailerService $mailer
     * @return Response
     */
    public function devis(Request $request, MailerService $mailer )
    {
        $form = $this->createForm(DevisForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $nom = $request->request->get("devis_form")['name'];
            $firstName = $request->request->get("devis_form")['firstName'];
            $phoneNumber = $request->request->get("devis_form")['phoneNumber'];
            $address = $request->request->get("devis_form")['address'];
            $companyName = $request->request->get("devis_form")['companyName'];
            $email = $request->request->get("devis_form")['email'];
            $yellowTrashCan = $request->request->get("devis_form")['yellowTrashCan'];
            $blueTrashCan = $request->request->get("devis_form")['blueTrashCan'];
            if ($yellowTrashCan == 1){$yellowTrashCan = "Oui";}
            else{$yellowTrashCan = "Non";}
            if ($blueTrashCan == 1){$blueTrashCan = "Oui";}
            else {$blueTrashCan = "Non";}

            $mailer->broadcastToAdmins($mailer->createTwigMessage(
                "Devis",
                'mail/devisMail.html.twig',
                ['name' => $nom,
                'firstName'=> $firstName,
                'phoneNumber'=> $phoneNumber,
                'address'=> $address,
                'companyName'=> $companyName,
                'email'=> $email,
                'yellowTrashCan'=> $yellowTrashCan,
                'blueTrashCan'=> $blueTrashCan,
                ],
                ));
            $this->addFlash('success', 'Envoi du mail effectué');
            return $this->redirectToRoute('proServiceList');
        }
        return $this->render('front_office/proDevis.html.twig', [
            'controller_name' => 'ProContoller',
            'active' => 'Pro-Devis',
            'Pro_Devis' => $form->createView(), ]);
    }
}

