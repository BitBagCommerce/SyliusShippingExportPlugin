<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace spec\BitBag\ShippingExportPlugin\Entity;

use BitBag\ShippingExportPlugin\Entity\ShippingGatewayTranslation;
use BitBag\ShippingExportPlugin\Entity\ShippingGatewayTranslationInterface;
use PhpSpec\ObjectBehavior;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class ShippingGatewayTranslationSpec extends ObjectBehavior
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
