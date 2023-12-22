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
        <?php $form = ActiveForm::begin(['acknowledge' => true]); ?>
        <h4><?= Yii::t('MenuManagerModule.config', 'Who should these items be displayed for?') ?></h4>
        <?= $form->field($model, 'homeDisplayState')->dropDownList(Configuration::getDisplayStateLabels()) ?>
        <?= $form->field($model, 'dashboardDisplayState')->dropDownList(Configuration::getDisplayStateLabels()) ?>
        <?= $form->field($model, 'spacesDisplayState')->dropDownList(Configuration::getDisplayStateLabels()) ?>
        <?= $form->field($model, 'peopleDisplayState')->dropDownList(Configuration::getDisplayStateLabels()) ?>
        <?php if (Yii::$app->getModule('calendar')): ?>
            <?= $form->field($model, 'calendarDisplayState')->dropDownList(Configuration::getDisplayStateLabels()) ?>
        <?php endif; ?>
        <?php if (Yii::$app->getModule('members-map')): ?>
            <?= $form->field($model, 'membersMapDisplayState')->dropDownList(Configuration::getDisplayStateLabels()) ?>
        <?php endif; ?>
        <?php if (Yii::$app->getModule('events-map')): ?>
            <?= $form->field($model, 'eventsMapDisplayState')->dropDownList(Configuration::getDisplayStateLabels()) ?>
        <?php endif; ?>
        <?= $form->field($model, 'streamFilterDisplayState')->dropDownList(Configuration::getDisplayStateLabels()) ?>
        <?= Button::save()->submit() ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>
