<?php

namespace Neralind\TicketBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ShortTicketType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lot', 'entity', array('label' => false,'class' => 'NeralindTicketBundle:Lot', 'expanded' => false))
            ->add('type', 'entity', array('label' => false,'class' => 'NeralindTicketBundle:Type', 'expanded' => false))
            ->add('status', 'entity', array('label' => false, 'class' => 'NeralindTicketBundle:Status', 'expanded' => false))
            ->add('worker', 'user_selector', array('label' => false, 'attr' => array('placeholder' => 'Affecté à')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Neralind\TicketBundle\Entity\Ticket'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'neralind_ticketbundle_short_ticket';
    }
}
