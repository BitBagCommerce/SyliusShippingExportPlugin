<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
*/

declare(strict_types=1);

namespace Tests\BitBag\SyliusShippingExportPlugin\Behat\Context\Hook;

use Behat\Behat\Context\Context;
use Symfony\Component\Filesystem\Filesystem;

final class ShippingExportContext implements Context
{
    /** @var Filesystem */
    private $filesystem;

    /** @var string */
    private $shippingLabelsPath;

    public function __construct(Filesystem $filesystem, $shippingLabelsPath)
    {
        $this->filesystem = $filesystem;
        $this->shippingLabelsPath = $shippingLabelsPath;
    }

    /**
     * @BeforeScenario
     */
    public function cleanLabelsDirectoryBeforeScenario(): void
    {
        $this->cleanLabelsDirectory();
    }

    /**
     * @AfterScenario
     */
    public function cleanLabelsDirectoryAfterScenario(): void
    {
        $this->cleanLabelsDirectory();
    }

    public function cleanLabelsDirectory(): void
    {
        $this->filesystem->remove($this->shippingLabelsPath);
    }
}
