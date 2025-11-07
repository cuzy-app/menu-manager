<?php

/**
 * Menu Manager
 * @link https://github.com/cuzy-app/menu-manager
 * @license https://github.com/cuzy-app/menu-manager/blob/master/docs/LICENCE.md
 * @author [Marc FARRE](https://marc.fun) for [CUZY.APP](https://www.cuzy.app)
 */

namespace humhub\modules\menuManager\widgets;

use humhub\helpers\Html;
use humhub\modules\classifiedSpace\Module;
use humhub\modules\space\widgets\Chooser;
use humhub\modules\ui\icon\widgets\Icon;
use Yii;

class SpaceChooser extends Chooser
{
    protected function getNoSpaceHtml()
    {
        /** @var Module $module */
        $module = Yii::$app->getModule('menu-manager');
        $configuration = $module->getConfiguration();
        $mySpaceMenuEntryConfig = $configuration->getMenuEntryConfig('topMenuSpaceChooser');

        $html
            = Icon::get($mySpaceMenuEntryConfig->icon ?: 'dot-circle-o') . '<br>'
            . ($mySpaceMenuEntryConfig->label ?: Yii::t('SpaceModule.chooser', 'My spaces'));

        return Html::tag('div', $html, ['class' => 'no-space']);
    }
}
