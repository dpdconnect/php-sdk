<?php

namespace DpdConnect\Sdk\Util;

interface StreetSplitterInterface
{
    const OPTION_A_ADDITION_1   = 'A_Addition_to_address_1';
    const OPTION_A_STREET_NAME  = 'A_Street_name_1';
    const OPTION_A_HOUSE_NUMBER = 'A_House_number_1';
    const OPTION_A_ADDITION_2   = 'A_Addition_to_address_2';
    const OPTION_B_ADDITION_1   = 'B_Addition_to_address_1';
    const OPTION_B_STREET_NAME  = 'B_Street_name';
    const OPTION_B_HOUSE_NUMBER = 'B_House_number';
    const OPTION_B_ADDITION_2   = 'B_Addition_to_address_2';

    /**
     * @param $street
     *
     * @return string[]
     */
    public static function splitStreet($street);
}
