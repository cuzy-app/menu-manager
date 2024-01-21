<?php
/**
 * Menu Manager
 * @link https://www.cuzy.app
 * @license https://www.cuzy.app/cuzy-license
 * @author [Marc FARRE](https://marc.fun)
 */

namespace humhub\modules\menuManager;

use humhub\modules\ui\menu\MenuLink;
use humhub\widgets\TopMenu;
use Yii;
use yii\base\Event;
use yii\base\WidgetEvent;
use yii\helpers\Url;

class Events
{
    /**
     * TopMenu init event callback
     *
     * @param Event $event
     * @see TopMenu
     */
    public static function onTopMenuBeforeRun($event)
    {
        /** @var TopMenu $menu */
        $menu = $event->sender;

        /** @var Module $module */
        $module = Yii::$app->getModule('menu-manager');
        $configuration = $module->getConfiguration();

        if ($configuration->display('homeDisplayState')) {
            $menu->addEntry(new MenuLink([
                'id' => 'home',
                'label' => Yii::t('yii', 'Home'),
                'url' => Url::home(),
                'icon' => 'home',
                'sortOrder' => 50,
                'isActive' => Url::home() === Url::current() || MenuLink::isActiveState('homepage', 'index', 'index'),
                'isVisible' => true,
            ]));
        }

        if (!$configuration->display('dashboardDisplayState')) {
            $entry = $menu->getEntryById('dashboard');
            if ($entry) {
                $menu->removeEntry($entry);
            }
        }

        if (!$configuration->display('peopleDisplayState')) {
            $entry = $menu->getEntryById('people');
            if ($entry) {
                $menu->removeEntry($entry);
            }
        }

        if (!$configuration->display('spacesDisplayState')) {
            $entry = $menu->getEntryById('spaces');
            if ($entry) {
                $menu->removeEntry($entry);
            }
        }

        if (!$configuration->display('calendarDisplayState')) {
            $entry = $menu->getEntryByUrl(\humhub\modules\calendar\helpers\Url::toGlobalCalendar());
            if ($entry) {
                $menu->removeEntry($entry);
            }
        }

        if (!$configuration->display('membersMapDisplayState')) {
            $entry = $menu->getEntryById('members-map');
            if ($entry) {
                $menu->removeEntry($entry);
            }
        }

        if (!$configuration->display('eventsMapDisplayState')) {
            $entry = $menu->getEntryById('events-map');
            if ($entry) {
                $menu->removeEntry($entry);
            }
        }
    }

    public static function onWallStreamFilterNavigationBeforeRun(WidgetEvent $event)
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('menu-manager');
        $configuration = $module->getConfiguration();

        if (!$configuration->display('streamFilterDisplayState')) {
            $event->isValid = false;
        }
    }
}
