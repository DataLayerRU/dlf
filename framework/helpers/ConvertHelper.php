<?php

namespace pwf\helpers;

class ConvertHelper
{

    /**
     * Convert XML to array
     *
     * @param string $xmlString
     * @return string
     */
    public static function XML2Array($xmlString)
    {
        try {
            $xml    = simplexml_load_string($xmlString, "SimpleXMLElement",
                LIBXML_NOCDATA);
            $json   = json_encode($xml);
            $result = json_decode($json, TRUE);
        } catch (\Exception $ex) {
            $result = '';
        }
        return $result;
    }

    /**
     * Convert array to XML object
     *
     * @param array $haystack
     * @param string $rootElementName
     * @return DOMDocument
     */
    public static function array2XML($haystack, $rootElementName = '')
    {
        $args   = func_get_args();
        $isRoot = !isset($args[2]);
        $root   = isset($args[3]) ? $args[3] : new \DOMDocument('1.0', 'utf-8');
        $parent = isset($args[2]) ? $args[2] : ($rootElementName !== '' ? $root->createElement($rootElementName)
                    : null);

        foreach ($haystack as $key => $val) {
            if (is_array($val)) {
                $parent = $root->createElement($key);
                self::array2xml($val, $rootElementName, $parent, $root);
            } elseif ($parent === null) {
                $parent = $root->createElement($key, $val);
            } else {
                $parent->appendChild($root->createElement($key, $val));
            }
        }
        if ($isRoot && $parent !== null) {
            $root->appendChild($parent);
        }

        return $root;
    }
}