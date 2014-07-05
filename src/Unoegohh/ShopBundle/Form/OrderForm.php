<?php
namespace Unoegohh\ShopBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Translation\Translator;

class OrderForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fio')
            ->add('phone')
            ->add('email', 'email')
            ->add('deliveryType', 'choice',array(
                'expanded' => true,
                'multiple' => false,
                'choices' => array(
                    1 => 'По городу Самаре',
                    2 => "Ems",
                    3 => "Автотрейдинг",
                    4 => "Major Express",
                )
            ))
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
        return 'CashOrder';
    }
}