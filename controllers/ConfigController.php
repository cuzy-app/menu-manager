<?php
/**
 * Menu Manager
 * @link https://www.cuzy.app
 * @license https://www.cuzy.app/cuzy-license
 * @author [Marc FARRE](https://marc.fun)
 */

namespace humhub\modules\menuManager\controllers;

use humhub\modules\admin\components\Controller;
use humhub\modules\menuManager\Module;
use Yii;

class ConfigController extends Controller
{
    /**
     * @return string
     */
    public function actionIndex()
    {
        /** @var Module $module */
        $module = $this->module;
        $model = $module->getConfiguration();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $this->view->saved();
        }

        return $this->render('index', [
            'model' => $model
        ]);
    }
}
