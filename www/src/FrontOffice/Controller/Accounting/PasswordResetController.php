<?php

namespace FrontOffice\Controller\Accounting;

use Core\Service\UserService;
use FrontOffice\Form\Accounting\PasswordReminderForm;
use FrontOffice\Form\Accounting\PasswordResetForm;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PasswordResetController extends \FrontOffice\Controller\AbstractController
{
    /**
     * @var UserService
     */
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @Route("/lost-password", name="passwordReminder")
     */
    public function reminder(Request $request)
    {
        $statusCode = Response::HTTP_OK;

        $form = $this->createForm(PasswordReminderForm::class);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $user = $this->userService->fetchByEmail($form['email']->getData());
                $this->userService->requestPassword($user);
                $this->addFlash('success', 'Check your mailbox.');
                $statusCode = Response::HTTP_ACCEPTED;

            } else {
                $statusCode = Response::HTTP_BAD_REQUEST;
            }
        }

        return $this->render('front_office/accounting/password-reminder.html.twig', [
            'form' => $form->createView()
        ])->setStatusCode($statusCode);
    }

    /**
     * @Route("/reset-password/{uniqueId}/{token}",
     *     name="passwordReset",
     *     requirements={"uniqueId": "[a-zA-Z0-9]{10}", "token": "[a-zA-Z0-9]{32}"})
     */
    public function reset($uniqueId, $token, Request $request)
    {
        $statusCode = Response::HTTP_OK;

        $user = $this->userService->fetchByUniqueId($uniqueId);
        if ($user->getToken() != $token) {
            $this->addFlash('error', 'Invalid user token!');
            return $this->redirectToRoute('homepage');
        }

        $form = $this->createForm(PasswordResetForm::class);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                if (!$user->isActive()) {
                    $this->userService->activate($user);
                }

                $this->userService->changePassword($user, $form['password']->getData());
                $this->addFlash('success', 'Your password has been changed, you can sign in now.');
                return $this->redirectToRoute('homepage');

            } else {
                $statusCode = Response::HTTP_BAD_REQUEST;
            }
        }

        return $this->render('front_office/accounting/password-reset.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ])->setStatusCode($statusCode);
    }
}
