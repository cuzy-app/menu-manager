<?php
/**
 * Menu Manager
 * @link https://www.cuzy.app
 * @license https://www.cuzy.app/cuzy-license
 * @author [Marc FARRE](https://marc.fun)
 */

namespace humhub\modules\menuManager\models;

use humhub\components\SettingsManager;
use Yii;
use yii\base\Model;
use yii\helpers\Inflector;

class Configuration extends Model
{
    public SettingsManager $settingsManager;

    /**
     * Attribute names must be the MenuLink ID camel cased
     */
    public ?array $home = null;
    public ?array $dashboard = null;
    public ?array $people = null;
    public ?array $spaces = null;
    public ?array $calendar = null;
    public ?array $membersMap = null;
    public ?array $eventsMap = null;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['home', 'dashboard', 'people', 'spaces', 'calendar', 'membersMap', 'eventsMap'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'home' => Yii::t('MenuManagerModule.config', 'Top menu entry "{entryLabel}"', ['entryLabel' => Yii::t('yii', 'Home')]),
            'dashboard' => Yii::t('MenuManagerModule.config', 'Top menu entry "{entryLabel}"', ['entryLabel' => Yii::t('DashboardModule.base', 'Dashboard')]),
            'spaces' => Yii::t('MenuManagerModule.config', 'Top menu entry "{entryLabel}"', ['entryLabel' => Yii::t('SpaceModule.base', 'Spaces')]),
            'people' => Yii::t('MenuManagerModule.config', 'Top menu entry "{entryLabel}"', ['entryLabel' => Yii::t('UserModule.base', 'People')]),
            'calendar' => Yii::t('MenuManagerModule.config', 'Top menu entry "{entryLabel}"', ['entryLabel' => Yii::$app->getModule('calendar') ? Yii::t('CalendarModule.base', 'Calendar') : 'Calendar']),
            'membersMap' => Yii::t('MenuManagerModule.config', 'Top menu entry "{entryLabel}"', ['entryLabel' => Yii::$app->getModule('members-map') ? Yii::t('MembersMapModule.base', 'Members map') : 'Members Map']),
            'eventsMap' => Yii::t('MenuManagerModule.config', 'Top menu entry "{entryLabel}"', ['entryLabel' => Yii::$app->getModule('events-map') ? Yii::t('EventsMapModule.config', 'Events Map') : 'Events Map']),
        ];
    }

    public function attributeHints()
    {
        return [
            'calendar' => Yii::t('MenuManagerModule.config', 'To be displayed, it must also be enabled in the configuration'),
            'membersMap' => Yii::t('MenuManagerModule.config', 'To be displayed, it must also be enabled in the configuration'),
            'eventsMap' => Yii::t('MenuManagerModule.config', 'To be displayed, it must also be enabled in the configuration'),
        ];
    }

    public function loadBySettings(): void
    {
        $this->home = (array)$this->settingsManager->getSerialized('home', $this->home);
        $this->dashboard = (array)$this->settingsManager->getSerialized('dashboard', $this->dashboard);
        $this->spaces = (array)$this->settingsManager->getSerialized('spaces', $this->spaces);
        $this->people = (array)$this->settingsManager->getSerialized('people', $this->people);
        $this->calendar = (array)$this->settingsManager->getSerialized('calendar', $this->calendar);
        $this->membersMap = (array)$this->settingsManager->getSerialized('membersMap', $this->membersMap);
        $this->eventsMap = (array)$this->settingsManager->getSerialized('eventsMap', $this->eventsMap);
    }

    public function getMenuEntryConfig($attribute): MenuEntryConfig
    {
        return new MenuEntryConfig(array_merge(
            ['id' => Inflector::camel2id($attribute, '-')],
            $this->$attribute ?? []
        ));
    }

    public function reset(): bool
    {
        $this->home = [];
        $this->dashboard = [];
        $this->spaces = [];
        $this->people = [];
        $this->calendar = [];
        $this->membersMap = [];
        $this->eventsMap = [];
        return $this->save();
    }

    public function save(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $this->settingsManager->setSerialized('home', $this->home);
        $this->settingsManager->setSerialized('dashboard', $this->dashboard);
        $this->settingsManager->setSerialized('spaces', $this->spaces);
        $this->settingsManager->setSerialized('people', $this->people);
        $this->settingsManager->setSerialized('calendar', $this->calendar);
        $this->settingsManager->setSerialized('membersMap', $this->membersMap);
        $this->settingsManager->setSerialized('eventsMap', $this->eventsMap);

        return true;
    }
}
