<?php

use \yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\LinkPager;
use frontend\widgets\InfiniteView;

/* @var $this yii\web\View */
/* @var $advertisers yii\web\User */

$this->title = 'Xclusivo - home page';
?>
<?php /*<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

        <p class="lead">You have successfully created your Yii-powered application.</p>

        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/doc/">Yii Documentation &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/forum/">Yii Forum &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Heading</h2>

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                    dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
                    ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu
                    fugiat nulla pariatur.</p>

                <p><a class="btn btn-default" href="http://www.yiiframework.com/extensions/">Yii Extensions &raquo;</a></p>
            </div>
        </div>

    </div>
</div> */ ?>
<div class="girls">
    <?= InfiniteView::widget([
        'dataProvider' => $dataProvider,
      //  'itemOptions' => ['class'=>'girl'],
      //  'layout' => "{items}",
      //  'itemView' => 'advetiser/view',
    ]);
?>
</div>
<?php
echo LinkPager::widget([
    'pagination' => $dataProvider->pagination
]);
?>


    <!--                <div class="girl offline"><a href="--><?//= \yii\helpers\Url::toRoute('site/advertiser');?><!--" class="cover-link"></a>-->
    <!--                    <div class="girl-img"><img src="/images/img10.jpg" alt=""/></div>-->
    <!--                    <div class="girl-cont">-->
    <!--                        <div class="girl-name">Anna, 25</div>-->
    <!--                        <div class="girl-price"><b>25</b> €/h</div>-->
    <!--                        <div class="girl-txt">I am a hot blonde;) willing to make your dreams come true.</div>-->
    <!--                    </div>-->
    <!--                </div>-->

<!--            <div class="btns"><a href="#" class="btn" onclick="alert('Coming Soon...')">Show me more</a></div>-->