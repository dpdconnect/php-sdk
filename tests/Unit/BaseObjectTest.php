<?php

namespace DpdConnect\Sdk\Test\Unit;

use DpdConnect\Sdk\Objects\BaseObject;
use PHPUnit\Framework\TestCase;

class BaseObjectTest extends TestCase
{
    private function prepareInputData()
    {
        return [
            'foo' => 'bar',
            'content' => [
                'labelResponses' => [
                    'label' => [
                        'data'
                    ]
                ]
            ]
        ];
    }

    public function testIfDynamicPropertyIsSerializable()
    {
        $input = $this->prepareInputData();

        $baseObject = new BaseObject($input);

        $arrayToSerialize = $baseObject->jsonSerialize();

        $this->assertEquals($input, $arrayToSerialize);
    }

    public function testIfDynamicPropertyIsAccessibleAsFunction()
    {
        $input = $this->prepareInputData();
        $baseObject = new BaseObject($input);

        $content = $baseObject->getContent();

        $this->assertEquals($input['content'], $content);
    }

    public function testIfDynamicPropertyIsAccessibleAsProperty()
    {
        $input = $this->prepareInputData();
        $baseObject = new BaseObject($input);

        $content = $baseObject->content;

        $this->assertEquals($input['content'], $content);
    }

}