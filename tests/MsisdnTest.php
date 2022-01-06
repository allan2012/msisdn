<?php declare(strict_types=1);
use PHPUnit\Framework\TestCase;
use Msisdn\Utility;

final Class MsisdnTest extends TestCase
{
    const CLEAN_MSISDN_SAMPLE = 254720000000;
    const CLEAN_NEW_MSISDN_SAMPLE = 254110900200;


    public function testMsisdnWithLeadingPlusIsSanitized() : void
    {
        $msidn = "+254720000000";
        $this->assertEquals(
            self::CLEAN_MSISDN_SAMPLE, 
            Utility::clean($msidn)
        );
    }


    public function testMsisdnWithWhiteSpacesIsSanitized() : void
    {
        $msidn = "+254 720000000";
        $this->assertEquals(
            self::CLEAN_MSISDN_SAMPLE, 
            Utility::clean($msidn)
        );
    }


    public function testMsisdnWithInvalidCharacterCountIsNotSanitized() : void
    {
        $msidn = "+2547200";
        $this->assertEquals(-1, Utility::clean($msidn));
    }


    public function testMsisdnWithNewPrefixFormatIsSanitized() : void
    {
        $msidn = "0110 900 200";
        $this->assertEquals(
            self::CLEAN_NEW_MSISDN_SAMPLE, 
            Utility::clean($msidn)
        );
    }


    public function testSafaricomMsisdnMatchesCorrectMno() : void
    {
        $this->assertEquals(
            Utility::MNO_SAFARICOM, 
            Utility::getMobileNetworkOperator((string)self::CLEAN_MSISDN_SAMPLE)
        );
    }

    public function testAirtelMsisdnMatchesCorrectMno() : void
    {
        $this->assertEquals(
            Utility::MNO_AIRTEL, 
            Utility::getMobileNetworkOperator("0751 900 300")
        );
    }

    public function testFaibaMsisdnMatchesCorrectMno() : void
    {
        $this->assertEquals(
            Utility::MNO_FAIBA, 
            Utility::getMobileNetworkOperator("+254747200022")
        );
    }

    public function testTelkomMsisdnMatchesCorrectMno() : void
    {
        $this->assertEquals(
            Utility::MNO_TELKOM, 
            Utility::getMobileNetworkOperator("254774544500")
        );
    }

    public function testEquitelMsisdnMatchesCorrectMno() : void
    {
        $this->assertEquals(
            Utility::MNO_EQUITEL, 
            Utility::getMobileNetworkOperator("254764300222")
        );
    }


    public function testNewSafaricomMsisdnMatchesCorrectMno() : void
    {
        $this->assertEquals(
            Utility::MNO_SAFARICOM, 
            Utility::getMobileNetworkOperator((string)self::CLEAN_NEW_MSISDN_SAMPLE)
        );
    }
}