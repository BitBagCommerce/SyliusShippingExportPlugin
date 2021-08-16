<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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
        string $shippingMethodModelClass
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
                }
            )
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_shipping_gateway_config';
    }
}
