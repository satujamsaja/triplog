<?php

namespace TriplogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Fixtures;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        Fixtures::load(
            __DIR__.'/triplogfixtures.yml',
            $manager,
            [
                'providers' => [$this]
            ]
        );
    }

    public function tripName()
    {
        $tripName = [
            'Bali',
            'Jakarta',
            'Malang',
            'Surabaya',
            'Singapore',
        ];

        $key = array_rand($tripName);

        return 'Trip to ' . $tripName[$key];
    }


    public function tripLatLon()
    {
        $tripCoord = [
            '-8.670458, 115.212629',
            '-8.791551, 115.230317',
            '-8.506854, 115.262478',
            '-6.147536, 106.708278',
        ];

        $key = array_rand($tripCoord);

        return $tripCoord[$key];
    }

    public function gender()
    {
        $gender = [
            'male',
            'female'
        ];

        $key = array_rand($gender);

        return $gender[$key];

    }
}