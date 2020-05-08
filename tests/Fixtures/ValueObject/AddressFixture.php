<?php declare(strict_types=1);
/**
 * Copyright © 2020 MultiSafepay, Inc. All rights reserved.
 * See DISCLAIMER.md for disclaimer details.
 */

namespace MultiSafepay\Tests\Fixtures\ValueObject;

use MultiSafepay\ValueObject\Customer\Address;
use MultiSafepay\ValueObject\Customer\Country;
use Faker\Factory as FakerFactory;

/**
 * Trait AddressFixture
 * @package MultiSafepay\Tests\Fixtures\ValueObject
 */
trait AddressFixture
{
    /**
     * @return Address
     */
    public function createAddressFixture(): Address
    {
        $country = new Country('NL');
        return (new Address())
            ->addStreetName('Kraanspoor')
            ->addStreetNameAdditional('(blue door)')
            ->addHouseNumber('18')
            ->addHouseNumberSuffix('A')
            ->addZipCode('1000AA')
            ->addCity('Amsterdam')
            ->addState('Noord Holland')
            ->addCountry($country);
    }

    /**
     * @return Address
     */
    public function createRandomAddressFixture(): Address
    {
        $faker = FakerFactory::create();
        $country = new Country($faker->countryCode);
        return (new Address())
            ->addStreetName($faker->streetName)
            ->addStreetNameAdditional($faker->streetSuffix)
            ->addHouseNumber($faker->buildingNumber)
            ->addHouseNumberSuffix($faker->word)
            ->addZipCode($faker->postcode)
            ->addCity($faker->city)
            ->addState($faker->state)
            ->addCountry($country);
    }
}
