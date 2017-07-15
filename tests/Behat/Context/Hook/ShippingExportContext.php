<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace Tests\BitBag\ShippingExportPlugin\Behat\Context\Hook;

use Behat\Behat\Context\Context;
use Symfony\Component\Filesystem\Exception\IOException;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class ShippingExportContext implements Context
{
    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var string
     */
    private $shippingLabelsPath;

    public function __construct(Filesystem $filesystem, $shippingLabelsPath)
    {
        $this->filesystem = $filesystem;
        $this->shippingLabelsPath = $shippingLabelsPath;
    }

    /**
     * @BeforeScenario
     */
    public function cleanLabelsDirectoryBeforeScenario()
    {
        $this->cleanLabelsDirectory();
    }

    /**
     * @AfterScenario
     */
    public function cleanLabelsDirectoryAfterScenario()
    {
        $this->cleanLabelsDirectory();
    }

    /**
     * @throws IOException When removal fails
     */
    private function cleanLabelsDirectory()
    {
        $this->filesystem->remove($this->shippingLabelsPath);
    }
}