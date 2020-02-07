<?php

namespace FrontOffice\Controller\Accounting;

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
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends \FrontOffice\Controller\AbstractController
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
           'front_office/accounting/registration.html.twig',
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
    public function showAccount(): Response
    {
        // TODO: add more options
        $user = $this->getUser();
        
        return $this->render(
           'front_office/accounting/show-account.html.twig',
           [
              'controller_name' => 'RegistrationController',
              'account' => $user,
           ]
        );
    }
    
    /**
     * @Route("/account/update", name="accountUpdate")
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
            
            return $this->redirectToRoute('account');
        }
        
        return $this->render(
           'front_office/accounting/account-update.html.twig',
           [
              'form' => $form->createView(),
           ]
        );
    }
    
    /**
     * @Route("/account/edit-address", name="accountAddress")
     */
    public function editAddress(AddressRepository $addressRepository): Response
    {
        //TODO : simplify this broken update method (put it in an AdressController)
        $user = $this->getUser();
        
        $address = $addressRepository->findCurrentWithType(
           $user->getId(),
           'billing'
        );
        
        $userContact = new \FrontOffice\Form\Model\UserContact($user, $address);
        
        $form = $this->createForm(UserContactType::class, $userContact);
        
        $masterRequest = $this->get('request_stack')->getMasterRequest();
        $form->handleRequest($masterRequest);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $userContact = $form->getData();
            $address = $userContact->getAddress();
            
            $uow = $this->getDoctrine()
               ->getManager()
               ->getUnitOfWork();
            $uow->computeChangeSets();
            
            if ($uow->isEntityScheduled($address)) {
                $address = clone $address;
                $address->setDateCreated(new \DateTime());
            }
            
            $user->setFirstName($userContact->getFirstName())
               ->setLastName($userContact->getLastName());
            
            $address->setUser($user)
               ->setCountry('France')
               ->setType('billing');
            
            if ($uow->isEntityScheduled($address)) {
                $address = clone $address;
                $address->setDateCreated(new \DateTime());
            }
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($address);
            $em->flush();
        }
        
        return $this->render(
           'front_office/shop/account/user_contact_form.html.twig',
           [
              'address_form' => $form->createView(),
           ]
        );
    }
    
    /**
     * @Route("/account/purchases", name="accountPurchaseList")
     * @return Response
     */
    public function purchases(): Response
    {
        // TODO: Ajaxify this method
        $orders = $this->getUser()->getPurchases();
        
        return $this->render(
           'front_office/shop/accounting/orders.html.twig',
           [
              'orders' => $orders,
           ]
        );
    }
    
    /**
     * @Route("/account/purchase/{id}", name="accountPuchaseShow")
     * @param int $id
     * @param PurchaseRepository $purchaseRepository
     * @return Response
     */
    public function purchase (int $id, PurchaseRepository $purchaseRepository): Response {
        // TODO: Ajaxify this method
        $purchase = $purchaseRepository
           ->findOneByIdAndUser($id, $this->getUser()->getId());
        
        if (!$purchase) {
            throw $this->createNotFoundException();
        }
        
        return $this->render(
           'front_office/shop/account/order_single.html.twig',
           [
              'purchase' => $purchase
           ]
        );
    }
}
