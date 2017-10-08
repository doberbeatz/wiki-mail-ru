<?php

namespace app\controllers;

use yii\web\Controller;

class BaseController extends Controller
{
    /**
     * @param array $breadcrumbs
     */
    public function setBreadcrumbs(array $breadcrumbs)
    {
        $this->view->params['breadcrumbs'] = $breadcrumbs;
    }
}