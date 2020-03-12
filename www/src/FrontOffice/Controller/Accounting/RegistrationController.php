<?php

namespace FrontOffice\Controller\Accounting;

use Core\Entity\Address;
use Core\Form\AddressType;
use Core\Repository\AddressRepository;
use Core\Service\UserService;
use Doctrine\ORM\EntityManagerInterface;
use FrontOffice\Form\Accounting\AccountUpdateForm;
use FrontOffice\Form\Accounting\RegistrationForm;
use FrontOffice\Form\UserContactType;
use FrontOffice\Repository\PurchaseRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends \FrontOffice\Controller\AbstractController
{
    /**
     * @var UserService
     */
    protected UserService $userService;
    
    protected $session;
    
    public function __construct(UserService $userService, SessionInterface $session)
    {
        $this->userService = $userService;
        $this->session = $session;
    }
    
    /**
     * @Route("/sign-up", name="registration")
     */
    public function register(Request $request)
    {
        $form = $this->createForm(RegistrationForm::class);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->register($form->getData());
            
            return $this->redirectToRoute('homepage');
        }
        
        return $this->render(
           '@fo/accounting/registration.html.twig',
           [
              'form' => $form->createView(),
           ]
        );
    }
    
    /**
     * @Route("/sign-up/activate/{uniqueId}/{token}",
     *     name="registrationActivate",
     *     requirements={"uniqueId": "[a-zA-Z0-9]{10}", "token": "[a-zA-Z0-9]{32}"})
     */
    public function activate($uniqueId, $token)
    {
        $user = $this->userService->fetchByUniqueId($uniqueId);
        if ($user->getToken() == $token) {
            $this->userService->activate($user);
            
            $this->addFlash('success', 'User successfully created');
            
            return $this->redirectToRoute('homepage');
        }
        
        return new Response('error');
    }
    
    /**
     * @Route("/account", name="account")
     * @return Response
     */
    public function showAccountAction(): Response
    {
        // TODO: add more options
        $user = $this->getUser();
        
        return $this->render(
           'front_office/accounting/show-account.html.twig',
           [
              'controller_name' => 'RegistrationController',
              'account' => $user,
              'addresses' => $user->getAddresses()
           ]
        );
    }
    
    /**
     * @Route("/account/update", name="accountUpdate")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return RedirectResponse|Response
     */
    public function editAccountAction(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(AccountUpdateForm::class, $user);
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $this->userService->update($user, $form->getData()->toArray());
            
            $this->addFlash('success', 'Mise à jour effectuée');
            
            return $this->redirectToRoute('account');
        }
        
        return $this->render(
           '@fo/accounting/account-update.html.twig',
           [
              'form' => $form->createView(),
           ]
        );
    }
    
    /**
     * @Route("/address/edit/{id?}", name="accountAddress", requirements={"id"="\d+"})
     */
    public function editAddressAction(Request $request, Address $address = null): Response
    {
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($form->getData()->setUser($this->getUser()));
            $em->flush();
        }
        
        return $this->render(
           '@fo/accounting/address.html.twig',
           [
              'address_form' => $form->createView(),
              'return_basket' => $this->session->get('checkout/current-checkout')
           ]
        );
    }

    /**
     * @Route("/address/remove/{address}", name="removeAddress")
     */
    public function removeAddressAction(Address $address)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($address);
        $em->flush();

        return $this->redirectToRoute('account');
    }
    
    /**
     * @Route("/account/purchases", name="accountPurchaseList")
     * @return Response
     */
    public function listPurchasesAction(): Response
    {
        // TODO: Ajaxify this method
        $purchases = $this->getUser()->getPurchases();
        
        return $this->render(
           'front_office/shopping/purchaseList.html.twig',
           [
              'purchases' => $purchases,
           ]
        );
    }
    
    /**
     * @Route("/account/purchase/{id}", name="accountPuchaseShow")
     * @param int $id
     * @param PurchaseRepository $purchaseRepository
     * @return Response
     */
    public function showPurchaseAction(int $id, PurchaseRepository $purchaseRepository): Response {
        // TODO: Ajaxify this method
        $purchase = $purchaseRepository
           ->findOneByIdAndUser($id, $this->getUser()->getId());
        
        if (!$purchase) {
            throw $this->createNotFoundException();
        }
        
        return $this->render(
           'front_office/shopping/purchaseShow.html.twig',
           [
              'purchase' => $purchase
           ]
        );
    }
}
