<?php
/**
 * Menu Manager
 * @link https://www.cuzy.app
 * @license https://www.cuzy.app/cuzy-license
 * @author [Marc FARRE](https://marc.fun)
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

    /**
     * @var string defines path for resources, including the screenshots path for the marketplace
     */
    public $resourcesPath = 'resources';

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
        return Yii::t('MenuManagerModule.base', 'Change top menu items.');
    }
}
