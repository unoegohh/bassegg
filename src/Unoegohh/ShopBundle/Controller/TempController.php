<?php

namespace Unoegohh\ShopBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use Unoegohh\EntitiesBundle\Entity\Order;
use Unoegohh\ShopBundle\Form\OrderForm;

class TempController extends Controller
{
    public function indexRuAction()
    {
        return $this->render('UnoegohhShopBundle:New:index.html.twig');
    }

    public function indexEngAction()
    {
        return $this->render('UnoegohhShopBundle:New:indexEng.html.twig');
    }
    public function cartRuAction(Request $request)
    {
        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();
        $order = new Order();
        $order->setDeliveryType(1);
        $form= $this->createForm(new OrderForm(), $order);

        $form->handleRequest($request);

        if($form->isValid()){
            $order = $form->getData();
            $order->setStatus(1);
            $order->setPaymentType(1);
            $order->setDateCreated(new \DateTime('now'));
            $em->persist($order);
            $em->flush();
            $ch = curl_init("http://sms.ru/sms/send");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_POSTFIELDS, array(

                "api_id"		=>	$this->container->getParameter("phone_api"),
                "to"			=>	$this->container->getParameter("phone"),
                "text"		=>"TechArtStore Поступил новый заказ! Id =" . $order->getId()

            ));
            $body = curl_exec($ch);
            curl_close($ch);

            $this->get('session')->getFlashBag()->add(
                'notice',
                'Товар добавлен!'
            );
            return $this->redirect($this->generateUrl('unoegohh_shop_temp_index_ru'));
        }
        return $this->render('UnoegohhShopBundle:New:cart.html.twig', array('form' => $form->createView()));
    }
    public function cartEngAction()
    {
        return $this->render('UnoegohhShopBundle:New:cartEng.html.twig');
    }

}
