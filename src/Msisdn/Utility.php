<?php

namespace Msisdn;

/**
 * MSISDN Utility class
 * @author Allan Kibet <allan.koskei@gmail.com>
 * @see https://en.wikipedia.org/wiki/Telephone_numbers_in_Kenya
 * @version 1.0.1
 */
class Utility 
{
    const MNO_SAFARICOM = 'Safaricom';
    const MNO_AIRTEL = "Airtel";
    const MNO_EQUITEL = "Equitel";
    const MNO_FAIBA = "Faiba";
    const MNO_TELKOM = "Telkom";


    /**
     * Standardize MSISDN Format. Returns -1 if MSISDN is invalid
     *
     * @param int $msisdn
     * @return int
     */
    public static function clean(string $msisdn) : int
    {
        // Remove any white space and (+) character in the string
        $msisdn = str_replace('+', '', preg_replace("/\s+/", "", $msisdn));

        if (substr($msisdn, 0, 1) == '0') {
            $msisdn = '254' . ltrim($msisdn, '0');
        }

        if (substr($msisdn, 0, 1) == '7') {
            $msisdn = '254' . $msisdn;
        }

        // Allowance for new 25411... extensions
        if (substr($msisdn, 0, 1) == '1') {
            $msisdn = '254' . $msisdn;
        }
        
        return self::checkMSISDNLength(intval($msisdn));
    }


    /**
     * Check the MSISDN length
     *
     * @param int $msisdn
     * @return int
     */
    private static function checkMSISDNLength(string $msisdn) : int
    {
        return (int)(strlen($msisdn) == 12 && is_numeric($msisdn)) ? $msisdn : -1;
    }


    /**
     * Get Mobile Network Operator channel associated for a given phone number
     *
     * @param string $msisdn
     * @return any
     */
    public static function getMobileNetworkOperator(string $msisdn): ?string
    {
        $cleanMsisdn = self::clean($msisdn);

        $kenyanMNOs = [
            self::MNO_SAFARICOM => self::fetchPrefixesByMNO(self::MNO_SAFARICOM),
            self::MNO_AIRTEL => self::fetchPrefixesByMNO(self::MNO_AIRTEL),
            self::MNO_EQUITEL => self::fetchPrefixesByMNO(self::MNO_EQUITEL),
            self::MNO_TELKOM => self::fetchPrefixesByMNO(self::MNO_TELKOM),
            self::MNO_FAIBA => self::fetchPrefixesByMNO(self::MNO_FAIBA)
        ];

        foreach ($kenyanMNOs as $k => $v) {
            if (in_array(substr($cleanMsisdn, 0, 6), $v) || in_array(substr($cleanMsisdn, 0, 5), $v)) {
                return $k;
            } 
        }

        return null;
    }


    /**
     * Fetch prefixes from JSON files
     *
     * @param string $mno
     * @return array
     */
    private static function fetchPrefixesByMNO(string $mno) : ?array
    {
        $data = @file_get_contents("prefixes/". strtolower($mno). ".json");

        if ($data === false) {
            return null;
        }

        return json_decode($data);      
    }
}