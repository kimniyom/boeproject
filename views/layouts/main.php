<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body class="body">
        <?php $this->beginBody() ?>
        <div class="wrap" style=" margin-bottom: 0px; padding-bottom: 0px;">
            <?php
            NavBar::begin([
                'brandLabel' => Yii::$app->name,
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                    'style' => 'border:none;background:#000000;box-shadow:#999999 0px 0px 5px 0px;',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => [
                    ['label' => 'Home', 'url' => ['/site/index']],
                    //['label' => 'About', 'url' => ['/site/about']],
                    //['label' => 'Contact', 'url' => ['/site/contact']],
                    /*
                      Yii::$app->user->isGuest ? (
                      ['label' => 'Login', 'url' => ['/site/login']]
                      ) : (
                      '<li>'
                      . Html::beginForm(['/site/logout'], 'post')
                      . Html::submitButton(
                      'Logout (' . Yii::$app->user->identity->username . ')', ['class' => 'btn btn-link logout']
                      )
                      . Html::endForm()
                      . '</li>'
                      ),
                     * 
                     */
                    Yii::$app->user->isGuest ?
                            ['label' => 'Sign in', 'url' => ['/user/security/login']] :
                            ['label' => 'Account(' . Yii::$app->user->identity->username . ')', 'items' => [
                            ['label' => 'Profile', 'url' => ['/user/settings/profile']],
                            ['label' => 'Account', 'url' => ['/user/settings/account']],
                            ['label' => 'Setting', 'url' => ['/user/admin']],
                            ['label' => 'Logout', 'url' => ['/user/security/logout'], 'linkOptions' => ['data-method' => 'post']],
                        ]],
                    //['label' => 'Register', 'url' => ['/user/registration/register'], 'visible' => Yii::$app->user->isGuest],
                ],
            ]);
            NavBar::end();
            ?>
            <div class="container" style=" margin-bottom: 0px; padding-bottom: 0px;">
                <?=
                Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>

        

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
