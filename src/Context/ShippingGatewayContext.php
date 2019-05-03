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
    /** @var RequestStack */
    private $requestStack;

    /** @var FormTypeRegistryInterface */
    private $shippingGatewayFormTypeRegistry;

    /** @var ShippingGatewayRepositoryInterface */
    private $shippingGatewayRepository;

    /** @var array */
    private $shippingGateways;

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

    public function getFormType(): ?string
    {
        $code = $this->getCode();

        return $this->shippingGatewayFormTypeRegistry->get('shipping_gateway_config', $code);
    }

    public function getCode(): ?string
    {
        $request = $this->requestStack->getCurrentRequest();
        $id = $request->get('id');

        if (null !== $id) {
            return $this->getExistingShippingGateway((int) $id)->getCode();
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

    public function getLabelByCode(?string $code): ?string
    {
        foreach ($this->shippingGateways as $shippingGatewayCode => $shippingGatewayLabel) {
            if ($code === $shippingGatewayCode) {
                return $shippingGatewayLabel;
            }
        }

        throw new ShippingGatewayLabelNotFound($code);
    }

    private function getExistingShippingGateway(int $id): ShippingGatewayInterface
    {
        /** @var ShippingGatewayInterface|null $shippingGateway */
        $shippingGateway = $this->shippingGatewayRepository->find($id);

        if (false === $shippingGateway instanceof ShippingGatewayInterface) {
            throw new  ShippingGatewayNotFoundException(sprintf(
                'Gateway with %d id could not be found in the database.',
                $id
            ));
        }

        return $shippingGateway;
    }
}
