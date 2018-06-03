<?php

namespace Msisdn;

/**
 * MSISDN Utility class
 * @author Allan Kibet <allan.koskei@gmail.com>
 * @see https://en.wikipedia.org/wiki/Telephone_numbers_in_Kenya
 * @version 1.0.0
 */
class Utility
{
    /**
     * Standardize MSISDN Format
     *
     * @param int $msisdn
     * @return int
     */
    public static function clean(string $msisdn) : int
    {
        if (substr($msisdn, 0, 1) == '0') {
            $msisdn = '254' . ltrim($msisdn, '0');
        }
        if (substr($msisdn, 0, 1) == '7') {
            $msisdn = '254' . $msisdn;
        }
        return self::checkMSISDNLength(intval($msisdn));
    }

    /**
     * Check the message count
     *
     * @param int $msisdn
     * @return int
     */
    private static function checkMSISDNLength(string $msisdn) : int
    {
        return (int)(strlen($msisdn) == 12 && is_numeric($msisdn)) ? $msisdn : -1;
    }

    /**
     * Get telco channel associated with the number
     *
     * @param string $msisdn
     * @return string
     */
    public static function channel(string $msisdn) : string
    {
        $clean_msisdn = self::clean($msisdn);

        if (in_array(substr($clean_msisdn, 0, 6), Utility::SAFARICOM_PREFIXES)) {
            return strval('SAFARICOM');
        } 

        if (in_array(substr($clean_msisdn, 0, 6), Utility::AIRTEL_PREFIXES)) {
            return strval('AIRTEL');
        } 

        if (in_array(substr($clean_msisdn, 0, 6), Utility::TELKOM_PREFIXES)) {
            return strval('TELKOM');
        } 

        if (in_array(substr($clean_msisdn, 0, 6), Utility::EQUITEL_PREFIXES)) {
            return strval('EQUITEL');
        } 
        if (in_array(substr($clean_msisdn, 0, 6), Utility::FAIBA_PREFIXES)) {
            return strval('FAIBA');
        } 

        return strval('UNDEFINED');
    }

    const SAFARICOM_PREFIXES = [
        "254701","254702","254703","254704","254705","254706","254707",
        "254708","254710","254711","254712","254713","254714","254715",
        "254716","254717","254718","254719","254720", "254721", "254722",
        "254723", "254724", "254725","254726","254727","254728","254729",
        "254790", "254791","254792"];

    const AIRTEL_PREFIXES = ["254730","254731","254732","254733","254734",
        "254735","254736", "254737","254738","254739","254750","254751","254752",
        "254753","254754","254755","254756","254785","254786","254787","254788",
        "254789"];

    const TELKOM_PREFIXES = ["254770","254771","254772","254773","254774","254775","254776"];

    const EQUITEL_PREFIXES = ["254763","254764","254765"];

    const FAIBA_PREFIXES = ["254747"];

}