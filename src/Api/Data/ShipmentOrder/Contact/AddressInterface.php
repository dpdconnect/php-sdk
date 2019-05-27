<?php

namespace DpdConnect\Sdk\Api\Data\ShipmentOrder\Contact;

use DpdConnect\Sdk\Objects\ShipmentOrder\Contact\Address;

interface AddressInterface
{
    /**
     * @return string
     */
    public function getCompanyName();

    /**
     * @param string $companyName
     * @return Address
     */
    public function setCompanyName($companyName);

    /**
     * @return string
     */
    public function getContactPerson();

    /**
     * @param string $contactPerson
     * @return Address
     */
    public function setContactPerson($contactPerson);

    /**
     * @return string
     */
    public function getName1();

    /**
     * @param string $name1
     * @return Address
     */
    public function setName1($name1);

    /**
     * @return string
     */
    public function getName2();

    /**
     * @param string $name2
     * @return Address
     */
    public function setName2($name2);

    /**
     * @return string
     */
    public function getStreet();

    /**
     * @param string $street
     * @return Address
     */
    public function setStreet($street);

    /**
     * @return string
     */
    public function getHouseNumber();

    /**
     * @param string $houseNumber
     * @return Address
     */
    public function setHouseNumber($houseNumber);

    /**
     * @return string
     */
    public function getPostalCode();

    /**
     * @param string $postalCode
     * @return Address
     */
    public function setPostalCode($postalCode);

    /**
     * @return string
     */
    public function getCity();

    /**
     * @param string $city
     * @return Address
     */
    public function setCity($city);

    /**
     * @return string
     */
    public function getState();

    /**
     * @param string $state
     * @return Address
     */
    public function setState($state);

    /**
     * @return string
     */
    public function getCountry();

    /**
     * @param string $country
     * @return Address
     */
    public function setCountry($country);

    /**
     * @return bool
     */
    public function isCommercialAddress();

    /**
     * @param bool $commercialAddress
     * @return Address
     */
    public function setCommercialAddress($commercialAddress);

    /**
     * @return string
     */
    public function getBuilding();

    /**
     * @param string $building
     * @return Address
     */
    public function setBuilding($building);

    /**
     * @return string
     */
    public function getFloor();

    /**
     * @param string $floor
     * @return Address
     */
    public function setFloor($floor);

    /**
     * @return string
     */
    public function getDepartment();

    /**
     * @param string $department
     * @return Address
     */
    public function setDepartment($department);

    /**
     * @return string
     */
    public function getDoorCode();

    /**
     * @param string $doorCode
     * @return Address
     */
    public function setDoorCode($doorCode);

    /**
     * @return int
     */
    public function getGlobalLocationNumber();

    /**
     * @param int $globalLocationNumber
     * @return Address
     */
    public function setGlobalLocationNumber($globalLocationNumber);

    /**
     * @return string
     */
    public function getPhoneNumber();

    /**
     * @param string $phoneNumber
     * @return Address
     */
    public function setPhoneNumber($phoneNumber);

    /**
     * @return string
     */
    public function getFaxNumber();

    /**
     * @param string $faxNumber
     * @return Address
     */
    public function setFaxNumber($faxNumber);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param string $email
     * @return Address
     */
    public function setEmail($email);

    /**
     * @return string
     */
    public function getWebsite();

    /**
     * @param string $website
     * @return Address
     */
    public function setWebsite($website);

    /**
     * @return string
     */
    public function getEoriNumber();

    /**
     * @param string $eoriNumber
     * @return Address
     */
    public function setEoriNumber($eoriNumber);

    /**
     * @return string
     */
    public function getVatNumber();

    /**
     * @param string $vatNumber
     * @return Address
     */
    public function setVatNumber($vatNumber);

    /**
     * @return string
     */
    public function getComment();

    /**
     * @param string $comment
     * @return Address
     */
    public function setComment($comment);
}
