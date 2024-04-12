<?php
/**
 * Menu Manager
 * @link https://www.cuzy.app
 * @license https://www.cuzy.app/cuzy-license
 * @author [Marc FARRE](https://marc.fun)
 */

/** @noinspection MissedFieldInspection */

use humhub\modules\menuManager\Events;
use humhub\widgets\TopMenu;

return [
    'id' => 'menu-manager',
    'class' => humhub\modules\menuManager\Module::class,
    'namespace' => 'humhub\modules\menuManager',
    'events' => [
        [
            'class' => TopMenu::class,
            'event' => TopMenu::EVENT_INIT, // To add entries (otherwise, entries are not marked as active)
            'callback' => [Events::class, 'onTopMenuInit']
        ],
        [
            'class' => TopMenu::class,
            'event' => TopMenu::EVENT_BEFORE_RUN, // To remove entries (otherwise, entries from other modules might not be removed)
            'callback' => [Events::class, 'onTopMenuBeforeRun']
        ],
    ]
];
