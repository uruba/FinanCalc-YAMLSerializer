<?php

namespace FinanCalc\Utils\Serializers {

    use FinanCalc\Interfaces\Serializer\SerializerInterface;
    use Symfony\Component\Yaml\Yaml;

    /**
     * Class YAMLSerializer
     * @package FinanCalc\Utils\Serializers
     */
    class YAMLSerializer implements SerializerInterface {

        /**
         * @param array $inputArray
         * @return mixed
         */
        public static function serializeArray(array $inputArray)
        {
            return Yaml::dump($inputArray);
        }
    }
}