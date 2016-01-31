<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MailingType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('fingerprint', 'hidden')
            ->add('submit', 'submit', array(
                    'label' => 'Odoslať',
                    'attr' => array(
                        'class' => 'btn-primary btn'
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
            'data_class' => 'AppBundle\Entity\Mailing'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_mailing';
    }
}
