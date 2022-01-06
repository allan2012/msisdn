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


    const PREFIXES_SAFARICOM = [
        "254701",
        "254702",
        "254703",
        "254704",
        "254705",
        "254706",
        "254707",
        "254708",
        "254710",
        "254711",
        "254712",
        "254713",
        "254714",
        "254715",
        "254716",
        "254717",
        "254718",
        "254719",
        "254720",
        "254721",
        "254722",
        "254723",
        "254724",
        "254725",
        "254726",
        "254727",
        "254728",
        "254729",
        "254790",
        "254791",
        "254792",
        "254793",
        "254794",
        "254795",
        "254796",
        "254797",
        "254798",
        "254799",
        "25411"
    ];

    const PREFIXES_AIRTEL = [
        "254730",
        "254731",
        "254732",
        "254733",
        "254734",
        "254735",
        "254736", 
        "254737",
        "254738",
        "254739",
        "254750",
        "254751",
        "254752",
        "254753",
        "254754",
        "254755",
        "254756",
        "254785",
        "254786",
        "254787",
        "254788",
        "254789",
        "25410"
    ];

    const PREFIXES_EQUITEL = [
        "254763",
        "254764",
        "254765"
    ];

    const PREFIXES_FAIBA = [
        "254747"
    ];

    const PREFIXES_TELKOM = [
        "254770",
        "254771",
        "254772",
        "254773",
        "254774",
        "254775",
        "254776",
        "254777",
        "254778",
        "254779" 
    ];


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
            self::MNO_SAFARICOM => self::PREFIXES_SAFARICOM,
            self::MNO_AIRTEL => self::PREFIXES_AIRTEL,
            self::MNO_EQUITEL => self::PREFIXES_EQUITEL,
            self::MNO_TELKOM => self::PREFIXES_TELKOM,
            self::MNO_FAIBA => self::PREFIXES_FAIBA
        ];

        foreach ($kenyanMNOs as $k => $v) {
            if (in_array(substr($cleanMsisdn, 0, 6), $v) || in_array(substr($cleanMsisdn, 0, 5), $v)) {
                return $k;
            } 
        }

        return null;
    }
}