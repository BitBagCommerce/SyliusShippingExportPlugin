<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace BitBag\ShippingExportPlugin\Context;

use BitBag\ShippingExportPlugin\Entity\ShippingGatewayInterface;
use BitBag\ShippingExportPlugin\Exception\ShippingGatewayLabelNotFound;
use BitBag\ShippingExportPlugin\Exception\ShippingGatewayNotFoundException;
use BitBag\ShippingExportPlugin\Repository\ShippingGatewayRepositoryInterface;
use Sylius\Bundle\ResourceBundle\Form\Registry\FormTypeRegistryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class ShippingGatewayContext implements ShippingGatewayContextInterface
{
    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var FormTypeRegistryInterface
     */
    private $shippingGatewayFormTypeRegistry;

    /**
     * @var ShippingGatewayRepositoryInterface
     */
    private $shippingGatewayRepository;

    /**
     * @var array
     */
    private $shippingGateways;

    /**
     * @param RequestStack $requestStack
     * @param FormTypeRegistryInterface $shippingGatewayFormTypeRegistry
     * @param ShippingGatewayRepositoryInterface $shippingGatewayRepository
     * @param array $shippingGateways
     */
    public function __construct(
        RequestStack $requestStack,
        FormTypeRegistryInterface $shippingGatewayFormTypeRegistry,
        ShippingGatewayRepositoryInterface $shippingGatewayRepository,
        array $shippingGateways

    )
    {
        $this->requestStack = $requestStack;
        $this->shippingGatewayFormTypeRegistry = $shippingGatewayFormTypeRegistry;
        $this->shippingGatewayRepository = $shippingGatewayRepository;
        $this->shippingGateways = $shippingGateways;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormType()
    {
        $code = $this->getCode();

        return $this->shippingGatewayFormTypeRegistry->get('shipping_gateway_config', $code);
    }

    /**
     * {@inheritdoc}
     */
    public function getCode()
    {
        $request = $this->requestStack->getCurrentRequest();
        $id = $request->get('id');

        if (null !== $id) {
            return $this->getExistingShippingGateway($id)->getCode();
        }

        $code = $request->get('code');

        if (false === $this->shippingGatewayFormTypeRegistry->has('shipping_gateway_config', $code)) {
            throw new  ShippingGatewayNotFoundException(sprintf(
                "Gateway with %s code could not be found",
                $code
            ));
        }

        return $code;
    }

    /**
     * {@inheritdoc}
     */
    public function getLabelByCode($code)
    {
        foreach ($this->shippingGateways as $shippingGatewayCode => $shippingGatewayLabel) {
            if ($shippingGatewayCode === $code) {
                return $shippingGatewayLabel;
            }
        }

        throw new ShippingGatewayLabelNotFound($code);
    }

    /**
     * @param int $id
     *
     * @return ShippingGatewayInterface
     * @throws ShippingGatewayNotFoundException
     */
    private function getExistingShippingGateway($id)
    {
        /** @var ShippingGatewayInterface|null $shippingGateway */
        $shippingGateway = $this->shippingGatewayRepository->find($id);

        if (false === $shippingGateway instanceof ShippingGatewayInterface) {
            throw new  ShippingGatewayNotFoundException(sprintf(
                "Gateway with %s id could not be found",
                $id
            ));
        }

        return $shippingGateway;
    }
}