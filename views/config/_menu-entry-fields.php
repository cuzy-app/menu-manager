<?php
/**
 * Menu Manager
 * @link https://www.cuzy.app
 * @license https://www.cuzy.app/cuzy-license
 * @author [Marc FARRE](https://marc.fun)
 */

use humhub\modules\menuManager\models\Configuration;
use humhub\modules\menuManager\models\MenuEntryConfig;
use humhub\modules\ui\form\widgets\ActiveForm;
use humhub\modules\ui\form\widgets\IconPicker;
use humhub\modules\ui\view\components\View;


/**
 * @var $this View
 * @var $form ActiveForm
 * @var $model Configuration
 * @var $attribute string
 */

$configurationAttributeLabels = (new Configuration())->attributeLabels();
$MenuEntryConfigAttributeLabels = (new MenuEntryConfig())->attributeLabels();
$MenuEntryConfigAttributeHints = (new MenuEntryConfig())->attributeHints();
?>

<h4><?= $configurationAttributeLabels[$attribute] ?></h4>

<div class="row">
    <div class="col-md-3">
        <?= $form->field($model, $attribute . '[displayState]')
            ->dropDownList(MenuEntryConfig::getDisplayStateLabels())
            ->label($MenuEntryConfigAttributeLabels['displayState'] ?? '')
            ->hint($MenuEntryConfigAttributeHints['displayState'] ?? '') ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, $attribute . '[icon]')
            ->widget(IconPicker::class)
            ->label($MenuEntryConfigAttributeLabels['icon'] ?? '')
            ->hint($MenuEntryConfigAttributeHints['icon'] ?? '') ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, $attribute . '[label]')
            ->textInput()
            ->label($MenuEntryConfigAttributeLabels['label'] ?? '')
            ->hint($MenuEntryConfigAttributeHints['label'] ?? '') ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, $attribute . '[sortOrder]')
            ->textInput(['type' => 'number', 'step' => 1, 'min' => 1, 'max' => 10000])
            ->label($MenuEntryConfigAttributeLabels['sortOrder'] ?? '')
            ->hint($MenuEntryConfigAttributeHints['sortOrder'] ?? '') ?>
    </div>
</div>
