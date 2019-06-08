<?php
namespace App\Controller;

use App\Entity\Customer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class CustomerController extends Controller
{

    /**
     * @Route("/customer", name="customer_list")
     * @Method({"GET"})
     */

    public function index()
    {
        $customers = $this->getDoctrine()->getRepository(Customer::class)->findAll();
        return $this->render('customers/index.html.twig', array('customers' => $customers));
    }

    /**
     * @Route("/customer/new", name="new_customer")
     * @Method({"GET", "POST"})
     */

    public function new(Request $request)
    {
        $customer = new Customer();
        $form = $this->createFormBuilder($customer)
            ->add('imie', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('nazwisko', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('wiek', TextType::class, array('attr' => array('class' => 'form-control')))
            ->add('save', SubmitType::class, array ('label' => 'Save','attr' => array('class' =>'btn btn-primary mt-3')))
            ->getForm();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $customer = $form->getData();
            $entityManager = $this ->getDoctrine()->getManager();
            $entityManager->persist($customer);
            $entityManager->flush();

            return $this->redirectToRoute('customer_list');

        }

        return $this->render('customers/new.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/customer{id}", name="show")
     */
    public function show($id)
    {
        $customer = $this->getDoctrine()->getRepository(Customer::class)->find($id);
        return $this->render('customers/show.html.twig', array('customer' => $customer));
    }

    /**
     * @Route("/customer/delete/{id}", name="delete")
     * @Method({"DELETE"})
     *
     */
    public function delete(Request $request, $id)
    {
        $customer = $this->getDoctrine()->getRepository(Customer::class)->find($id);
        $entityManager = $this ->getDoctrine()->getManager();
        $entityManager->remove($customer);
        $entityManager->flush();
        $response = new Response();
        $response->send();
        return $this->render('customers/show.html.twig', array('customer' => $customer));
    }

}
