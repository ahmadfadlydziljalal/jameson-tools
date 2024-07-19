<?php
/* @see \app\controllers\SiteController::actionIndex() */

/* @var $this View */

use yii\web\View;

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-index d-flex flex-column gap-3">
    <div class="card">
        <div class="card-header">Jumat, 19 July 2024</div>
        <div class="card-body">
            <h2>Todo</h2>

            <p class="lead">Rekening Page</p>
            <ul>
                <li>Tambahkan field nama_bank, nomor_account, saldo_awal, <span class="badge text-bg-success">DONE</span></li>
                <li>Sesuaikan kolom-kolom tersebut pada UI <span class="badge text-bg-success">DONE</span></li>
            </ul>

            <p class="lead">Bukti Pengeluaran Buku Bank</p>
            <ul>
                <li>Belum ada fitur export to PDF, buat! <span class="badge text-bg-success">DONE</span></li>
                <li>Pada halaman view, lakukan hal berikut:
                    <ol>
                        <li>Attribute-attribute FK (_id) masih plain, sesuaikan! <span class="badge text-bg-success">DONE</span></li>
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
                        <li>Ganti informasi bank, hanya `nama` saja, bukan `atas nama` field <span class="badge text-bg-success">DONE</span></li>
                    </ol>
                </li>
                <li>Pada halaman view. lakukan hal berikut:
                    <ol>
                        <li>Samakan dengan gaya umum yang sudah di custom, seperti pada page lainnya <span class="badge text-bg-success">DONE</span></li>
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
                        <li>Nama Bank belum ada</li>
                        <li><span class="badge text-bg-danger">Bug</span> DELETE VOUCHER BUKU BANK YANG BERELASI DENGAN MUTASI KAS!</li>
                    </ol>
                </li>
                <li>Pada halaman view, lakukan hal berikut:
                    <ol>
                        <li>Tambah button update, pastikan url yang digunakan sesuai dengan karakteristik record
                            tersebut
                        </li>
                    </ol>
                </li>
            </ul>

            <p class="lead">Mutasi Kas</p>
            <ul>
                <li>Pada halaman index. lakukan hal berikut:
                    <ol>
                        <li>Nomor voucher buku bank belum ada</li>
                    </ol>
                </li>
                <li>Pada halaman view, lakukan hal berikut:
                    <ol>
                        <li>Tambah button update, pastikan url yang digunakan sesuai dengan karakteristik record
                            tersebut
                        </li>
                        <li>Next | Prev button</li>
                    </ol>
                </li>
            </ul>




        </div>
    </div>
</div>