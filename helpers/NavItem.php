<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\helpers;

use app\models\User;
use Yii;
use yii\bootstrap4\Html;
use yii\helpers\Url;

/**
 * Clase auxiliar para la administración y generación de elementos para la
 * barra de navegación (Nav y NavBar).
 *
 * @author Alonso García <alonsorgr@gmail.com>
 * @since 1.0
 */
class NavItem
{
    /**
     * Genera el menú principal en la barra de navegación.
     *
     * @return array configuración de elementos de la barra de navegación.
     */
    public static function items()
    {
        return [
            static::item([
                'icon' => 'fa-home',
                'label' => Yii::t('app', 'Inicio'),
                'url' => ['/site/index'],
                'title' => Yii::t('app', 'Ir a la página principal'),
            ]),

            static::user(),

            Yii::$app->user->isGuest ? static::item([
                'class' => 'show-modal-login active',
                'icon' => 'fa-sign-in-alt',
                'label' => Yii::t('app', 'Conectarse'),
                'url' => '#',
                'title' => Yii::t('app', 'Conectarse'),
                'data-toggle' => 'modal',
                'data-target' => '#modal-login',
                'value' => Url::to(['site/login']),
            ]) : '',

            Yii::$app->user->isGuest ? static::item([
                'class' => 'show-modal-register active',
                'icon' => 'fa-sign-in-alt',
                'label' => Yii::t('app', 'Registrarse'),
                'url' => '#',
                'title' => Yii::t('app', 'Registrarse'),
                'data-toggle' => 'modal',
                'data-target' => '#modal-register',
                'value' => Url::to(['site/register']),
            ]) : '',
        ];
    }

    /**
     * Genera elemento en la barra de navegación del menú principal.
     *
     * @param   array   $options    array de configuración.
     * @return  array               configuración de elemento de la barra de navegación.
     */
    private static function item($options)
    {
        return [
            'encode' => false,
            'label' => '<i class="fas ' . $options['icon'] . ' mr-1"></i>' . $options['label'],
            'url' => $options['url'],
            'options' => [
                'class' => !isset($options['class']) ?: $options['class'],
                'title' => $options['title'],
                'data-toggle' => !isset($options['data-toggle']) ?: $options['data-toggle'],
                'data-target' => !isset($options['data-target']) ?: $options['data-target'],
                'data-url' => !isset($options['url']) ?: $options['url'],
                'value' => !isset($options['value']) ?: $options['value'],
            ]
        ];
    }

    /**
     * Genera el menú de usuario en la barra de navegación.
     *
     * @return array    configuración del menú usuario  en la barra de navegación.
     */
    public static function user()
    {
        $username = !Yii::$app->user->isGuest ? Yii::$app->user->identity->username : '';

        $icon = Html::tag('span', '', [
            'class' => 'fas fa-user',
        ]);

        $label = Html::tag('span', $username, [
            'id' => 'user-label',
            'class' => 'ml-2 active',
            'title' => Yii::t('app', 'Menú de usuario.'),
        ]);

        $item = Html::tag('div', $icon . $label, [
            'id' => 'user-menu',
            'class' => 'nav-item active',
        ]);

        $view = [
            'encode' => false,
            'label' => '<i class="fas fa-user text-secondary mr-2 nav-item-icon-mt"></i>' . Yii::t('app', 'Ver perfil'),
            'url' => ['user/view', 'id' => User::id()], 'post',
            'linkOptions' => [
                'title' => Yii::t('app', 'Ver el perfil personal del usuario'),
            ],
        ];

        $update = [
            'encode' => false,
            'label' => '<i class="fas fa-pen text-secondary mr-2 nav-item-icon-mt"></i>' . Yii::t('app', 'Editar perfil'),
            'url' => ['user/update', 'id' => User::id()], 'post',
            'linkOptions' => [
                'title' => Yii::t('app', 'Editar el perfil personal del usuario'),
            ],
        ];

        $logout = [
            'encode' => false,
            'label' => '<i class="fas fa-sign-out-alt text-danger mr-2 nav-item-icon-mt"></i>' . Yii::t('app', 'Cerrar sesión'),
            'url' => ['site/logout'], 'post',
            'linkOptions' => [
                'title' => Yii::t('app', 'Desconectarse del sitio'),
            ],
        ];

        return !Yii::$app->user->isGuest ? [
            'encode' => false,
            'label' => $item,
            'url' => '',
            'linkOptions' => [
                'class' => 'dropdown-menu-toggle',
            ],
            'items' => [
                $view,
                $update,
                static::horizontalDivider(),
                $logout,
            ]
        ] : '';
    }

    /**
     * Genera un divisor horizontal para los elementos de un menú desplegable.
     *
     * @return string   divisor horizontal.
     */
    public static function horizontalDivider()
    {
        return Html::tag('div', '', [
            'class' => 'dropdown-divider'
        ]);
    }
}
