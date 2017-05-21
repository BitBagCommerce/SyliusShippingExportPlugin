<?php

namespace spec\BitBag\ShippingExportPlugin\Entity;

use BitBag\ShippingExportPlugin\Entity\ShippingGatewayTranslation;
use BitBag\ShippingExportPlugin\Entity\ShippingGatewayTranslationInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ShippingGatewayTranslationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ShippingGatewayTranslation::class);
    }

    function it_implements_translation_interface()
    {
        $this->shouldImplement(ShippingGatewayTranslationInterface::class);
    }
}
