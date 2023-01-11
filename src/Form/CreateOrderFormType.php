<?php

namespace App\Form;

use App\Entity\Currency;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Positive;

class CreateOrderFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('offerType', ChoiceType::class, [
                'choices' => [
                    'Buy' => 'buy',
                    'Sell' => 'sell',
                ],
                'choice_attr' => [
                    'Buy' => ['class' => 'mr-1'],
                    'Sell' => ['class' => 'mr-1 ml-3'],
                ],
                'data' => 'buy',
                'expanded' => true,
                'attr' => ['class' => 'radio-btn-group'],
                'row_attr' => ['class' => 'field'],
                'label_attr' => ['class' => 'label'],
            ])
            ->add('currency', EntityType::class, [
                'class' => Currency::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->select('c')
                        ->where('c.token = true');
                },
                'choice_label' => 'name',
                'choice_value' => function (?Currency $currency) {
                    return $currency ? $currency->getId() : '';
                },
                'placeholder' => 'Choose a Token',
                'required' => false,
                'constraints' => [
                    new NotNull([
                        'message' => 'Choose currency!',
                    ]),
                ],
                'row_attr' => ['class' => 'field'],
                'label_attr' => ['class' => 'label'],
            ])
            ->add('amount', NumberType::class, [
                'constraints' => [new Positive([
                    'message'=>'Add token amount!'
                ])],
                'scale' => 7,
                'data' => 0,
                'required' => false,
                'attr' => ['class' => 'input'],
                'row_attr' => ['class' => 'field'],
                'label_attr' => ['class' => 'label'],
            ])
            ->add('rate', NumberType::class, [
                'scale' => 7,
                'data' => 0,
                'required' => false,
                'constraints' => [new Positive([
                    'message'=>'Add rate!'
                ])],
                'attr' => ['class' => 'input'],
                'row_attr' => ['class' => 'field'],
                'label_attr' => ['class' => 'label'],
            ])
            ->add('exchangedCurrency', EntityType::class, [
                'class' => Currency::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose a Currency/Token',
                'constraints' => [
                    new NotNull([
                        'message' => 'Choose currency!',
                    ]),
                ],
                'required' => false,
                'row_attr' => ['class' => 'field'],
                'label_attr' => ['class' => 'label'],
            ])
            ->add('send', SubmitType::class, [
                'attr' => ['class' => 'button is-primary'],
                'label' => 'Create',
                'row_attr' => ['class' => 'field'],
            ]);
    }
}
