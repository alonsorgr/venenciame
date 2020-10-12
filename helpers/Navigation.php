<?php

/**
 * @link https://github.com/alonsorgr/venenciame/
 * @copyright Copyright (c) 2020 alonsorgr
 * @license https://github.com/alonsorgr/venenciame/blob/master/LICENSE.md
 */

namespace app\helpers;

use app\models\Partners;
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
class Navigation
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

            static::partners(),

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
     * @return array    configuración del menú usuario en la barra de navegación.
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
            'label' => static::label([
                'icon' => 'fas fa-user',
                'color' => 'text-primary',
                'label' => Yii::t('app', 'Ver perfil'),
            ]),
            'url' => ['user/view', 'id' => User::id()], 'post',
            'linkOptions' => [
                'title' => Yii::t('app', 'Ver el perfil personal del usuario'),
                'class' => 'text-capitalize',
            ],
        ];

        $update = [
            'encode' => false,
            'label' => static::label([
                'icon' => 'fas fa-pen',
                'color' => 'text-primary',
                'label' => Yii::t('app', 'Editar perfil'),
            ]),
            'url' => ['user/update', 'id' => User::id()], 'post',
            'linkOptions' => [
                'title' => Yii::t('app', 'Editar el perfil personal del usuario'),
                'class' => 'text-capitalize',
            ],
        ];

        $admin = [
            'encode' => false,
            'label' => static::label([
                'icon' => 'fas fa-users-cog',
                'color' => 'text-primary',
                'label' => Yii::t('app', 'Administración'),
            ]),
            'url' => ['admin/index'],
            'linkOptions' => [
                'title' => Yii::t('app', 'Administrar el sitio'),
                'class' => 'text-capitalize',
            ],
        ];

        $partner = [
            'encode' => false,
            'label' => static::label([
                'icon' => 'fas fa-handshake',
                'color' => 'text-primary',
                'label' => Yii::t('app', 'Panel de ventas'),
            ]),
            'url' => ['partners/view', 'id' => User::id()], 'post',
            'linkOptions' => [
                'title' => Yii::t('app', 'Administrar las ventas de socio'),
                'class' => 'text-capitalize',
            ],
        ];

        $logout = [
            'encode' => false,
            'label' => static::label([
                'icon' => 'fas fa-sign-out-alt',
                'color' => 'text-danger',
                'label' => Yii::t('app', 'Cerrar sesión'),
            ]),
            'url' => '#',
            'linkOptions' => [
                'title' => Yii::t('app', 'Desconectarse del sitio'),
                'class' => 'show-modal-logout text-capitalize',
                'value' => Url::to(['site/logout']),
                'data-toggle' => 'modal',
                'data-target' => '#modal-logout',
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
                User::isAdmin() ? static::horizontalDivider() : '',
                User::isAdmin() ? $admin : '',
                User::isPartner() ? static::horizontalDivider() : '',
                User::isPartner() ? $partner : '',
                static::horizontalDivider(),
                $logout,
            ]
        ] : '';
    }

    /**
     * Genera el menú de bodegas en la barra de navegación.
     *
     * @return array    configuración del menú de bodegas de socios en la barra de navegación.
     */
    public static function partners()
    {
        $icon = Html::tag('span', '', [
            'class' => 'fas fa-adjust partners-nav-icon',
        ]);

        $label = Html::tag('span', Yii::t('app', 'Bodegas'), [
            'id' => 'partners-label',
            'class' => 'ml-2 active',
            'title' => Yii::t('app', 'Bodegas de nuestros socios.'),
        ]);

        $item = Html::tag('div', $icon . $label, [
            'id' => 'partners-menu',
            'class' => 'nav-item active',
        ]);

        $items = null;
        foreach (Partners::find()->where(['status_id' => 3])->all() as $value) {
            $items[] = [
                'encode' => false,
                'label' => $value['name'],
                'url' => [
                    'partners/view',
                    'id' => $value['id'],
                ]
            ];
        }

        return [
            'encode' => false,
            'label' => $item,
            'url' => '',
            'linkOptions' => [
                'class' => 'dropdown-menu-toggle',
            ],
            'items' => $items,
        ];
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

    /**
     * Genera una etiqueta formateada para los menús.
     *
     * @param   array   $options    array de opciones.
     * @return  string              etiqueta formateada.
     */
    public static function label($options)
    {
        return <<<EOT
        <div class="row my-2 mr-4">
            <div class="col col-1">
                <i class="{$options['icon']} {$options['color']}"></i>
            </div>
            <div class="col col-5">
                {$options['label']}
            </div>
        </div>
        EOT;
    }
}
