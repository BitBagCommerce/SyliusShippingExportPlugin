<?php

namespace Tests\BitBag\ShippingExportPlugin\Behat\Page\Admin\ShippingGateway;

use Sylius\Behat\Page\Admin\Crud\CreatePage as BaseCreatePage;

final class CreatePage extends BaseCreatePage implements CreatePageInterface
{
    /**
     * @param string $name
     */
    public function selectShippingMethod($name)
    {
        $this->getDocument()->selectFieldOption("Shipping method", $name);
    }

    /**
     * @param string $field
     * @param string $value
     */
    public function fillField($field, $value)
    {
        $this->getDocument()->fillField($field, $value);
    }


    public function submit()
    {
        $this->getDocument()->pressButton("Create");
    }

    /**
     * @param null|string $message
     * @return bool
     */
    public function containsSuccessNotification($message = null)
    {
        return $this->documentContainsElementWithText(".positive.message", $message);
    }

    /**
     * @param null|string $message
     * @return bool
     */
    public function containsErrorNotification($message = null)
    {
        return $this->documentContainsElementWithText(".sylius-validation-error", $message);
    }

    /**
     * @param string $cssSelector
     * @param string $text
     * @return bool
     */
    private function documentContainsElementWithText($cssSelector, $text)
    {
        $foundMessage = $this->getDocument()->find("css", $cssSelector)->getText();

        if ($foundMessage !== null && $text !== null) {
            return $this->contains($foundMessage, $text);
        }

        return $foundMessage !== null ? true : false;
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @return bool
     */
    private function contains($haystack, $needle)
    {
        if (strpos($haystack, $needle) !== false) {
            return true;
        }

        return false;
    }
}