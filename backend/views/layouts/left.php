<aside class="main-sidebar">
    <section class="sidebar">
        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => (Yii::$app->user->identity->status == 10)?require ('menu/super_admin.php'):require ('menu/admin.php')
            ]
        ) ?>
    </section>
</aside>
