<?php

/**
 * Menu Manager
 * @link https://github.com/cuzy-app/menu-manager
 * @license https://github.com/cuzy-app/menu-manager/blob/master/docs/LICENCE.md
 * @author [Marc FARRE](https://marc.fun) for [CUZY.APP](https://www.cuzy.app)
 */

namespace humhub\modules\menuManager\controllers;

use humhub\modules\admin\components\Controller;
use humhub\modules\menuManager\Module;
use Yii;

class ConfigController extends Controller
{
    public function actionIndex()
    {
        /** @var Module $module */
        $module = $this->module;
        $model = $module->getConfiguration();

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->save()) {
            $this->view->saved();
        }

        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionReset()
    {
        /** @var Module $module */
        $module = $this->module;
        $model = $module->getConfiguration();

        if ($model->reset()) {
            $this->view->saved();
        }

        return $this->htmlRedirect(['index']); // Not $this->>redirect() because the top menu must refresh (no ajax)
    }
}
