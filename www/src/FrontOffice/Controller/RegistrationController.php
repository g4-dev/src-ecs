<?php

namespace FrontOffice\Controller;

use Core\Entity\User;
use Core\Service\UserService;
use FrontOffice\Form\AccountUpdateForm;
use FrontOffice\Form\RegistrationForm;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /**
     * @var UserService
     */
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route("/sign-up",
     *     name="fo_registration")
     */
    public function register(Request $request)
    {
        $form = $this->createForm(RegistrationForm::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->register($form->getData());
            return $this->redirectToRoute('fo_homepage');
        }

        return $this->render('front_office/accounting/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/sign-up/activate/{uniqueId}/{token}",
     *     name="fo_registration_activate",
     *     requirements={"uniqueId": "[a-zA-Z0-9]{10}", "token": "[a-zA-Z0-9]{32}"})
     */
    public function activate($uniqueId, $token)
    {
        $user = $this->userService->fetchByUniqueId($uniqueId);
        if ($user->getToken() == $token) {
            $this->userService->activate($user);

            $this->addFlash('success', 'User successfully created');
            return $this->redirectToRoute('fo_homepage');
        }
        return new Response('error');
    }

    /**
     * @Route("/account_user/",
     *     name="fo_account")
     * @param Request $request
     * @return Response
     */
    public function showAccount(Request $request)
    {
        $user = $this->getUser();

        return $this->render('front_office/accounting/show-account.html.twig', [
            'controller_name' => 'RegistrationController',
            'account' => $user,
        ]);
    }

    /**
     * @Route("/account_user/update",
     *     name="fo_account_update")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function editAccount(Request $request, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        $form = $this->createForm(AccountUpdateForm::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->update($user, $form->getData()->toArray());

            $this->addFlash('success', 'User successfully updated');
            return $this->redirectToRoute('fo_account');
        }

        return $this->render('front_office/accounting/account-update.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
