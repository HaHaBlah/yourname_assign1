<?php

declare(strict_types=1);


namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;


final class FirstCest
{
    public function _before(AcceptanceTester $I): void
    {
        $I->amOnPage('/');
        $I->see('Home');
    }

    public function tryToTest(AcceptanceTester $I): void
    {
        $I->amOnPage('/');
        $I->see('Home');
    }
}
