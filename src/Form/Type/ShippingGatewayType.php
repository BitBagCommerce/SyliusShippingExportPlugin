<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
 */

declare(strict_types=1);

namespace BitBag\SyliusShippingExportPlugin\Form\Type;

use BitBag\SyliusShippingExportPlugin\Context\ShippingGatewayContextInterface;
use BitBag\SyliusShippingExportPlugin\Entity\ShippingGatewayInterface;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Webmozart\Assert\Assert;

final class ShippingGatewayType extends AbstractResourceType
{
    /** @var ShippingGatewayContextInterface */
    private $shippingGatewayTypeContext;

    /** @var string */
    private $shippingMethodModelClass;

    public function __construct(
        $dataClass,
        array $validationGroups,
        ShippingGatewayContextInterface $shippingGatewayTypeContext,
        string $shippingMethodModelClass,
    ) {
        parent::__construct($dataClass, $validationGroups);

        $this->shippingGatewayTypeContext = $shippingGatewayTypeContext;
        $this->shippingMethodModelClass = $shippingMethodModelClass;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $code = $this->shippingGatewayTypeContext->getCode();
        $label = $this->shippingGatewayTypeContext->getLabelByCode($code);
        $shippingGatewayType = $this->shippingGatewayTypeContext->getFormType();

        $builder
            ->add('code', TextType::class, [
                'label' => 'sylius.ui.code',
                'data' => $code,
                'required' => false,
                'disabled' => true,
            ])
            ->add('name', TextType::class, [
                'label' => 'sylius.ui.name',
                'data' => $label,
                'required' => false,
            ])
            ->add('shippingMethods', EntityType::class, [
                'label' => 'sylius.ui.shipping_methods',
                'class' => $this->shippingMethodModelClass,
                'placeholder' => 'bitbag.ui.choose_shipping_method',
                'multiple' => true,
            ])
            ->add('config', $shippingGatewayType, [
                'label' => false,
                'auto_initialize' => false,
            ])
            ->addEventListener(
                FormEvents::POST_SUBMIT,
                function (FormEvent $event) use ($code, $label): void {
                    Assert::string($code);
                    Assert::string($label);

                    /** @var ShippingGatewayInterface $shippingGateway */
                    $shippingGateway = $event->getData();
                    $shippingGateway->setCode($code);
                    $shippingGateway->setName($label);
                },
            )
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_shipping_gateway_config';
    }
}
