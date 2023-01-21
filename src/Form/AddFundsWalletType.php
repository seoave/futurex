<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\Currency;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Positive;

class AddFundsWalletType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('currency', EntityType::class, [
                'class' => Currency::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->select('c')
                        ->where('c.token = false');
                },
                'choice_label' => 'name',
                'choice_value' => function (?Currency $currency) {
                    return $currency ? $currency->getId() : '';
                },
                'placeholder' => 'Choose a currency',
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
                'constraints' => [
                    new Positive([
                        'message' => 'Add currency amount!',
                    ]),
                ],
                'scale' => 2,
                'data' => 0,
                'required' => false,
                'attr' => ['class' => 'input'],
                'row_attr' => ['class' => 'field'],
                'label_attr' => ['class' => 'label'],
            ])
            ->add('card', IntegerType::class, [
                'constraints' => [
                    new Positive([
                        'message' => 'Add card number!',
                    ]),
                ],
                'data' => 4149444456567878,
                'required' => false,
                'attr' => ['class' => 'input'],
                'row_attr' => ['class' => 'field'],
                'label_attr' => ['class' => 'label'],
                'label' => 'Example Credit card number',
            ])
            ->add('send', SubmitType::class, [
                'attr' => ['class' => 'button is-primary'],
                'row_attr' => ['class' => 'field'],
            ]);
    }
}
