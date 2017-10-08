<?php

namespace app\controllers;

use app\models\Page;
use Yii;

class SiteController extends BaseController
{
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionMain()
    {
        return $this->render('mainpage.twig', [
            'pages' => Page::find()->byParentId()->all()
        ]);
    }

    /**
     * @return string
     */
    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error.twig', [
                'exception' => $exception
            ]);
        }
    }
}
