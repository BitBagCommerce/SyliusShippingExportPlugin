<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * You can find more information about us on https://bitbag.io and write us
 * an email on hello@bitbag.io.
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
