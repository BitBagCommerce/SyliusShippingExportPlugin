<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusShippingExportPlugin\Application\src\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class FrankMartinShippingGatewayType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('iban', TextType::class, [
                'label' => 'IBAN',
                'constraints' => [
                    new NotBlank([
                        'message' => 'IBAN number cannot be blank.',
                        'groups' => 'bitbag',
                    ]),
                ],
            ])
            ->add('address', TextType::class, [
                'label' => 'Address',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Address cannot be blank.',
                        'groups' => 'bitbag',
                    ]),
                ],
            ])
        ;
    }
}
