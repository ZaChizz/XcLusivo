<?php

/**
 * Created by PhpStorm.
 * User: Ievgen
 * Date: 06.05.2016
 * Time: 19:59
 */
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use frontend\models\SignupForm;
use frontend\widgets\PreciseSearch;
use frontend\widgets\AdvInfo;
use frontend\widgets\FavoriteBar;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, maximum-scale=1.0">
		<?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
		<?php $this->head() ?>
        <link href='https://fonts.googleapis.com/css?family=Roboto:400,700,500,300&amp;subset=latin,cyrillic,latin-ext' rel='stylesheet' type='text/css'>
        <!--[if lt IE 9]><script src="js/css3-mediaqueries.js"></script><![endif]-->
        <!--[if IE]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
    </head>
    <body>
		<?php $this->beginBody() ?>
		<div id="container">
			<?= $this->render('//layouts/header') ?>
			<div id="content">
				<div class="cont-in">
					<div class="user-cont user-prof"><!-- user-prof -->
							<?= $content ?>
					</div>
          <div class="fav-col">
            <?php
            echo FavoriteBar::widget([
              'model' => \frontend\models\Favorits::getAll()
            ])
            ?>
          </div>
				</div>
			</div>
			<?= $this->render('//layouts/footer') ?>
		</div>

		<?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
