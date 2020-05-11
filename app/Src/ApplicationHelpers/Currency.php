<?php

namespace App\Src\ApplicationHelpers;

class Currency
{

    public static $usd = [

        ['https://spreadsheets.google.com/feeds/list/0Av2v4lMxiJ1AdE9laEZJdzhmMzdmcW90VWNfUTYtM2c/2/public/basic', '//atom:feed/atom:entry/atom:title[text() = "RUB"]/../atom:content', 'atom', "http://www.w3.org/2005/Atom"],

        ['http://www.floatrates.com/daily/usd.xml', '//channel/item/targetCurrency[text() = "RUB"]/../exchangeRate', "", ""],

        ['http://www.cbr.ru/scripts/XML_daily.asp', '//ValCurs/Valute/CharCode[text() = "USD"]/../Value', "", ""]

    ];

    public static $eur = [

        ['http://spreadsheets.google.com/feeds/list/0Av2v4lMxiJ1AdE9laEZJdzhmMzdmcW90VWNfUTYtM2c/1/public/basic', '//atom:feed/atom:entry/atom:title[text() = "RUB"]/../atom:content', 'atom', "http://www.w3.org/2005/Atom"],

        ['http://www.floatrates.com/daily/eur.xml', '//channel/item/targetCurrency[text() = "RUB"]/../exchangeRate', "", ""],

        ['http://www.cbr.ru/scripts/XML_daily.asp', '//ValCurs/Valute/CharCode[text() = "EUR"]/../Value', "", ""]

    ];

    public static function getCurrency($xml_arrays)
    {

        $currencies = [];

        $currencies = array_map(function ($xml_array) {

            $document = new \DOMdocument();


            try {
                if (@$document->load($xml_array[0]) === false) {
                    throw new \Exception("Error");
                }

                $xpath = new \DOMXpath($document);

                $xpath->registerNamespace($xml_array[2], $xml_array[3]);

                $currency = $xpath->evaluate($xml_array[1]);

                $cur = $currency->item(0)->nodeValue;

                $cur =  preg_replace('/[,]/', '.', $cur);

                $cur = (float) preg_replace('/[^0-9\.,]/', '', $cur);

                return $cur;
            } catch (\Exception $e) {
            };
        }, self::${$xml_arrays});

        $currencies = array_filter($currencies);

        if (count($currencies) === 0) {
            exit("Курс не найден");
        }

        return max($currencies);
    }
}
