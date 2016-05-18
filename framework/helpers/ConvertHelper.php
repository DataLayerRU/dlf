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
     * @return DOMDocument
     */
    public static function array2XML($haystack)
    {
        $args   = func_get_args();
        $root   = isset($args[2]) ? $args[2] : new \DOMDocument("1.0", "utf-8");
        $parent = isset($args[1]) ? $args[1] : null;
        $isRoot = $parent === null;

        foreach ($haystack as $key => $val) {
            if (is_array($val)) {
                $parent = $root->createElement($key);
                self::array2xml($val, $parent, $root);
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