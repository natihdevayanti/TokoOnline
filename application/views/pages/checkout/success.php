<main role="main" class="container">

    <div class="row">
        <div class="col-md-12">
            <?php $this->load->view('layouts/_alert') ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Checkout Berhasil
                </div>
                <div class="card-body">
                    <h5>Nomor Order: <?= $content->invoice ?></h5>
                    <p>Terima kasih sudah berbelanja di Genicine!</p>
                    <p>Silakan melakukan pembayaran.</p>
                    <ol>
                        <li>Lakukan pembayaran pada rekening <strong>BCA 123412341234</strong> a/n PT. Genicine</li>
                        <li>Sertakan keterangan dengan nomor order: <strong><?= $content->invoice ?></strong></li>
                        <li>Total pembayaran: <strong>Rp<?= number_format($content->total, 0, ',', '.') ?>,-</strong></li>
                    </ol>
                    <p>Jika sudah, silakan kirimkan bukti transfer di halaman konfirmasi atau bisa <a href="<?= base_url("myorder/detail/$content->invoice") ?>">klik disini</a></p>
                    <a href="<?= base_url('home') ?>" class="btn" style="background-color: #fb607f;"><i class="fas fa-angle-left"></i> Kembali</a>
                </div>
            </div>
        </div>
    </div>
</main>