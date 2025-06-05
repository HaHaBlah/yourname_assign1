<?php

declare(strict_types=1);


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

final class HomePageCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->amOnPage('/');
        $I->see('Welcome');
    }

    public function tryToTest(AcceptanceTester $I): void
    {
        // Write your tests here. All `public` methods will be executed as tests.
    }
}
