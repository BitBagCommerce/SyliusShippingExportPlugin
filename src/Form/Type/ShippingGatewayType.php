<?php

/*
 * This file has been created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\ShippingExportPlugin\Form\Type;

use BitBag\ShippingExportPlugin\Context\ShippingGatewayContextInterface;
use BitBag\ShippingExportPlugin\Entity\ShippingGatewayInterface;
use Doctrine\ORM\EntityRepository;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Component\Core\Repository\ShippingMethodRepositoryInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

final class ShippingGatewayType extends AbstractResourceType
{
    /**
     * @var ShippingGatewayContextInterface
     */
    private $shippingGatewayTypeContext;

    /**
     * @var ShippingMethodRepositoryInterface|EntityRepository
     */
    private $shippingMethodRepository;

    /**
     * @var string
     */
    private $shippingMethodModelClass;

    /**
     * {@inheritdoc}
     *
     * @param ShippingGatewayContextInterface $shippingGatewayTypeContext
     * @param ShippingMethodRepositoryInterface $shippingMethodRepository
     * @param string $shippingMethodModelClass
     */
    public function __construct(
        $dataClass,
        array $validationGroups = [],
        ShippingGatewayContextInterface $shippingGatewayTypeContext,
        ShippingMethodRepositoryInterface $shippingMethodRepository,
        string $shippingMethodModelClass
    ) {
        parent::__construct($dataClass, $validationGroups);

        $this->shippingGatewayTypeContext = $shippingGatewayTypeContext;
        $this->shippingMethodRepository = $shippingMethodRepository;
        $this->shippingMethodModelClass = $shippingMethodModelClass;
    }

    /**
     * {@inheritdoc}
     */
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
            ->add('label', TextType::class, [
                'label' => 'bitbag.ui.label',
                'data' => $label,
                'required' => false,
                'disabled' => true,
            ])
            ->add('shippingMethod', EntityType::class, [
                'label' => 'sylius.ui.shipping_method',
                'class' => $this->shippingMethodModelClass,
                'query_builder' => $this->shippingMethodRepository->createQueryBuilder('o'),
                'placeholder' => 'bitbag.ui.choose_shipping_method',
            ])
            ->add('config', $shippingGatewayType, [
                'label' => false,
                'auto_initialize' => false,
            ])
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) use ($code, $label) {
                /** @var ShippingGatewayInterface $shippingGateway */
                $shippingGateway = $event->getData();

                $shippingGateway->setCode($code);
                $shippingGateway->setLabel($label);
            })
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix(): string
    {
        return 'bitbag_shipping_gateway_config';
    }
}
