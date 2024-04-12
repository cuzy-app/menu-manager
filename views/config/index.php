<?php
/**
 * Menu Manager
 * @link https://www.cuzy.app
 * @license https://www.cuzy.app/cuzy-license
 * @author [Marc FARRE](https://marc.fun)
 */

use humhub\modules\menuManager\models\Configuration;
use humhub\modules\menuManager\Module;
use humhub\modules\ui\form\widgets\ActiveForm;
use humhub\modules\ui\view\components\View;
use humhub\widgets\Button;


/**
 * @var $this View
 * @var $model Configuration
 */

/** @var Module $module */
$module = Yii::$app->getModule('menu-manager');
?>


<div class="panel panel-default">
    <div class="panel-heading">
        <strong><?= $module->getName() ?></strong>

        <div class="help-block">
            <?= $module->getDescription() ?>
        </div>
    </div>

    <div class="panel-body">
        <div class="alert alert-info">
            This module was created and is maintained by
            <a href="https://www.cuzy.app/"
               target="_blank">CUZY.APP (view other modules)</a>.
            <br>
            It's free, but it's the result of a lot of design and maintenance work over time.
            <br>
            If it's useful to you, please consider
            <a href="https://www.cuzy.app/checkout/donate/"
               target="_blank">making a donation</a>
            or
            <a href="https://github.com/cuzy-app/menu-manager"
               target="_blank">participating in the code</a>.
            Thanks!
        </div>

        <?php $form = ActiveForm::begin(['acknowledge' => true]); ?>

        <?php foreach ($model->availableTopMenuAttributes as $attribute): ?>
            <?= $this->render('_menu-entry-fields', [
                'form' => $form,
                'model' => $model,
                'attribute' => $attribute,
            ]) ?>
        <?php endforeach; ?>

        <br>
        <?= Button::danger(Yii::t('MenuManagerModule.config', 'Reset all settings'))
            ->link(['reset'])
            ->confirm()
            ->sm()
            ->right() ?>

        <?= Button::save()->submit() ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
