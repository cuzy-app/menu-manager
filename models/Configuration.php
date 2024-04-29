<?php
/**
 * Menu Manager
 * @link https://github.com/cuzy-app/menu-manager
 * @license https://github.com/cuzy-app/menu-manager/blob/master/docs/LICENCE.md
 * @author [Marc FARRE](https://marc.fun) for [CUZY.APP](https://www.cuzy.app)
 */

namespace humhub\modules\menuManager\models;

use humhub\components\Module;
use humhub\components\SettingsManager;
use humhub\widgets\TopMenu;
use Yii;
use yii\base\Model;

/**
 *
 * @property-read array $availableTopMenuAttributes
 */
class Configuration extends Model
{
    /**
     * Attribute names to menu link IDs
     */
    public const ATTRIBUTE_MENU_LINK_ID = [
        'topMenuHome' => 'home',
        'topMenuDashboard' => 'dashboard',
        'topMenuPeople' => 'people',
        'topMenuSpaces' => 'spaces',
        'topMenuClassifiedSpaceBrowser' => 'classified-space-browser',
        'topMenuCalendar' => 'calendar', // TODO: add an ID to the calendar module top menu entry
        'topMenuMembersMap' => 'members-map',
        'topMenuEventsMap' => 'events-map',
        'topMenuEcommerce' => 'ecommerce',
        'topMenuSurvey' => 'surveys-global',
    ];
    /**
     * Attributes for menu entries from external modules
     */
    public const ATTRIBUTE_MODULE_IDS = [
        'topMenuClassifiedSpaceBrowser' => 'classified-space',
        'topMenuCalendar' => 'calendar',
        'topMenuMembersMap' => 'members-map',
        'topMenuEventsMap' => 'events-map',
        'topMenuEcommerce' => 'ecommerce',
        'topMenuSurvey' => 'survey',
    ];

    public SettingsManager $settingsManager;

    public array $topMenuHome = [];
    public array $topMenuDashboard = [];
    public array $topMenuPeople = [];
    public array $topMenuSpaces = [];
    public array $topMenuClassifiedSpaceBrowser = [];
    public array $topMenuCalendar = [];
    public array $topMenuMembersMap = [];
    public array $topMenuEventsMap = [];
    public array $topMenuEcommerce = [];
    public array $topMenuSurvey = [];

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [$this->availableTopMenuAttributes, 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $attributeLabels = [];
        $topMenu = new TopMenu();
        foreach ($this->availableTopMenuAttributes as $attribute) {
            $menuEntryConfig = $this->getMenuEntryConfig($attribute);
            $entry = ($attribute === 'topMenuCalendar') ? // TODO: add an ID to the calendar module top menu entry
                $topMenu->getEntryByUrl(\humhub\modules\calendar\helpers\Url::toGlobalCalendar()) :
                $topMenu->getEntryById($menuEntryConfig->id);

            if ($entry) {
                $attributeLabel = $entry->getLabel();
            } elseif ($attribute === 'topMenuHome') {
                // In case the home entry is disabled in the config
                $attributeLabel = Yii::t('yii', 'Home');
            } else {
                continue;
            }

            $moduleId = static::ATTRIBUTE_MODULE_IDS[$attribute] ?? null;
            if ($moduleId) {
                /** @var Module $module */
                $module = Yii::$app->getModule($moduleId);
                $attributeLabel .= ' (' . Yii::t('MenuManagerModule.config', '{ClassifiedSpace} module', ['ClassifiedSpace' => $module->getName()]) . ')';
            }
            $attributeLabels[$attribute] = $attributeLabel;
        }
        return $attributeLabels;
    }

    public function getMenuEntryConfig($attribute): MenuEntryConfig
    {
        return new MenuEntryConfig(array_merge(
            ['id' => static::ATTRIBUTE_MENU_LINK_ID[$attribute]],
            $this->$attribute ?? []
        ));
    }

    public function attributeHints()
    {
        return [
            'topMenuClassifiedSpaceBrowser' => Yii::t('MenuManagerModule.config', 'To be displayed, it must also be enabled in the configuration'),
            'topMenuCalendar' => Yii::t('MenuManagerModule.config', 'To be displayed, it must also be enabled in the configuration'),
            'topMenuMembersMap' => Yii::t('MenuManagerModule.config', 'To be displayed, it must also be enabled in the configuration'),
            'topMenuEventsMap' => Yii::t('MenuManagerModule.config', 'To be displayed, it must also be enabled in the configuration'),
        ];
    }

    public function loadBySettings(): void
    {
        foreach ($this->availableTopMenuAttributes as $attribute) {
            $this->$attribute = (array)$this->settingsManager->getSerialized($attribute, $this->$attribute);
            // Avoid icon with null value for the IconPicker widget
            if (empty($this->$attribute['icon'])) {
                $this->$attribute['icon'] = '';
            }
        }
    }

    public function reset(): bool
    {
        foreach ($this->availableTopMenuAttributes as $attribute) {
            $this->$attribute = [];
        }
        return $this->save();
    }

    public function save(): bool
    {
        if (!$this->validate()) {
            return false;
        }

        foreach ($this->availableTopMenuAttributes as $attribute) {
            $this->settingsManager->setSerialized($attribute, $this->$attribute);
        }

        return true;
    }

    public function getAvailableTopMenuAttributes(): array
    {
        $availableTopMenuAttributes = [];
        foreach (self::ATTRIBUTE_MENU_LINK_ID as $attribute => $menuLinkId) {
            $moduleId = static::ATTRIBUTE_MODULE_IDS[$attribute] ?? null;
            if (!$moduleId || Yii::$app->getModule($moduleId)) {
                $availableTopMenuAttributes[] = $attribute;
            }
        }
        return $availableTopMenuAttributes;
    }
}
