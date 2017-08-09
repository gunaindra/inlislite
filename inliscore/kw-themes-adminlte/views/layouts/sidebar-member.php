<?php
use yii\bootstrap\Nav;
use inliscore\adminlte\widgets\SideMenu;
use mdm\admin\components\MenuHelper;
?>
<aside class="main-sidebar">

    <section class="sidebar">

    <?php
    if (Yii::$app->user->isGuest) {
        Yii::$app->getResponse()->redirect(\Yii::$app->getUser()->loginUrl);
    } else {
        echo Yii::$app->user->identity->NoAnggota;
    }
    
    $menuCallback = function($menu) {
            $item = [
                'label' => $menu['name'],
                'url' => MenuHelper::parseRoute($menu['route']),
            ];
            if (!empty($menu['data'])) {
                $item['icon'] = 'fa ' . $menu['data'];
            } else {
                $item['icon'] = 'fa fa-angle-double-right';
            }
            if ($menu['children'] != []) {
                $item['items'] = $menu['children'];
            }
            return $item;
        };
    echo SideMenu::widget(
            [
                'items' => [
                    ['label' => 'Dashboard', 'url' => ['/site/index'], 'icon'=>'fa fa-dashboard'],
                    ['label' => 'Profil', 'url' => ['/user/index'], 'icon'=>'fa fa-user'],
                    ['label' => 'Histori Perpanjangan', 'url' => ['/site/daftar-perpanjangan'], 'icon'=>'fa fa-retweet'],
                    ['label' => 'Histori Peminjaman Koleksi', 'icon' => 'fa fa-book',
                            'items' => [
                                ['label' => 'Koleksi Sedang Dipinjam', 'url' => ['/site/daftar-peminjaman'], 'icon' => 'fa fa-angle-double-right'],
                                ['label' => 'Koleksi Telah Dikembalikan', 'url' => ['/site/daftar-pengembalian'], 'icon' => 'fa fa-angle-double-right'],
                                ['label' => 'Histori Pelanggaran', 'url' => ['/site/daftar-pelanggaran'], 'icon' => 'fa fa-angle-double-right'],
                            ]
                    ],
                    ['label' => 'Histori Pemesanan Koleksi', 'icon' => 'fa fa-book',
                            'items' => [
                                ['label' => 'Koleksi Sedang Dipesan', 'url' => ['/site/koleksi-sedang-dipesan'], 'icon' => 'fa fa-angle-double-right'],
                                ['label' => 'Koleksi Pernah Dipesan', 'url' => ['/site/koleksi-pernah-dipesan'], 'icon' => 'fa fa-angle-double-right'],
                            ]
                    ],
                    ['label' => 'Histori Baca ditempat', 'url' => ['/site/baca-ditempat'], 'icon'=>'fa fa-dashboard'],
                    ['label' => 'Histori Kunjungan', 'url' => ['/site/kunjungan'], 'icon'=>'fa fa-dashboard'],
                    ['label' => 'Histori Peminjaman Loker', 'icon' => 'fa fa-key',
                            'items' => [
                                ['label' => 'Loker Sedang Dipinjam', 'url' => ['/site/loker-pinjam'], 'icon' => 'fa fa-angle-double-right'],
                                ['label' => 'Loker Pernah Dipinjam', 'url' => ['/site/loker-kembali'], 'icon' => 'fa fa-angle-double-right'],
                                ['label' => 'Histori Pelanggaran', 'url' => ['/site/loker-pelanggaran'], 'icon' => 'fa fa-angle-double-right'],
                            ]
                    ],
                    //['label' => 'Histori Pengisian Survey', 'url' => ['/site/histori-survey'], 'icon'=>'fa fa-dashboard'],
                    ['label' => 'Histori Sumbangan Anggota', 'url' => ['/site/sumbangan-anggota'], 'icon'=>'fa fa-dashboard'],
                    ['label' => 'Koleksi Favorit', 'url' => ['/site/koleksi-favorit'], 'icon'=>'fa fa-dashboard'],
                    ['label' => 'Usulan Koleksi', 'url' => ['/usulan-koleksi/index'], 'icon'=>'fa fa-dashboard'],
                ],
    ]);
    ?>




    </section>

</aside>
