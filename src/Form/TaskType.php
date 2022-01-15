<?php

namespace App\Form;

use App\Entity\Task;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use DateTime;

class TaskType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('task', null, [
                'attr' => [
                        'class' => 'form-control',
                    ],
            ])
            ->add('dueDate', DateTimeType::class, [
                    'widget' => 'single_text',
                    'format' => 'm/d/Y',
                    'html5' => false,
                    'attr' => [
                        'class' => 'datepicker form-control',
                    ],
                ]
            )
            ->add('completed')
        ;

        $builder->get('dueDate')
                ->addModelTransformer(new CallbackTransformer(
                    function(?string $dueDate) {
                        return $dueDate ? (new DateTime($dueDate))->format('m/d/Y') : null;
                    },
                    function(DateTime | string $dueDate) {
                        return $dueDate->setTime(23, 59, 59);
                    }
                ));
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
        ]);
    }
}
