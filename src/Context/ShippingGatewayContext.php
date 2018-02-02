<?php

/*
 * This file has been created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace BitBag\SyliusShippingExportPlugin\Context;

use BitBag\SyliusShippingExportPlugin\Entity\ShippingGatewayInterface;
use BitBag\SyliusShippingExportPlugin\Exception\ShippingGatewayLabelNotFound;
use BitBag\SyliusShippingExportPlugin\Exception\ShippingGatewayNotFoundException;
use BitBag\SyliusShippingExportPlugin\Repository\ShippingGatewayRepositoryInterface;
use Sylius\Bundle\ResourceBundle\Form\Registry\FormTypeRegistryInterface;
use Symfony\Component\HttpFoundation\RequestStack;

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
    ) {
        $this->requestStack = $requestStack;
        $this->shippingGatewayFormTypeRegistry = $shippingGatewayFormTypeRegistry;
        $this->shippingGatewayRepository = $shippingGatewayRepository;
        $this->shippingGateways = $shippingGateways;
    }

    /**
     * {@inheritdoc}
     */
    public function getFormType(): ?string
    {
        $code = $this->getCode();

        return $this->shippingGatewayFormTypeRegistry->get('shipping_gateway_config', $code);
    }

    /**
     * {@inheritdoc}
     */
    public function getCode(): ?string
    {
        $request = $this->requestStack->getCurrentRequest();
        $id = $request->get('id');

        if (null !== $id) {
            return $this->getExistingShippingGateway($id)->getCode();
        }

        $code = $request->get('code');

        if (false === $this->shippingGatewayFormTypeRegistry->has('shipping_gateway_config', $code)) {
            throw new  ShippingGatewayNotFoundException(sprintf(
                'Gateway with %s code could not be found',
                $code
            ));
        }

        return $code;
    }

    /**
     * {@inheritdoc}
     */
    public function getLabelByCode(?string $code): ?string
    {
        foreach ($this->shippingGateways as $shippingGatewayCode => $shippingGatewayLabel) {
            if ($shippingGatewayCode === $code) {
                return $shippingGatewayLabel;
            }
        }

        throw new ShippingGatewayLabelNotFound($code);
    }

    /**
     * @param int|null $id
     *
     * @return ShippingGatewayInterface|null
     *
     * @throws ShippingGatewayNotFoundException
     */
    private function getExistingShippingGateway(?int $id): ?ShippingGatewayInterface
    {
        /** @var ShippingGatewayInterface|null $shippingGateway */
        $shippingGateway = $this->shippingGatewayRepository->find($id);

        if (false === $shippingGateway instanceof ShippingGatewayInterface) {
            throw new  ShippingGatewayNotFoundException(sprintf(
                'Gateway with %s id could not be found',
                $id
            ));
        }

        return $shippingGateway;
    }
}
