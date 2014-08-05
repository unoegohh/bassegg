<?php

namespace Unoegohh\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Unoegohh\AdminBundle\Form\AdminOrder;
use Unoegohh\AdminBundle\Form\FoodItemForm;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM;
use Unoegohh\EntitiesBundle\Entity\FoodImage;
use Unoegohh\EntitiesBundle\Entity\FoodItem;

class OrdersController extends Controller
{
    public function indexAction(Request $request)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $orderRepo = $em->getRepository('UnoegohhEntitiesBundle:Order');

        $orders = $orderRepo->findBy(array(),array("id" => "ASC"));


        return $this->render('UnoegohhAdminBundle:Order:index.html.twig', array('result'=>$orders));
    }

    public function editAction(Request $request, $id)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $foodRepo = $em->getRepository('UnoegohhEntitiesBundle:Order');
        $food = $foodRepo->find($id);

        if(!$food){
            throw new Exception("Заказ не найден");
        }

        $form = $this->createForm(new AdminOrder(), $food);

        $form->handleRequest($request);

        if($form->isValid()){
            $food = $form->getData();
            $em->persist($food);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Заказ обновлен!'
            );
            return $this->redirect($this->generateUrl('unoegohh_admin_orders'));

        }
        $order = $food->getOrder();
        return $this->render('UnoegohhAdminBundle:Order:edit.html.twig', array('form'=>$form->createView(), 'item' => $food, 'order' => unserialize($this->mres($order))));
    }

    public function mres($value)
    {
        $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
        $replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");

        return str_replace($replace, $search, $value);
    }
}
