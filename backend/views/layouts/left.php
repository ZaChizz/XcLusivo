<?php
  use yii\web\View;
?>
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user3-128x128.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->username ?></p>
            </div>
        </div>

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Menu', 'options' => ['class' => 'header']],
                    ['label' => 'Settings', 'icon' => 'fa fa-key', 'url' => ['/settings']],
                    ['label' => 'Pages', 'icon' => 'fa fa-file-code-o', 'url' => ['/pages'],],
//                    [
//                        'label' => 'Static Pages',
//                        'icon' => 'fa fa-file-code-o',
//                        'url' => '#',
//                        'items' => [
//                            ['label' => 'Pages', 'icon' => 'fa fa-file-code-o', 'url' => ['/pages'],],
//                            ['label' => 'Blocks', 'icon' => 'fa fa-cubes', 'url' => ['/'],],
//                            ['label' => 'Menu', 'icon' => '	fa fa-navicon', 'url' => ['/'],],
//                        ],
//                    ],
                    ['label' => 'Spam Reports <span class="spam-new hidethis">new</span>', 'icon' => 'fa fa-minus-circle', 'url' => ['/spam'], 'encode' => false],
                    ['label' => 'Chats <span class="chat-new hidethis">new</span>', 'icon' => 'fa fa-comments-o', 'url' => ['/chat'], 'encode' => false],
                    ['label' => 'Reviews', 'icon' => 'fa fa-edit', 'url' => ['/reviews'], 'encode' => false],
                    ['label' => 'Replys', 'icon' => 'fa fa-edit', 'url' => ['/replys'], 'encode' => false],
                    ['label' => 'Users', 'icon' => 'fa fa-male', 'url' => ['/user']],
                    ['label' => 'Payments list', 'icon' => 'fa fa-diamond', 'url' => ['/payment']],
                    ['label' => 'Payment history', 'icon' => 'fa fa-diamond', 'url' => ['/payment-history']],
                    ['label' => 'Services (Offering/Receiving)', 'icon' => 'fa fa-magic', 'url' => ['/services']],
                    ['label' => 'Cities', 'icon' => 'fa fa-location-arrow', 'url' => ['/city']],
                    ['label' => 'Currency', 'icon' => 'fa fa-btc', 'url' => ['/currency']],
                    ['label' => 'Translations', 'icon' => 'fa fa-language', 'url' => ['/translation']],
//                    ['label' => 'Advertisers', 'icon' => '	fa fa-female', 'url' => ['/advertisers']],
//                    ['label' => 'Non-Advertisers', 'icon' => '	fa fa-male', 'url' => ['/']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Same tools',
                        'icon' => 'fa fa-share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'fa fa-file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'fa fa-dashboard', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'fa fa-circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'fa fa-circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'fa fa-circle-o', 'url' => '#',],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
<?php
  $js = '
  function checkNewSpamReports()
  {
      $.get("/spam/has-new", function(data) {
          if (data == 1) {
              $(".spam-new").show();
          } else  {
              $(".spam-new").hide();
          }
          setTimeout(checkNewSpamReports, 20000);
      });
  }

  function checkNewChatMessages()
  {
      $.get("/chat/has-new", function(data) {
          if (data == 1) {
              $(".chat-new").show();
          } else  {
              $(".chat-new").hide();
          }
          setTimeout(checkNewChatMessages, 19000);
      });
  }

  checkNewSpamReports();
  checkNewChatMessages();
';

$this->registerJs($js, View::POS_READY);
