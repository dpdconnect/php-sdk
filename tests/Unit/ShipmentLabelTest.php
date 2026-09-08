<?php

namespace DpdConnect\Sdk\Test;

use PHPUnit\Framework\Attributes\Depends;
use DpdConnect\Sdk\Objects\ObjectFactory;
use DpdConnect\Sdk\Objects\ShipmentLabel;
use PHPUnit\Framework\TestCase;

class ShipmentLabelTest extends TestCase
{
    /**
     * @return ShipmentLabel
     */
    private function getObject()
    {
        $label = ObjectFactory::create(ShipmentLabel::class, [
            'sequenceNumber'    => 'order200',
            'trackingNumber'    => '138217321837213',
            'label'             => base64_encode("order200"),
        ]);

        return $label;
    }

    /**
     * @return ShipmentLabel
     */
    public function testGenerateShippingLabel()
    {
        $label = $this->getObject();

        $this->assertNotNull($label);
        return $label;
    }

    /**
     * @param ShipmentLabel $label
     */
    #[Depends('testGenerateShippingLabel')]
    public function testGetters($label)
    {
        $this->assertEquals($label->getSequenceNumber(), 'order200');
        $this->assertEquals($label->getTrackingNumber(), '138217321837213');
        $this->assertEquals(base64_decode($label->getLabel()), 'order200');
    }
}
