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
                    ['label' => 'Settings', 'icon' => 'fa fa-key', 'url' => ['/']],
                    [
                        'label' => 'Static Pages',
                        'icon' => 'fa fa-file-code-o',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Pages', 'icon' => 'fa fa-file-code-o', 'url' => ['/pages'],],
                            ['label' => 'Blocks', 'icon' => 'fa fa-cubes', 'url' => ['/'],],
                            ['label' => 'Menu', 'icon' => '	fa fa-navicon', 'url' => ['/'],],
                        ],
                    ],
                    ['label' => 'Spam Reports', 'icon' => 'fa fa-minus-circle', 'url' => ['/']],
                    ['label' => 'Chats', 'icon' => 'fa fa-comments-o', 'url' => ['/']],
                    ['label' => 'Advertisers', 'icon' => '	fa fa-female', 'url' => ['/']],
                    ['label' => 'Non-Advertisers', 'icon' => '	fa fa-male', 'url' => ['/']],
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
