<?php

namespace Foodsquare\CommonBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UsersType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('photo')
            ->add('pin')
            ->add('facebookId')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                    'data_class' => 'Foodsquare\CommonBundle\Entity\Users',
                    'csrf_protection' => false
                ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return '';
    }
}
