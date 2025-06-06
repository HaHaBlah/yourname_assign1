<?php

declare(strict_types=1);

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

final class HomePageCest
{
    public function _before(AcceptanceTester $I): void
    {
        // Typically, keep this empty or use it for setup that doesn't need $I actions like amOnPage
    }

    public function tryToTest(AcceptanceTester $I): void
    {
        $I->amOnPage('/');
        $I->see('Welcome');
    }
}