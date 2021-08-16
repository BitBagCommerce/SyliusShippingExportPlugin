<?php

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
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
