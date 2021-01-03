<?php

use app\models\User;

class LoginFormCest
{
    public function _before(\FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
    }

    public function openLoginPage(\FunctionalTester $I)
    {
        $I->see('Nombre de usuario o correo electrónico', 'label');

    }

    // demonstrates `amLoggedInAs` method
    public function internalLoginById(\FunctionalTester $I)
    {
        /* $I->amLoggedInAs(User::findOne(1));
        $I->amOnPage('/'); */
    }

    // demonstrates `amLoggedInAs` method
    public function internalLoginByInstance(\FunctionalTester $I)
    {
        /* $I->amLoggedInAs(User::findByUsername('admin'));
        $I->amOnPage('/');
        $I->see('admin'); */
    }

    public function loginWithEmptyCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', []);
        $I->expectTo('see validations errors');
        $I->see('El campo de nombre de usuario o correo electrónico no puede estar vacío.');
        $I->see('El campo de contraseña no puede estar vacío.');
    }

    public function loginWithWrongCredentials(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', [
            'LoginForm[login]' => 'admin',
            'LoginForm[password]' => 'wrong',
        ]);
        $I->expectTo('see validations errors');
        $I->see('En nombre de usuario, correo electrónico o la contraseña son incorrectos.');
    }

    public function loginSuccessfully(\FunctionalTester $I)
    {
        $I->submitForm('#login-form', [
            'LoginForm[login]' => 'admin',
            'LoginForm[password]' => 'admin',
        ]);           
    }
}
