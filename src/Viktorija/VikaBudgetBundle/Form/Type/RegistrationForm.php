<?php
/**
 * Created by PhpStorm.
 * User: Viktorija
 * Date: 6/16/2015
 * Time: 1:57 PM
 */

namespace Viktorija\VikaBudgetBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Viktorija\VikaBudgetBundle\Form\Type;
use Viktorija\VikaBudgetBundle\Entity;



class RegistrationForm extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', 'text', array(
                'label'=>'Vardas:',
                'label_attr'=>array(
                    'class'=>"col-sm-3 control-label",
                    ),
                'attr' => array('class' => "form-control")
            ))

            ->add('age', 'number', array(
                'label'=>'Amžius:',
                'label_attr'=>array(
                    'class'=>"col-sm-3 control-label",
                ),
                'attr' => array('class' => "form-control")
            ))

            ->add('email', 'email', array(
                'label'=>'Jūsų paštas:',
                'label_attr'=>array(
                    'class'=>"col-sm-3 control-label",
                ),
                'attr' => array('class' => "form-control")
            ))


            ->add('username', 'text', array(
                'label'=>'Vartotojo vardas:',
                'label_attr'=>array(
                    'class'=>"col-sm-3 control-label",
                ),
                'attr' => array('class' => "form-control")
            ))
            ->add('password', 'password', array(
                'label'=>'Jūsų slaptažodis:',
                'label_attr'=>array(
                    'class'=>"col-sm-3 control-label",
                ),
                'attr' => array('class' => "form-control")
            ))

            ->add('save', 'submit', array(
                'label' => 'Užsiregistruoti',

                'attr' => array('class'=>"col-sm-offset-4 btn btn-default")
                )
            )
            ->getForm();

    }

    public function getName()
    {
        return 'user' ;
    }



    //geroji praktika pridėti ir tai:
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Viktorija\VikaBudgetBundle\Entity\BudgetUser' ,
            'csrf_protection' => true,
            'csrf_field_name' => '_token' ,
        // a unique key to help generate the secret token
            'intention' => 'task_item' ,
            ));
    }
}
