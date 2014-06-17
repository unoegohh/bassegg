<?php

namespace Unoegohh\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Unoegohh\AdminBundle\Form\ContactForm;
use Unoegohh\AdminBundle\Form\SitePrefForm;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    public function indexAction(Request $request)
    {


        /*
         * @var $em EntityManager
         */
        $em = $this->container->get('doctrine')->getManager();

        $prefRepo = $em->getRepository('UnoegohhEntitiesBundle:Contact');

        $pref = $prefRepo->findOneBy(array(), array(), 1);

        if(!$pref){
            throw new Exception("Ask admin to add pref!");
        }

        $form = $this->createForm(new ContactForm(), $pref);

        $form->handleRequest($request);

        if($form->isValid()){
            $pref = $form->getData();
            $em->persist($pref);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'notice',
                'Сохранено!'
            );
            return $this->redirect($this->generateUrl('unoegohh_admin_contact_pref'));
        }

        return $this->render('UnoegohhAdminBundle:Contact:index.html.twig', array('form'=>$form->createView()));
    }
}
