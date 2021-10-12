
        <div class="row" style="margin-bottom: 10px">
            <div class="col-md-4">
                <?php echo anchor(site_url('transaksi/create'),'Create', 'class="btn btn-primary"'); ?>
            </div>
            <div class="col-md-4 text-center">
                <div style="margin-top: 8px" id="message">
                    <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                </div>
            </div>
            <div class="col-md-1 text-right">
            </div>
            <div class="col-md-3 text-right">
                <form action="<?php echo site_url('transaksi/index'); ?>" class="form-inline" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="<?php echo $q; ?>">
                        <span class="input-group-btn">
                            <?php 
                                if ($q <> '')
                                {
                                    ?>
                                    <a href="<?php echo site_url('transaksi'); ?>" class="btn btn-default">Reset</a>
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
		<th>No Transaksi</th>
		<th>Member</th>
		<th>Nama</th>
		<th>Meja</th>
        <th>Durasi</th>
		<th>Waktu Berjalan</th>
		<th>Total</th>
		<th>Disc</th>
		<th>Semua Total</th>
		<th>Created At</th>
		<th>Updated At</th>
		<th>User By</th>
		<th>Action</th>
            </tr><?php
            foreach ($transaksi_data as $transaksi)
            {
                ?>
                <tr>
			<td width="80px"><?php echo ++$start ?></td>
			<td><?php echo $transaksi->no_transaksi ?></td>
			<td><?php echo get_data('member','id_member',$transaksi->id_member,'nama') ?></td>
			<td><?php echo $transaksi->nama ?></td>
			<td><?php echo get_data('meja','id_meja',$transaksi->id_meja,'nama_meja') ?></td>
			<td><?php echo $transaksi->durasi.' Menit' ?></td>
            <td>
                <label id="jam">00</label>:<label id="minutes">00</label>:<label id="seconds">00</label>
            </td>
			<td><?php echo number_format($transaksi->total) ?></td>
			<td><?php echo $transaksi->disc.'%' ?></td>
			<td><?php echo number_format($transaksi->semua_total) ?></td>
			<td><?php echo $transaksi->created_at ?></td>
			<td><?php echo $transaksi->updated_at ?></td>
			<td><?php echo get_data('a_user','id_user',$transaksi->id_user,'nama_lengkap') ?></td>
			<td style="text-align:center" width="200px">
                <a data-toggle="modal" data-target="#myModal_<?php echo $transaksi->id_transaksi ?>" class="label label-success">Bayar</a>

                <!-- Modal -->
                  <div class="modal fade" id="myModal_<?php 
                  echo $transaksi->id_transaksi ?>" role="dialog">
                    <div class="modal-dialog">
                    
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Pembayaran</h4>
                        </div>
                        <div class="modal-body">
                          <form action="transaksi/simpan_pembayaran/<?php echo $transaksi->id_transaksi ?>" method="post">
                            <?php 
                            $subtotal = $this->db->query("SELECT sum(subtotal) as subtotal from transaksi_detail where id_transaksi='$transaksi->id_transaksi' ")->row()->subtotal;
                             ?>
                                <div class="form-group">
                                    <label>Total</label>
                                    <input type="text" name="total" value="<?php echo $subtotal ?>" class="form-control">
                                </div>  
                                <div class="form-group">
                                    <label>Diskon</label>
                                    <input type="text" name="diskon" value="0" placeholder="10" class="form-control" required=""> Persen
                                </div>   
                                <div class="form-group">
                                    <button class="btn btn-primary">Simpan</button>
                                </div>
                          </form>
                        </div>
                        <div class="modal-footer">
                          
                        </div>
                      </div>
                      
                    </div>
                  </div>

                <a href="transaksi/cetak/<?php echo $transaksi->id_transaksi ?>" class="label label-info">Print</a>
                <a href="transaksi_detail/index?id=<?php echo $transaksi->id_transaksi ?>" class="label label-default">input Detail</a>
				<?php 
				echo anchor(site_url('transaksi/update/'.$transaksi->id_transaksi),'<span class="label label-info">Ubah</span>'); 
				echo ' | '; 
				echo anchor(site_url('transaksi/delete/'.$transaksi->id_transaksi),'<span class="label label-danger">Hapus</span>','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
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

<script type="text/javascript">

        var minutesLabel = document.getElementById("minutes");
        var secondsLabel = document.getElementById("seconds");
        var jamLabel = document.getElementById("jam");
        var totalSeconds = 0; //detik
        setInterval(setTime, 1000);
        

        function setTime() {
          ++totalSeconds;
          secondsLabel.innerHTML = pad(totalSeconds % 60);
          minutesLabel.innerHTML = pad(parseInt(totalSeconds / 60));
          jamLabel.innerHTML = pad(parseInt(totalSeconds / 3600));
        }

        function pad(val) {
          var valString = val + "";
          if (valString.length < 2) {
            return "0" + valString;
          } else {
            return valString;
          }
        }
    </script>
    