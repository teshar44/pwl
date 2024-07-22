<?= $this->extend('layout') ?>
<?= $this->section('content') ?>

<div class="table-responsive">
    <a href="<?= base_url('transaksi/tambah') ?>" class="btn btn-primary mb-3">Tambah Transaksi</a>
    <a href="<?= base_url('transaksi/download') ?>" class="btn btn-danger mb-3">Download PDF</a>
    <!-- Table with stripped rows -->
    <table class="table datatable">
        <thead>
            <tr>
                <th>#</th>
                <th>ID Pembelian</th>
                <th>Waktu Pembelian</th>
                <th>Total Bayar</th>
                <th>Alamat</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (!empty($buy)) :
                foreach ($buy as $index => $item) :
            ?>
                    <tr>
                        <th scope="row"><?= $index + 1 ?></th>
                        <td><?= $item['username'] ?></td>
                        <td><?= $item['created_at'] ?></td>
                        <td><?= number_to_currency($item['total_harga'], 'IDR') ?></td>
                        <td><?= $item['alamat'] ?></td>
                        <td><?= $item['status'] ?></td>
                        <td>
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#detailModal-<?= $item['id'] ?>">
                                Ubah Status
                            </button>
                        </td>
                    </tr>
                    <!-- Detail Modal Begin -->
                    <div class="modal fade" id="detailModal-<?= $item['id'] ?>" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Data</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="<?= base_url('transaksi') ?>" method="post">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                    <div class="form-group">
                                        <label for="status">Status Transaksi</label>
                                        <select name="status" class="form-control">
                                            <option value="1" <?= $item['status'] == "1" ? 'selected' : '' ?>>1</option>
                                            <option value="0" <?= $item['status'] == "0" ? 'selected' : '' ?>>0</option>
                                        </select>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
            <?php
                endforeach;
            endif;
            ?>
        </tbody>
    </table>
    <!-- End Table with stripped rows -->
</div>

<?= $this->endSection() ?>
