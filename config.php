<?php
/**
 * Menu Manager
 * @link https://github.com/cuzy-app/menu-manager
 * @license https://github.com/cuzy-app/menu-manager/blob/master/docs/LICENCE.md
 * @author [Marc FARRE](https://marc.fun) for [CUZY.APP](https://www.cuzy.app)
 */

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
            'callback' => [Events::class, 'onTopMenuInit'],
        ],
        [
            'class' => TopMenu::class,
            'event' => TopMenu::EVENT_BEFORE_RUN, // To remove entries (otherwise, entries from other modules might not be removed)
            'callback' => [Events::class, 'onTopMenuBeforeRun'],
        ],
    ],
];
