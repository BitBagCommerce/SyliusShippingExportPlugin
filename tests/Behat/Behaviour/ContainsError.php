<?php

/*
 * This file has been created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace Tests\BitBag\SyliusShippingExportPlugin\Behat\Behaviour;

use Behat\Mink\Element\NodeElement;
use Sylius\Behat\Behaviour\DocumentAccessor;
use Webmozart\Assert\Assert;

trait ContainsError
{
    use DocumentAccessor;

    public function hasError(string $message, string $errorClass = '.sylius-validation-error'): bool
    {
        $errors = $this->getDocument()->findAll('css', $errorClass);

        Assert::greaterThan(count($errors), 0, sprintf(
            'No error node elements with %s class were found.',
            $errorClass
        ));

        /** @var NodeElement $error */
        foreach ($errors as $error) {
            if ($error->getText() === $message) {
                return true;
            }
        }

        return false;
    }
}
