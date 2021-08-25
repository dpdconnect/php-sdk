<?php

namespace DpdConnect\Sdk\Objects\ShipmentOrder\Contact;

use DpdConnect\Sdk\Api\Data\ShipmentOrder\Contact\AddressInterface;
use DpdConnect\Sdk\Objects\BaseObject;
use JsonSerializable;

/**
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @SuppressWarnings(PHPMD.TooManyFields)
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class Address extends BaseObject implements JsonSerializable, AddressInterface
{
    /**
     * @var string
     */
    protected $companyname;

    /**
     * @var string
     */
    protected $contactPerson;

    /**
     * @var string
     */
    protected $name1;

    /**
     * @var string
     */
    protected $name2;

    /**
     * @var string
     */
    protected $street;

    /**
     * @var string
     */
    protected $housenumber;

    /**
     * @var string
     */
    protected $postalcode;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var string
     */
    protected $state;

    /**
     * @var string
     */
    protected $country;

    /**
     * @var boolean
     */
    protected $commercialAddress = false;

    /**
     * @var string
     */
    protected $building;

    /**
     * @var string
     */
    protected $floor;

    /**
     * @var string
     */
    protected $department;

    /**
     * @var string $doorCode
     */
    protected $doorcode;

    /**
     * @var int
     */
    protected $globalLocationNumber;

    /**
     * @var string
     */
    protected $phoneNumber;

    /**
     * @var string
     */
    protected $faxNumber;

    /**
     * @var string
     */
    protected $email;

    /**
     * @var string
     */
    protected $website;

    /**
     * @var string
     */
    protected $eoriNumber;

    /**
     * @var string
     */
    protected $vatNumber;

    /**
     * @var string
     */
    protected $comment;

    /**
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyname;
    }

    /**
     * @param string $companyName
     *
     * @return Address
     */
    public function setCompanyName($companyName)
    {
        $this->companyname = $companyName;

        return $this;
    }

    /**
     * @return string
     */
    public function getContactPerson()
    {
        return $this->contactPerson;
    }

    /**
     * @param string $contactPerson
     *
     * @return Address
     */
    public function setContactPerson($contactPerson)
    {
        $this->contactPerson = $contactPerson;

        return $this;
    }

    /**
     * @return string
     */
    public function getName1()
    {
        return $this->name1;
    }

    /**
     * @param string $name1
     *
     * @return Address
     */
    public function setName1($name1)
    {
        $this->name1 = $name1;

        return $this;
    }

    /**
     * @return string
     */
    public function getName2()
    {
        return $this->name2;
    }

    /**
     * @param string $name2
     *
     * @return Address
     */
    public function setName2($name2)
    {
        $this->name2 = $name2;

        return $this;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @param string $street
     *
     * @return Address
     */
    public function setStreet($street)
    {
        $this->street = $street;

        return $this;
    }

    /**
     * @return string
     */
    public function getHouseNumber()
    {
        return $this->housenumber;
    }

    /**
     * @param string $houseNumber
     *
     * @return Address
     */
    public function setHouseNumber($houseNumber)
    {
        $this->housenumber = $houseNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalcode;
    }

    /**
     * @param string $postalCode
     *
     * @return Address
     */
    public function setPostalCode($postalCode)
    {
        $this->postalcode = $postalCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     *
     * @return Address
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     *
     * @return Address
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     *
     * @return Address
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return bool
     */
    public function isCommercialAddress()
    {
        return $this->commercialAddress;
    }

    /**
     * @param bool $commercialAddress
     *
     * @return Address
     */
    public function setCommercialAddress($commercialAddress)
    {
        $this->commercialAddress = $commercialAddress;

        return $this;
    }

    /**
     * @return string
     */
    public function getBuilding()
    {
        return $this->building;
    }

    /**
     * @param string $building
     *
     * @return Address
     */
    public function setBuilding($building)
    {
        $this->building = $building;

        return $this;
    }

    /**
     * @return string
     */
    public function getFloor()
    {
        return $this->floor;
    }

    /**
     * @param string $floor
     *
     * @return Address
     */
    public function setFloor($floor)
    {
        $this->floor = $floor;

        return $this;
    }

    /**
     * @return string
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @param string $department
     *
     * @return Address
     */
    public function setDepartment($department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * @return string
     */
    public function getDoorCode()
    {
        return $this->doorcode;
    }

    /**
     * @param string $doorCode
     *
     * @return Address
     */
    public function setDoorCode($doorCode)
    {
        $this->doorcode = $doorCode;

        return $this;
    }

    /**
     * @return int
     */
    public function getGlobalLocationNumber()
    {
        return $this->globalLocationNumber;
    }

    /**
     * @param int $globalLocationNumber
     *
     * @return Address
     */
    public function setGlobalLocationNumber($globalLocationNumber)
    {
        $this->globalLocationNumber = $globalLocationNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     *
     * @return Address
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getFaxNumber()
    {
        return $this->faxNumber;
    }

    /**
     * @param string $faxNumber
     *
     * @return Address
     */
    public function setFaxNumber($faxNumber)
    {
        $this->faxNumber = $faxNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return Address
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param string $website
     *
     * @return Address
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * @return string
     */
    public function getEoriNumber()
    {
        return $this->eoriNumber;
    }

    /**
     * @param string $eoriNumber
     *
     * @return Address
     */
    public function setEoriNumber($eoriNumber)
    {
        $this->eoriNumber = $eoriNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getVatNumber()
    {
        return $this->vatNumber;
    }

    /**
     * @param string $vatNumber
     *
     * @return Address
     */
    public function setVatNumber($vatNumber)
    {
        $this->vatNumber = $vatNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     *
     * @return Address
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }
}
