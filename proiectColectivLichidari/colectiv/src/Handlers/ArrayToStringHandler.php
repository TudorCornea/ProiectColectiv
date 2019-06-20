<?php
/**
 * Created by PhpStorm.
 * User: Tudor
 * Date: 3/5/2019
 * Time: 3:24 PM
 */

namespace App\Handlers;


use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\VisitorInterface;

class ArrayToStringHandler implements SubscribingHandlerInterface
{
    public static function getSubscribingMethods()
    {
        $methods = array();
        $formats = array('json', 'xml', 'yml');
        $collectionTypes = array(
            'arrayToString'
        );

        foreach ($collectionTypes as $type) {
            foreach ($formats as $format) {
                $methods[] = array(
                    'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                    'type' => $type,
                    'format' => $format,
                    'method' => 'deserializeCollection',
                );
                $methods[] = array(
                    'type' => $type,
                    'format' => $format,
                    'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                    'method' => 'serializeCollection',
                );
            }
        }

        return $methods;
    }

    public function deserializeCollection(VisitorInterface $visitor, $data, array $type, Context $context)
    {
        // See above.
        if (is_array($data)) {
            $type['name'] = 'arrayToString';
            return $visitor->visitString(implode(' ', $data), $type, $context);
        }

        return $visitor->visitString($data, $type, $context);
    }

    public function serializeCollection(VisitorInterface $visitor, $data, array $type, Context $context)
    {
        return $visitor->visitString($data, $type, $context);
    }
}
