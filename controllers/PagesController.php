<?php
namespace app\controllers;

use app\models\Page;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\Url;
use yii\web\NotFoundHttpException;

class PagesController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionShow($path)
    {
        $page = Page::find()->byPath($path)->one();
        if (!$page) {
            throw new NotFoundHttpException('Page not exists');
        }

        $this->setBreadcrumbs($page->getBreadcrumbs());

        return $this->render('show.twig', [
            'page' => $page,
        ]);
    }

    public function actionCreate($path = null)
    {
        $page = new Page();
        if ($path) {
            $parentPage = Page::find()->byPath($path)->one();
            $page->parent_id = $parentPage->page_id;
        }

        if ($page->load(Yii::$app->request->post()) && $page->validate()) {
            $page->created_at = date("Y-m-d H:i:s");
            $page->updated_at = date("Y-m-d H:i:s");
            if ($page->save()) {
                Yii::$app->session->addFlash(
                    'success',
                    'Page has been successfully created!'
                );
                return $this->redirect(Url::to([
                    'pages/show', 'path' => $page->getPath()]
                ));
            }
        }

        return $this->render('create.twig', [
            'page' => $page
        ]);
    }

    public function actionEdit($path)
    {
        $page = Page::find()->byPath($path)->one();
        if (!$page) {
            return new NotFoundHttpException('Page not exists');
        }

        if ($page->load(Yii::$app->request->post()) && $page->validate()) {
            $page->updated_at = date("Y-m-d H:i:s");
            if ($page->save()) {
                Yii::$app->session->addFlash(
                    'success',
                    'Page has been successfully updated!'
                );
                return $this->redirect(
                    Url::to(['pages/show', 'path' => $page->getPath()])
                );
            }
        }

        return $this->render('edit.twig', [
            'page' => $page
        ]);
    }

    public function actionDelete($path)
    {
        $page = Page::find()->byPath($path)->one();
        if (!$page) {
            return new NotFoundHttpException('Page not exists');
        }

        foreach ($page->getChildren() as $child) {
            $child->parent_id = $page->parent_id;
            $child->save();
        }

        if ($parent = $page->getParent()) {
            $redirectUrl = Url::to(['pages/show', 'path' => $parent->getPath()]);
        } else {
            $redirectUrl = Url::to(['site/main']);
        }

        $page->delete();

        return $this->redirect($redirectUrl);
    }
}
