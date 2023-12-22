<?php
/**
 * Menu Manager
 * @link https://www.cuzy.app
 * @license https://www.cuzy.app/cuzy-license
 * @author [Marc FARRE](https://marc.fun)
 */

/** @noinspection MissedFieldInspection */

use humhub\modules\menuManager\Events;
use humhub\modules\stream\widgets\WallStreamFilterNavigation;
use humhub\widgets\TopMenu;

return [
    'id' => 'menu-manager',
    'class' => humhub\modules\menuManager\Module::class,
    'namespace' => 'humhub\modules\menuManager',
    'events' => [
        [
            'class' => TopMenu::class,
            'event' => TopMenu::EVENT_BEFORE_RUN,
            'callback' => [Events::class, 'onTopMenuBeforeRun']
        ],
        [
            'class' => WallStreamFilterNavigation::class,
            'event' => WallStreamFilterNavigation::EVENT_BEFORE_RUN,
            'callback' => [Events::class, 'onWallStreamFilterNavigationBeforeRun']
        ],
    ]
];
