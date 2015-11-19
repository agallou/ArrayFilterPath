<?php

namespace agallou\ArrayFilterPath\Tests\Units;

use atoum;
use agallou\ArrayFilterPath\ArrayFilterPath as TestedClass;

class ArrayFilterPath extends atoum
{
    /**
     * @dataProvider filterDataProvider
     */
    public function testFilter($name, $array, $filters, $expected)
    {
        $testedClass = new TestedClass();
        $this
          ->array($testedClass->filter($array, $filters))
            ->isEqualTo($expected)
        ;
    }

    public function filterDataProvider()
    {
        $baseArray = array(
          'director' => array(
             'first_name' => 'Robert',
             'last_name' => 'Zemeckis',
          ),
          'actors' => array(
            array(
              'first_name' => 'Michael J.',
              'last_name' => 'Fox',
            ),
            array(
              'first_name' => 'Christopher',
              'last_name' => 'Lloyd',
            ),
          ),
          'label' => 'Back to the Future'
        );

        return array(

          array(
            'name' => 'One attribute with wildcard',
            'array' => $baseArray,
            'filters' => array(
              'director.*'
            ),
            'expected' => array(
              'director' => array(
                'first_name' => 'Robert',
                'last_name' => 'Zemeckis',
              ),
            ),
          ),

          array(
            'name' => 'One attribute on a numeric array',
            'array' => $baseArray,
            'filters' => array(
              'actors[].last_name'
            ),
            'expected' => array(
              'actors' => array(
                array(
                  'last_name' => 'Fox',
                ),
                array(
                  'last_name' => 'Lloyd',
                ),
              ),
            ),
          ),

          array(
            'name' => 'Multiple filters',
            'array' => $baseArray,
            'filters' => array(
              'actors[].last_name',
              'label',
            ),
            'expected' => array(
              'actors' => array(
                array(
                  'last_name' => 'Fox',
                ),
                array(
                  'last_name' => 'Lloyd',
                ),
              ),
              'label' => 'Back to the Future'
            ),
          ),


        );
    }
}
