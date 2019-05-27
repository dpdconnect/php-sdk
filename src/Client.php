<?php

namespace DpdConnect\Sdk;

use DpdConnect\Sdk\Common\Authentication;
use DpdConnect\Sdk\Common\HttpClient;
use DpdConnect\Sdk\Common\ResourceClient;
use DpdConnect\Sdk\Resources\Parcelshop;
use DpdConnect\Sdk\Resources\Shipment;
use DpdConnect\Sdk\Resources\Country;

class Client
{
    const ENDPOINT = 'https://api.dpdconnect.nl';

    const CLIENT_VERSION = '1.0.0';

    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @var Resources\Shipment
     */
    public $shipment;

    /**
     * @var Parcelshop
     */
    public $parcelshop;

    /**
     * @var Country
     */
    public $country;

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var Authentication
     */
    private $authentication;

    /**
     * @var ResourceClient
     */
    private $resourceClient;

    /**
     * @param Authentication $authentication
     * @param HttpClient $httpClient
     */
    public function __construct(
        Authentication $authentication,
        HttpClient $httpClient = null,
        ResourceClient $resourceClient = null,
        $url = self::ENDPOINT
    ) {
        $this->authentication = $authentication;
        $this->httpClient = $httpClient;
        $this->resourceClient = $resourceClient;
        $this->endpoint = $url;

        $this->shipment = new Shipment($this->resourceClient);
        $this->parcelshop = new Parcelshop($this->resourceClient);
        $this->country = new Country($this->resourceClient);
    }

    /**
     * @return Shipment
     */
    public function getShipment()
    {
        return $this->shipment;
    }

    /**
     * @return Parcelshop
     */
    public function getParcelshop()
    {
        return $this->parcelshop;
    }

    /**
     * @return Country
     */
    public function getCountries()
    {
        return $this->country;
    }
}
