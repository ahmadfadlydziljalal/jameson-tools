<?php
/* @see \app\controllers\SiteController::actionIndex() */

/* @var $this View */

use yii\web\View;

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-index d-flex flex-column gap-3">

    <div class="card">
        <div class="card-header">Rabu, 24 July 2024</div>
        <div class="card-body">

            <p class="lead">Bukti Pengeluaran Buku Bank </p>
            <ul>
                <li><span class="badge text-bg-danger">Bug</span> Switching kasbon_request to cash_advance(panjar) on update action<span class="badge text-bg-success">DONE</span></li>
            </ul>
            <p class="lead">Job Order </p>

            <ul>
                <li>Halaman view</li>
                <li>Halaman Index
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
        <div class="card-header">Selasa, 23 July 2024</div>
        <div class="card-body">
            <p class="lead">Reporting</p>

            Buku Bank Per Specific Date
            <ul>
                <li>Preview  <span class="badge text-bg-success">DONE</span></li>
                <li>Export To Pdf  <span class="badge text-bg-success">DONE</span></li>
            </ul>

            Petty Cash Per Specific Date
            <ul>
                <li>Preview  <span class="badge text-bg-success">DONE</span> </li>
                <li>Export To Pdf  <span class="badge text-bg-success">DONE</span></li>
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
                        <li>Attribute-attribute FK (_id) masih plain, sesuaikan! <span class="badge text-bg-success">DONE</span>
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
                        <li><span class="badge text-bg-danger">Bug</span> DELETE VOUCHER BUKU BANK YANG BERELASI DENGAN
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