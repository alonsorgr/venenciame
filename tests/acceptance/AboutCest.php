<?php

use yii\helpers\Url;

class AboutCest
{
    public function ensureThatAboutWorks(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/site/about'));
        $I->see('Acerca de Venénciame', 'div');
    }
}
