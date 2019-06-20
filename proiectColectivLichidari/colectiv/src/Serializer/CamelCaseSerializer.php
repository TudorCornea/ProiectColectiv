<?php
/**
 * @author Andrei Rusu <andrei.rusu@freshbyteinc.com>.
 */
namespace App\Serializer;

use FOS\RestBundle\Serializer\JMSSerializerAdapter;
use FOS\RestBundle\Serializer\Serializer;
use JMS\Serializer\ContextFactory\DefaultDeserializationContextFactory;
use JMS\Serializer\ContextFactory\DefaultSerializationContextFactory;
use JMS\Serializer\ContextFactory\DeserializationContextFactoryInterface;
use JMS\Serializer\ContextFactory\SerializationContextFactoryInterface;
use JMS\Serializer\Naming\CamelCaseNamingStrategy;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\Handler\HandlerRegistry;
use JMS\Serializer\Handler\DateHandler;
use App\Handlers\ArrayToStringHandler;
use JMS\Serializer\Naming\SerializedNameAnnotationStrategy;

class CamelCaseSerializer extends JMSSerializerAdapter implements Serializer
{

    /**
     * CamelCaseSerializer constructor.
     */
    public function __construct()
    {
        $serializer = SerializerBuilder::create()
            ->addDefaultHandlers()
            ->configureHandlers(
                function (HandlerRegistry $registry) {
                    $registry->registerSubscribingHandler(new DateHandler(\DateTime::ISO8601, date_default_timezone_get()));
                    $registry->registerSubscribingHandler(new ArrayToStringHandler());
                }
            )
            ->setPropertyNamingStrategy(new SerializedNameAnnotationStrategy(new CamelCaseNamingStrategy()))
            ->build();

        parent::__construct($serializer, new DefaultSerializationContextFactory(), new DefaultDeserializationContextFactory());
    }
}
