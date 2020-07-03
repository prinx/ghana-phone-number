<?php

namespace Prinx\GhanaPhoneNumber;

/**
 * Ghana phone numbers utility class
 *
 * @author Prince Dorcis <princedorcis@gmail.com>
 */
class GhanaPhoneNumber
{
    /**
     * Networks associated to their specific data
     *
     * @var array
     */
    protected static $networkSpecific = [
        "MTN" => [
            "mnc" => "01",
            "patterns" => [
                "((\+?233\(0\)|\+?233|0))?24[0-9]{7,10}",
                "((\+?233\(0\)|\+?233|0))?54[0-9]{7,10}",
                "((\+?233\(0\)|\+?233|0))?55[0-9]{7,10}",
                "((\+?233\(0\)|\+?233|0))?59[0-9]{7,10}",
            ],
        ],
        "AIRTEL-TIGO" => [
            "mnc" => "03",
            "patterns" => [
                "((\+?233\(0\)|\+?233|0))?27[0-9]{7,10}",
                "((\+?233\(0\)|\+?233|0))?57[0-9]{7,10}",
                "((\+?233\(0\)|\+?233|0))?26[0-9]{7,10}",
                "((\+?233\(0\)|\+?233|0))?56[0-9]{7,10}",
            ],
        ],
        "VODAFONE" => [
            "mnc" => "02",
            "patterns" => [
                "((\+?233\(0\)|\+?233|0))?20[0-9]{7,10}",
                "((\+?233\(0\)|\+?233|0))?50[0-9]{7,10}",
            ],
        ],
        "GLO" => [
            "mnc" => "07",
            "patterns" => [
                "((\+?233\(0\)|\+?233|0))23[0-9]{7,10}",
            ],
        ],
        "EXPRESSO" => [
            "mnc" => "05",
            "patterns" => [
                "((\+?233\(0\)|\+?233|0))?28[0-9]{7,10}",
            ],
        ],
    ];

    /**
     * Check if a number belongs to a network
     *
     * @param string $network
     * @param string $number
     * @return boolean
     */
    public static function isNetwork($network, $number)
    {
        if (!isset(self::$networkSpecific[$network])) {
            return false;
        }

        $patterns = self::$networkSpecific[$network]['patterns'];
        foreach ($patterns as $pattern) {
            if (preg_match('/' . $pattern . '/', $number)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns the network to which belongs the number
     *
     * @param string $number
     * @return string
     */
    public static function getNetwork($number)
    {
        foreach (self::$networkSpecific as $network => $networkData) {
            if (self::isNetwork($network, $number)) {
                return $network;
            }
        }

        return null;
    }

    /**
     * Return the mnc of a particualr network
     *
     * @param string $networkOrNumber
     * @return string
     */
    public static function getMnc($networkOrNumber)
    {
        $network = (isset(self::$networkSpecific[$networkOrNumber]) ?
            $networkOrNumber : self::getNetwork($networkOrNumber));

        return $network ? self::$networkSpecific[$networkOrNumber]['mnc'] : null;
    }

    /**
     * Returns the phone patterns for a specific network
     *
     * @param string $network
     * @return array
     */
    public function phonePatterns($network)
    {
        return isset(self::$networkSpecific[$network]) ? self::$networkSpecific[$network]['patterns'] : null;
    }
}
