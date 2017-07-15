<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace BitBag\ShippingExportPlugin\Form\Type;

use BitBag\ShippingExportPlugin\Context\ShippingGatewayContextInterface;
use BitBag\ShippingExportPlugin\Entity\ShippingGatewayInterface;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Component\Core\Repository\ShippingMethodRepositoryInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class ShippingGatewayType extends AbstractResourceType
{
    /**
     * @var ShippingGatewayContextInterface
     */
    private $shippingGatewayTypeContext;

    /**
     * @var ShippingMethodRepositoryInterface
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
        $shippingMethodModelClass
    )
    {
        parent::__construct($dataClass, $validationGroups);

        $this->shippingGatewayTypeContext = $shippingGatewayTypeContext;
        $this->shippingMethodRepository = $shippingMethodRepository;
        $this->shippingMethodModelClass = $shippingMethodModelClass;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
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
                'label' => 'sylius.ui.name',
                'data' => $label,
                'required' => false,
                'disabled' => true,
            ])
            ->add('shippingMethod', EntityType::class, [
                'label' => 'sylius.ui.shipping_method',
                'class' => $this->shippingMethodModelClass,
                'data' => $this->shippingMethodRepository->findAll(),
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
    public function getBlockPrefix()
    {
        return 'bitbag_shipping_gateway_config';
    }
}