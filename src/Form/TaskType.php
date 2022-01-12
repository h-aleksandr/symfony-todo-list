<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('task')
            // ->add('dueDate',
            //     null,
            //     [
            //         // 'attr' => [
            //         //     'id' => 'datepicker',
            //         // ],
			// 		'placeholder' => [
        	// 			'year' => 'Year',
			// 			'month' => 'Month',
			// 			'day' => 'Day',
        	// 			// 'hour' => 'Hour',
			// 			// 'minute' => 'Minute'
            //         ],
			// 		'widget' => 'choice',
			// 		'years' => range(2020,2025)
            //     ]
            // )
            ->add('completed')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
