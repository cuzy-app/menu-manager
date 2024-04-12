<?php
/**
 * Menu Manager
 * @link https://www.cuzy.app
 * @license https://www.cuzy.app/cuzy-license
 * @author [Marc FARRE](https://marc.fun)
 */

namespace humhub\modules\menuManager\models;

use Yii;
use yii\base\Model;

class MenuEntryConfig extends Model
{
    public const DISPLAY_STATE_ALL = 'all';
    public const DISPLAY_STATE_NON_GUEST = 'non_guest';
    public const DISPLAY_STATE_ADMIN = 'admin';
    public const DISPLAY_STATE_NONE = 'none';

    /**
     * @var string The MenuLink ID
     */
    public string $id;
    public string $displayState = self::DISPLAY_STATE_ALL;
    public ?string $icon = null;
    public ?string $label = null;
    public ?string $sortOrder = null;

    public static function getDisplayStateLabels(): array
    {
        return [
            self::DISPLAY_STATE_ALL => Yii::t('MenuManagerModule.config', 'All'),
            self::DISPLAY_STATE_NON_GUEST => Yii::t('MenuManagerModule.config', 'Logged in users'),
            self::DISPLAY_STATE_ADMIN => Yii::t('MenuManagerModule.config', 'Administrators only'),
            self::DISPLAY_STATE_NONE => Yii::t('MenuManagerModule.config', 'None (hidden for all)'),
        ];
    }

    /**
     * @inheridoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id', 'displayState', 'icon', 'label'], 'string'],
            [['sortOrder'], 'integer'],
        ];
    }

    /**
     * @inheridoc
     */
    public function attributeLabels()
    {
        return [
            'displayState' => Yii::t('MenuManagerModule.config', 'Who should these items be displayed for?'),
            'icon' => Yii::t('MenuManagerModule.config', 'Icon'),
            'label' => Yii::t('MenuManagerModule.config', 'Name'),
            'sortOrder' => Yii::t('MenuManagerModule.config', 'Sort order'),
        ];
    }

    /**
     * @inheridoc
     */
    public function attributeHints()
    {
        return [
            'icon' => Yii::t('MenuManagerModule.config', 'Default if empty.'),
            'label' => Yii::t('MenuManagerModule.config', 'Default if empty.'),
            'sortOrder' => Yii::t('MenuManagerModule.config', 'Values between 1 and 10000.') . '<br>' . Yii::t('MenuManagerModule.config', 'Default if empty.'),
        ];
    }

    public function display(): bool
    {
        if ($this->displayState === self::DISPLAY_STATE_ALL) {
            return true;
        }
        if ($this->displayState === self::DISPLAY_STATE_NONE) {
            return false;
        }
        if ($this->displayState === self::DISPLAY_STATE_NON_GUEST) {
            return !Yii::$app->user->isGuest;
        }
        if ($this->displayState === self::DISPLAY_STATE_ADMIN) {
            return Yii::$app->user->isAdmin();
        }
        return false;
    }

    /**
     * @inheridoc
     */
    public function init(?array $config = null)
    {
        parent::init();

        if ($config) {
            $this->setAttributes($config);
        }
    }
}
