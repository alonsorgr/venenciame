<?php

/**
 * Ejemplo de prueba funcional combinada con fixtures
 */

use app\models\User;
use tests\unit\fixtures\UserFixture;

class UserCest
{
    public function _fixtures()
    {
        return [
            [
                'class' => UserFixture::class,
            ],
        ];
    }

    public function hayUsuarios(FunctionalTester $I)
    {
        $I->assertEquals(0, User::find()->count());
    }
}
