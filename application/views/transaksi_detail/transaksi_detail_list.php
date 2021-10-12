
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('transaksi_detail/create'.'?'.param_get()),'Create', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <form action="<?php echo site_url('transaksi_detail/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('transaksi_detail'); ?>" class="btn btn-default">Reset</a>
                                    <?php
                                }
                            ?>
                          <button class="btn btn-primary" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
        <table class="table table-bordered" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Id Transaksi</th>
		<th>Paket</th>
		<th>Deskripsi</th>
		<th>Harga</th>
		<th>Qty</th>
		<th>Subtotal</th>
		<th>Created At</th>
		<th>Updated At</th>
		<th>Action</th>
            </tr><?php
            foreach ($transaksi_detail_data as $transaksi_detail)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo get_data('transaksi','id_transaksi',$transaksi_detail->id_transaksi,'no_transaksi') ?></td>
			<td><?php echo get_data('paket_bermain','id_paket',$transaksi_detail->id_paket,'paket') ?></td>
			<td><?php echo get_data('paket_bermain','id_paket',$transaksi_detail->id_paket,'deskripsi') ?></td>
			<td><?php echo $transaksi_detail->harga ?></td>
			<td><?php echo $transaksi_detail->qty ?></td>
			<td><?php echo $transaksi_detail->subtotal ?></td>
			<td><?php echo $transaksi_detail->created_at ?></td>
			<td><?php echo $transaksi_detail->updated_at ?></td>
			<td style="text-align:center" width="200px">
				<?php 
				echo anchor(site_url('transaksi_detail/update/'.$transaksi_detail->id_detail_trx),'<span class="label label-info">Ubah</span>'); 
				echo ' | '; 
				echo anchor(site_url('transaksi_detail/delete/'.$transaksi_detail->id_detail_trx),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
				?>
			</td>
		</tr>
                <?php
            }
            ?>
        </table>
        </div>
        <div class="row">
            <div class="col-md-6">
                <a href="#" class="btn btn-primary">Total Record : <?php echo $total_rows ?></a>
	    </div>
            <div class="col-md-6 text-right">
                <?php echo $pagination ?>
            </div>
        </div>
    