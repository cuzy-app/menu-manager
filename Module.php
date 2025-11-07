<?php

/**
 * Menu Manager
 * @link https://github.com/cuzy-app/menu-manager
 * @license https://github.com/cuzy-app/menu-manager/blob/master/docs/LICENCE.md
 * @author [Marc FARRE](https://marc.fun) for [CUZY.APP](https://www.cuzy.app)
 */

namespace humhub\modules\menuManager;

use humhub\modules\menuManager\models\Configuration;
use Yii;
use yii\helpers\Url;

class Module extends \humhub\components\Module
{
    /**
     * @var string defines the icon
     */
    public $icon = 'circle-o';

    private ?Configuration $_configuration = null;

    public function getConfiguration(): Configuration
    {
        if ($this->_configuration === null) {
            $this->_configuration = new Configuration(['settingsManager' => $this->settings]);
            $this->_configuration->loadBySettings();
        }
        return $this->_configuration;
    }

    /**
     * @inheritdoc
     */
    public function getConfigUrl()
    {
        return Url::to(['/menu-manager/config']);
    }

    public function getName()
    {
        return Yii::t('MenuManagerModule.base', 'Menu Manager');
    }

    public function getDescription()
    {
        return Yii::t('MenuManagerModule.base', 'Change top menu items and add a "Home" item.');
    }
}
