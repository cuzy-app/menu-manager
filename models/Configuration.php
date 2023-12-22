<?php
/**
 * Menu Manager
 * @link https://www.cuzy.app
 * @license https://www.cuzy.app/cuzy-license
 * @author [Marc FARRE](https://marc.fun)
 */

namespace humhub\modules\menuManager\models;

use humhub\components\SettingsManager;
use humhub\modules\content\helpers\ContentContainerHelper;
use humhub\modules\space\models\Space;
use humhub\modules\user\models\User;
use Yii;
use yii\base\Model;

class Configuration extends Model
{
    public SettingsManager $settingsManager;

    public const DISPLAY_STATE_ALL = 'all';
    public const DISPLAY_STATE_NON_GUEST = 'non_guest';
    public const DISPLAY_STATE_ADMIN = 'admin';
    public const DISPLAY_STATE_NONE = 'none';

    public const ATTRIBUTE_USING_CONTAINER_ADMIN = [
        'streamFilterDisplayState',
    ];

    /**
     * @var bool // Don't force type other than string as `$this->settingsManager->set()` will write a string value
     */
    public $homeDisplayState = self::DISPLAY_STATE_ALL;
    public $dashboardDisplayState = self::DISPLAY_STATE_ALL;
    public $peopleDisplayState = self::DISPLAY_STATE_ALL;
    public $spacesDisplayState = self::DISPLAY_STATE_ALL;
    public $calendarDisplayState = self::DISPLAY_STATE_ALL;
    public $membersMapDisplayState = self::DISPLAY_STATE_ALL;
    public $eventsMapDisplayState = self::DISPLAY_STATE_ALL;
    public $streamFilterDisplayState = self::DISPLAY_STATE_ALL;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['homeDisplayState', 'dashboardDisplayState', 'peopleDisplayState', 'spacesDisplayState', 'calendarDisplayState', 'membersMapDisplayState', 'eventsMapDisplayState', 'streamFilterDisplayState'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'homeDisplayState' => Yii::t('MenuManagerModule.config', 'Top menu entry "{entryLabel}"', ['entryLabel' => Yii::t('yii', 'Home')]),
            'dashboardDisplayState' => Yii::t('MenuManagerModule.config', 'Top menu entry "{entryLabel}"', ['entryLabel' => Yii::t('DashboardModule.base', 'Dashboard')]),
            'spacesDisplayState' => Yii::t('MenuManagerModule.config', 'Top menu entry "{entryLabel}"', ['entryLabel' => Yii::t('SpaceModule.base', 'Spaces')]),
            'peopleDisplayState' => Yii::t('MenuManagerModule.config', 'Top menu entry "{entryLabel}"', ['entryLabel' => Yii::t('UserModule.base', 'People')]),
            'calendarDisplayState' => Yii::t('MenuManagerModule.config', 'Top menu entry "{entryLabel}"', ['entryLabel' => Yii::$app->getModule('calendar') ? Yii::t('CalendarModule.base', 'Calendar') : 'Calendar']),
            'membersMapDisplayState' => Yii::t('MenuManagerModule.config', 'Top menu entry "{entryLabel}"', ['entryLabel' => Yii::$app->getModule('members-map') ? Yii::t('MembersMapModule.base', 'Members map') : 'Members Map']),
            'eventsMapDisplayState' => Yii::t('MenuManagerModule.config', 'Top menu entry "{entryLabel}"', ['entryLabel' => Yii::$app->getModule('events-map') ? Yii::t('EventsMapModule.config', 'Events Map') : 'Events Map']),
            'streamFilterDisplayState' => Yii::t('MenuManagerModule.config', 'Stream filter in spaces and user profiles'),
        ];
    }

    public function attributeHints()
    {
        return [
            'calendarDisplayState' => Yii::t('MenuManagerModule.config', 'To be displayed, it must also be enabled in the configuration'),
            'membersMapDisplayState' => Yii::t('MenuManagerModule.config', 'To be displayed, it must also be enabled in the configuration'),
            'eventsMapDisplayState' => Yii::t('MenuManagerModule.config', 'To be displayed, it must also be enabled in the configuration'),
        ];
    }

    public function loadBySettings(): void
    {
        $this->homeDisplayState = $this->settingsManager->get('homeDisplayState', $this->homeDisplayState);
        $this->dashboardDisplayState = $this->settingsManager->get('dashboardDisplayState', $this->dashboardDisplayState);
        $this->spacesDisplayState = $this->settingsManager->get('spacesDisplayState', $this->spacesDisplayState);
        $this->peopleDisplayState = $this->settingsManager->get('peopleDisplayState', $this->peopleDisplayState);
        $this->calendarDisplayState = $this->settingsManager->get('calendarDisplayState', $this->calendarDisplayState);
        $this->streamFilterDisplayState = $this->settingsManager->get('streamFilterDisplayState', $this->streamFilterDisplayState);
        $this->membersMapDisplayState = $this->settingsManager->get('membersMapDisplayState', $this->membersMapDisplayState);
        $this->eventsMapDisplayState = $this->settingsManager->get('eventsMapDisplayState', $this->eventsMapDisplayState);
    }

    public function save(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        $this->settingsManager->set('homeDisplayState', $this->homeDisplayState);
        $this->settingsManager->set('dashboardDisplayState', $this->dashboardDisplayState);
        $this->settingsManager->set('spacesDisplayState', $this->spacesDisplayState);
        $this->settingsManager->set('peopleDisplayState', $this->peopleDisplayState);
        $this->settingsManager->set('calendarDisplayState', $this->calendarDisplayState);
        $this->settingsManager->set('streamFilterDisplayState', $this->streamFilterDisplayState);
        $this->settingsManager->set('membersMapDisplayState', $this->membersMapDisplayState);
        $this->settingsManager->set('eventsMapDisplayState', $this->eventsMapDisplayState);

        return true;
    }

    public function display($attr): bool
    {
        if ($this->$attr === self::DISPLAY_STATE_ALL) {
            return true;
        }
        if ($this->$attr === self::DISPLAY_STATE_NONE) {
            return false;
        }
        if ($this->$attr === self::DISPLAY_STATE_NON_GUEST) {
            return !Yii::$app->user->isGuest;
        }
        if ($this->$attr === self::DISPLAY_STATE_ADMIN) {
            $isAdmin = false;
            if (in_array($attr, self::ATTRIBUTE_USING_CONTAINER_ADMIN, true)) {
                /** @var Space|User $container */
                $container = ContentContainerHelper::getCurrent();
                if ($container) {
                    $isAdmin = $container->isAdmin();
                }
            } else {
                $isAdmin = Yii::$app->user->isAdmin();
            }
            return $isAdmin;
        }
        return false;
    }

    public static function getDisplayStateLabels(): array
    {
        return [
            self::DISPLAY_STATE_ALL => Yii::t('MenuManagerModule.config', 'All'),
            self::DISPLAY_STATE_NON_GUEST => Yii::t('MenuManagerModule.config', 'Logged in users'),
            self::DISPLAY_STATE_ADMIN => Yii::t('MenuManagerModule.config', 'Administrators only'),
            self::DISPLAY_STATE_NONE => Yii::t('MenuManagerModule.config', 'None (hidden for all)'),
        ];
    }
}
