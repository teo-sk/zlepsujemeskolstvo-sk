<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SuggestionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category',  'entity', array(
                    'label' => 'Kategória',
                    'class' => 'AppBundle:Category',
                    'group_by' => 'parent',
                    'query_builder' => function (\AppBundle\Repository\CategoryRepository $repository)
                      {return $repository->createQueryBuilder('c')->where('c.parent IS NOT NULL');}
                ))
            ->add('name', null, array(
                    'label' => "Meno"
                ))
            ->add('surname', null, array(
                    'label' => "Priezvisko"
                ))
            ->add('organization', null, array(
                    'label' => "Organizácia"
                ))
            ->add('email')
            ->add('text', null, array(
                    'label' => "Váš podnet (Maximálne 3600 znakov)"
                ))
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
            'data_class' => 'AppBundle\Entity\Suggestion'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_suggestion';
    }
}
