<?php
namespace Unoegohh\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\Translator;

class AdminOrder extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fio')
            ->add('descr',"textarea")
            ->add('phone')
            ->add('email')
            ->add('status', 'choice',array(
                'choices' => array(1 => 'Новый', 2 => "Принят", 3 => "Доставлен", 4 => "Отклонен"
            )))
            ->add('paymentType', 'choice',array(
                'choices' => array(1 => 'При получении', 2 => "Картой")
            ))
            ->add('address',"textarea")
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Unoegohh\\EntitiesBundle\\Entity\\Order',
        ));
    }

    public function getName()
    {
        return 'Order';
    }
}