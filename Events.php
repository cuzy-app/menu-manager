<?php
/**
 * Menu Manager
 * @link https://www.cuzy.app
 * @license https://www.cuzy.app/cuzy-license
 * @author [Marc FARRE](https://marc.fun)
 */

namespace humhub\modules\menuManager;

use Exception;
use humhub\modules\ui\menu\MenuLink;
use humhub\widgets\TopMenu;
use Yii;
use yii\base\Event;
use yii\helpers\Url;

class Events
{
    /**
     * TopMenu init event callback
     *
     * @param Event $event
     * @see TopMenu
     */
    public static function onTopMenuInit($event)
    {
        /** @var TopMenu $menu */
        $menu = $event->sender;

        /** @var Module $module */
        $module = Yii::$app->getModule('menu-manager');
        $configuration = $module->getConfiguration();

        $homeMenuEntryConfig = $configuration->getMenuEntryConfig('topMenuHome');
        if ($homeMenuEntryConfig->display()) {
            $menu->addEntry(new MenuLink([
                'id' => $homeMenuEntryConfig->id,
                'label' => Yii::t('MenuManagerModule.custom', $homeMenuEntryConfig->label) ?: Yii::t('yii', 'Home'),
                'url' => Url::home(),
                'icon' => $homeMenuEntryConfig->icon ?: 'home',
                'sortOrder' => $homeMenuEntryConfig->sortOrder ?: 50,
                'isActive' => Url::home() === Url::current() || MenuLink::isActiveState('homepage', 'index', 'index'),
                'isVisible' => true,
            ]));
        }
    }

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

        foreach ($configuration->availableTopMenuAttributes as $attribute) {
            if ($attribute === 'topMenuHome') {
                continue; // See onTopMenuInit()
            }

            $menuEntryConfig = $configuration->getMenuEntryConfig($attribute);
            /** @var MenuLink $entry */
            $entry = ($attribute === 'topMenuCalendar') ? // TODO: add an ID to the calendar module top menu entry
                $menu->getEntryByUrl(\humhub\modules\calendar\helpers\Url::toGlobalCalendar()) :
                $menu->getEntryById($menuEntryConfig->id);
            if (!$entry) {
                continue;
            }

            if (!$menuEntryConfig->display()) {
                $menu->removeEntry($entry);
            } else {
                if ($menuEntryConfig->icon) {
                    try {
                        $entry->setIcon($menuEntryConfig->icon);
                    } catch (Exception $e) {
                    }
                }
                if ($menuEntryConfig->label) {
                    $entry->setLabel(Yii::t('MenuManagerModule.custom', $menuEntryConfig->label));
                }
                $sortOrder = (int)$menuEntryConfig->sortOrder;
                if ($sortOrder && $sortOrder >= 1 && $sortOrder <= 10000) {
                    $entry->setSortOrder($menuEntryConfig->sortOrder);
                }
            }
        }
    }
}
