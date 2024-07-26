<?php

/* @var $this View */
/* @var $withBreadcrumb bool */
/* @var $withDevelopmentStory bool */

/* @see \app\controllers\SiteController::actionAbout() */

use yii\bootstrap5\Html;
use yii\web\View;

if (!$this->title) {
    $this->title = 'Tentang Web';
}

if ($withBreadcrumb) {
    $this->params['breadcrumbs'][] = $this->title;
}

?>


<?php if ($withDevelopmentStory) : ?>
    <div class="site-about d-flex flex-column gap-3">
        <div class="card">
            <div class="card-header">Jumat, 26 July 2024</div>
            <div class="card-body">
                <p class="lead">Register bukti-bukti ke BB dan PC</p>
                <ul>
                    <li>Bukti Penerimaan Petty Cash <span class="badge text-bg-success">DONE</span</li>
                    <li>Bukti Pengeluaran Petty Cash <span class="badge text-bg-success">DONE</span</li>
                    <li>Bukti Penerimaan Buku Bank <span class="badge text-bg-success">DONE</span</li>
                    <li>Bukti Pengeluaran Buku Bank <span class="badge text-bg-success">DONE</span</li>
                </ul>

                <p class="lead">Migration</p>
                <ul>
                    <li>Bukti Penerimaan Petty Cash: Tanggal Transaksi <span class="badge text-bg-success">DONE</span
                    </li>
                    <li>Bukti Pengeluaran Petty Cash: Tanggal Transaksi <span class="badge text-bg-success">DONE</span<
                    </li>
                </ul>

                <p class="lead">Reporting</p>
                <ul>
                    <li>Invoice belum lunas</li>
                    <li>Invoice per customer</li>
                    <li>Invoice per periode</li>
                    <li>Laporan harian penerimaan dan pengeluaran toko</li>
                </ul>

            </div>
        </div>
        <div class="card">
            <div class="card-header">Kamis, 25 July 2024</div>
            <div class="card-body">
                <p class="lead">Invoice</p>
                <ul>
                    <li>Inputan barang saat update, masih pake ID, bukan nama barang <span
                                class="badge text-bg-success">DONE</span
                    </li>
                </ul>

                <p class="lead">Buku Bank</p>
                <ul>
                    <li>Peeking doc di masing-masing form <span class="badge text-bg-success">DONE</span</li>
                    <li>UI, re-order form, tanggal paling pertama, sebelumnya ada di urutan dua <span
                                class="badge text-bg-success">DONE</span<</li>
                </ul>

                <p class="lead">Site</p>
                <ul>
                    <li><span>Move dokumentasi dari index ke about</span></li>
                    <li>Powerfull dashboard
                        <ol>
                            <li>List Bank Account <span class="badge text-bg-success">DONE</span></li>
                            <li>Petty Cash <span class="badge text-bg-success">DONE</span></li>
                            <li>Summary <span class="badge text-bg-success">DONE</span></li>
                            <li>Export Dashboard to PDF <span class="badge text-bg-success">DONE</span></li>
                        </ol>
                    </li>
                </ul>

                <p class="lead">Theming</p>
                <ul>
                    <li><span>Green based</span> <span class="badge text-bg-success">DONE</span></li>
                </ul>

                <p class="lead">Konsistensi UI</p>
                <ul>
                    <li>Bukti Penerimaan Buku Bank <span class="badge text-bg-success">DONE</span></li>
                    <li>Bukti Pengeluaran Buku Bank <span class="badge text-bg-success">DONE</span></li>
                    <li>Buku Bank <span class="badge text-bg-success">DONE</span></li>
                </ul>

            </div>
        </div>
        <div class="card">
            <div class="card-header">Rabu, 24 July 2024</div>
            <div class="card-body">

                <p class="lead">Bukti Pengeluaran Buku Bank </p>
                <ul>
                    <li><span class="badge text-bg-danger">Bug</span> Switching kasbon_request to cash_advance(panjar)
                        on
                        update action<span class="badge text-bg-success">DONE</span></li>
                    <li>
                        UI: samakan format `form` setiap scenario yang ada seperti pada scenario `cash_advance`
                        <ol>
                            <li>Scenario Tagihan / Bill <span class="badge text-bg-success">DONE</span></li>
                            <li>Scenario For Petty Cash <span class="badge text-bg-success">DONE</span></li>
                        </ol>
                    </li>
                    <li>
                        UI: Check DELETE url, apakah sudah sesuai dengan masing-masing scenario <span
                                class="badge text-bg-success">DONE</span>
                    </li>
                </ul>

                <p class="lead">Job Order </p>
                <ul>
                    <li>Halaman view<span class="badge text-bg-success">DONE</span></li>
                    <li>Halaman Index <span class="badge text-bg-success">DONE</span>
                        <ul>
                            <li>Indikator kasbon belum pindah ke panjar</li>
                        </ul>
                    </li>
                </ul>

                <p class="lead">Head logo untuk dokumen PDF </p>
                <ul>
                    <li>Invoice <span class="badge text-bg-success">DONE</span></li>
                </ul>

                <p class="lead">Fungsi fungsi search pada setiap gridview</p>
                <ul>
                    <li>
                        Invoice <span class="badge text-bg-success">DONE</span>
                        <ol>
                            <li>Reference number</li>
                            <li>Customer ID</li>
                            <li>Tanggal Invoice</li>
                            <li>Rekening</li>
                        </ol>
                    </li>
                    <li>
                        Job Order <span class="badge text-bg-success">DONE</span>
                        <ol>
                            <li>Reference number</li>
                            <li>Main Vendor ID</li>
                            <li>Main Customer ID</li>
                        </ol>
                    </li>
                    <li>Setoran Kasir <span class="badge text-bg-success">DONE</span>
                        <ol>
                            <li>Reference number</li>
                            <li>Tanggal Setoran</li>
                            <li>Cashier ID</li>
                            <li>Staff nam</li>
                        </ol>
                    </li>
                </ul>

                <p class="lead">Barang</p>
                <ul>
                    <li>Display harga <span class="badge text-bg-success">DONE</span></li>
                </ul>

                <p class="lead">Card</p>
                <ul>
                    <li>Auto generate code card <span class="badge text-bg-success">DONE</span></li>
                    <li>Remove Equipment <span class="badge text-bg-success">DONE</span></li>
                </ul>

                <p class="lead">UI</p>
                <ul>
                    <li>Card Type <span class="badge text-bg-success">DONE</span></li>
                    <li>Cashier <span class="badge text-bg-success">DONE</span></li>
                    <li>Jenis Biaya <span class="badge text-bg-success">DONE</span></li>
                    <li>Jenis Pendapatan <span class="badge text-bg-success">DONE</span></li>
                    <li>Kode Voucher <span class="badge text-bg-success">DONE</span></li>
                    <li>Petty Cash <span class="badge text-bg-success">DONE</span></li>
                    <li>Rekening <span class="badge text-bg-success">DONE</span></li>
                    <li>Satuan <span class="badge text-bg-success">DONE</span></li>
                </ul>
            </div>
        </div>
        <div class="card">
            <div class="card-header">Selasa, 23 July 2024</div>
            <div class="card-body">
                <p class="lead">Reporting</p>

                Buku Bank Per Specific Date
                <ul>
                    <li>Preview <span class="badge text-bg-success">DONE</span></li>
                    <li>Export To Pdf <span class="badge text-bg-success">DONE</span></li>
                </ul>

                Petty Cash Per Specific Date
                <ul>
                    <li>Preview <span class="badge text-bg-success">DONE</span></li>
                    <li>Export To Pdf <span class="badge text-bg-success">DONE</span></li>
                </ul>

                Job Order > Petty Cash,
                <ul>
                    <li>Belum ada form edit <span class="badge text-bg-success">DONE</span></li>
                </ul>

                <p class="lead">Barang</p>
                <ul>
                    <li>Mulai rapikan data barang, bisa lihat backup-an data dari tahun 2022</li>
                </ul>

            </div>
        </div>
        <div class="card">
            <div class="card-header">Senin, 22 July 2024</div>
            <div class="card-body">
                <p class="lead">Bukti Pengeluaran Petty Cash</p>
                <ul>
                    <li>Pada halaman index, lakukan hal berikut:
                        <ol>
                            <li>Bisa search By Nomor JO <span class="badge text-bg-success">DONE</span></li>
                        </ol>
                    </li>
                    <li>Pada halaman view, lakukan hal berikut:
                        <ol>
                            <li>Style dan functionalitas button-button harus sama seperti page lainnya <span
                                        class="badge text-bg-success">DONE</span></li>
                            <li>Next | Prev button <span class="badge text-bg-success">DONE</span></li>
                        </ol>
                    </li>
                </ul>

                <p class="lead">Bukti Penerimaan Petty Cash</p>
                <ul>
                    <li>Pada halaman view, lakukan hal berikut:
                        <ol>
                            <li>Style dan functionalitas button-button harus sama seperti page lainnya <span
                                        class="badge text-bg-success">DONE</span></li>
                            <li>Next | Prev button <span class="badge text-bg-success">DONE</span></li>
                        </ol>
                    </li>
                </ul>


            </div>
        </div>
        <div class="card">
            <div class="card-header">Jumat, 19 July 2024</div>
            <div class="card-body">

                <p class="lead">Rekening Page</p>
                <ul>
                    <li>Tambahkan field nama_bank, nomor_account, saldo_awal, <span
                                class="badge text-bg-success">DONE</span></li>
                    <li>Sesuaikan kolom-kolom tersebut pada UI <span class="badge text-bg-success">DONE</span></li>
                </ul>

                <p class="lead">Bukti Pengeluaran Buku Bank</p>
                <ul>
                    <li>Belum ada fitur export to PDF, buat! <span class="badge text-bg-success">DONE</span></li>
                    <li>Pada halaman view, lakukan hal berikut:
                        <ol>
                            <li>Attribute-attribute FK (_id) masih plain, sesuaikan! <span
                                        class="badge text-bg-success">DONE</span>
                            </li>
                            <li>Tambah button update, pastikan url yang digunakan sesuai dengan karakteristik record
                                tersebut <span class="badge text-bg-success">DONE</span>
                            </li>
                            <li>Next | Prev button <span class="badge text-bg-success">DONE</span></li>
                        </ol>
                    </li>
                </ul>

                <p class="lead">Bukti Penerimaan Buku Bank</p>
                <ul>
                    <li>Pada halaman index. lakukan hal berikut:
                        <ol>
                            <li>Munculkan Kolom voucher buku bank <span class="badge text-bg-success">DONE</span></li>
                            <li>Ganti informasi bank, hanya `nama` saja, bukan `atas nama` field <span
                                        class="badge text-bg-success">DONE</span></li>
                        </ol>
                    </li>
                    <li>Pada halaman view. lakukan hal berikut:
                        <ol>
                            <li>Samakan dengan gaya umum yang sudah di custom, seperti pada page lainnya <span
                                        class="badge text-bg-success">DONE</span></li>
                            <li>Button update, pastikan url yang digunakan sesuai dengan karakteristik record
                                tersebut <span class="badge text-bg-success">DONE</span>
                            </li>
                            <li>Button Buat Record lainnya <span class="badge text-bg-success">DONE</span></li>
                            <li>Button Export To PDF <span class="badge text-bg-success">DONE</span></li>
                            <li>Next | Prev button <span class="badge text-bg-success">DONE</span></li>
                        </ol>
                    </li>
                </ul>

                <p class="lead">Buku Bank</p>
                <ul>
                    <li>Pada halaman index. lakukan hal berikut:
                        <ol>
                            <li>Nama Bank belum ada, juga kemampuan melakukan search bank ini pada gridview <span
                                        class="badge text-bg-success">DONE</span></li>
                            <li><span class="badge text-bg-danger">Bug</span> DELETE VOUCHER BUKU BANK YANG BERELASI
                                DENGAN
                                MUTASI KAS! <span class="badge text-bg-success">DONE</span></li>
                        </ol>
                    </li>
                    <li>Pada halaman view, lakukan hal berikut:
                        <ol>
                            <li>Tambah button update, pastikan url yang digunakan sesuai dengan karakteristik record
                                tersebut <span class="badge text-bg-success">DONE</span>
                            </li>
                        </ol>
                    </li>
                </ul>

                <p class="lead">Mutasi Kas</p>
                <ul>
                    <li>Pada halaman index. lakukan hal berikut:
                        <ol>
                            <li>Nomor voucher buku bank belum ada <span class="badge text-bg-success">DONE</span></li>
                        </ol>
                    </li>
                    <li>Pada halaman view, lakukan hal berikut:
                        <ol>
                            <li>Tambah button update, pastikan url yang digunakan sesuai dengan karakteristik record
                                tersebut <span class="badge text-bg-success">DONE</span>
                            </li>
                            <li>Next | Prev button <span class="badge text-bg-success">DONE</span></li>
                        </ol>
                    </li>
                </ul>


            </div>
        </div>
    </div>
    <div class="my-5"></div>
<?php endif; ?>

<div class="site-about" style="max-width: 48rem">
    <div class="d-flex flex-column flex-nowrap gap-3">
        <div class="d-flex flex-row" style="gap: 1rem">
            <h1><?= Yii::$app->settings->get('site.icon') ?></h1>
            <h1>
                <?php
                $text = Yii::$app->settings->get('site.name');
                echo empty($text) ? Yii::$app->name : $text
                ?>
            </h1>
        </div>
        <div class="d-flex flex-column text-justify" style="gap: 1.5rem">
            <?= Yii::$app->settings->get('site.description') ?>
        </div>
        <div class="d-flex justify-content-between align-items-center py-2">
            <div class="d-flex flex-column">
                <span class="text-muted">Dibuat dan di maintenance oleh:</span>
                <span><?= Yii::$app->settings->get('site.maintainer') !== null ?
                        Yii::$app->settings->get('site.maintainer') :
                        Yii::$app->params['maintainer']
                    ?>
                </span>
            </div>

            <div class="px-3">
                <?php echo Html::img(Yii::getAlias('@web') . '/images/undraw_feeling_proud_qne1.svg', [
                    'class' => 'img-fluid',
                    'style' => [
                        'transform' => 'scaleX(-1)',
                        'width' => '8rem',
                        'height' => 'auto'
                    ]
                ]) ?>
            </div>

        </div>
    </div>
</div>