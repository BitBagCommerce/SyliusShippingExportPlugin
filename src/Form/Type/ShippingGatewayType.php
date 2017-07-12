<?php

/**
 * This file was created by the developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on kontakt@bitbag.pl.
 */

namespace BitBag\ShippingExportPlugin\Form\Type;

use BitBag\ShippingExportPlugin\Entity\ShippingGatewayInterface;
use Sylius\Bundle\ResourceBundle\Form\Registry\FormTypeRegistryInterface;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * @author Mikołaj Król <mikolaj.krol@bitbag.pl>
 */
final class ShippingGatewayType extends AbstractResourceType
{
    /**
     * @var FormTypeRegistryInterface
     */
    private $gatewayConfigurationTypeRegistry;

    /**
     * {@inheritdoc}
     *
     * @param FormTypeRegistryInterface $gatewayConfigurationTypeRegistry
     */
    public function __construct(
        $dataClass,
        array $validationGroups = [],
        FormTypeRegistryInterface $gatewayConfigurationTypeRegistry
    ) {
        parent::__construct($dataClass, $validationGroups);

        $this->gatewayConfigurationTypeRegistry = $gatewayConfigurationTypeRegistry;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $factoryName = $options['data']->getFactoryName();

        $builder
            ->add('factoryName', TextType::class, [
                'label' => 'bitbag.form.gateway_config.type',
                'disabled' => true,
                'data' => $factoryName,
            ])
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($factoryName) {
                $shippingGateway = $event->getData();

                if (!$shippingGateway instanceof ShippingGatewayInterface) {
                    return;
                }

                if (!$this->gatewayConfigurationTypeRegistry->has('shipping_gateway_config', $factoryName)) {
                    return;
                }

                $configType = $this->gatewayConfigurationTypeRegistry->get('shipping_gateway_config', $factoryName);
                $event->getForm()->add('config', $configType, [
                    'label' => false,
                    'auto_initialize' => false,
                ]);
            })
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'sylius_payum_gateway_config';
    }
}