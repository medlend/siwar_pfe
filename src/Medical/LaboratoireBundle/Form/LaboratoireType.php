<?php

namespace Medical\LaboratoireBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LaboratoireType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('user',RegistrationFormType::class , array(
            'label' => false
        ))
            ->add('mailLab')
            ->add('telLab')
            ->add('faxLab')
            ->add('hOuverture')
            ->add('hFermeture')
            ->add('siteWeb')
            ->add('latitude')
            ->add('longitude')
            ->add('user')        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Medical\LaboratoireBundle\Entity\Laboratoire'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'medical_laboratoirebundle_laboratoire';
    }


}
