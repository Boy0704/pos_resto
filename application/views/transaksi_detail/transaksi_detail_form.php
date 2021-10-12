
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="int">Id Transaksi <?php echo form_error('id_transaksi') ?></label>
            <input type="hidden" class="form-control" name="id_transaksi" id="id_transaksi" placeholder="Id Transaksi" value="<?php echo $this->input->get('id'); ?>" />
            <input type="text" class="form-control" value="<?php echo get_data('transaksi','id_transaksi',$this->input->get('id'),'no_transaksi'); ?>" readonly/>
        </div>
	    <div class="form-group">
            <label for="int">Paket <?php echo form_error('id_paket') ?></label>
            <select name="id_paket" class="form-control">
                <option value="<?php echo $id_paket ?>"><?php echo $id_paket ?></option>
                <?php foreach ($this->db->get('paket_bermain')->result() as $key => $value): ?>
                    <option value="<?php echo $value->id_paket ?>"><?php echo $value->paket.' | '.$value->deskripsi ?></option>
                <?php endforeach ?>
            </select>
        </div>
	    <!-- <div class="form-group">
            <label for="deskripsi">Deskripsi <?php echo form_error('deskripsi') ?></label>
            <textarea class="form-control" rows="3" name="deskripsi" id="deskripsi" placeholder="Deskripsi"><?php echo $deskripsi; ?></textarea>
        </div> -->
	    <div class="form-group">
            <label for="int">Harga <?php echo form_error('harga') ?></label>
            <input type="text" class="form-control" name="harga" id="harga" placeholder="Harga" value="<?php echo $harga; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Qty <?php echo form_error('qty') ?></label>
            <input type="text" class="form-control" name="qty" id="qty" placeholder="Qty" value="<?php echo $qty; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Subtotal <?php echo form_error('subtotal') ?></label>
            <input type="text" class="form-control" name="subtotal" id="subtotal" placeholder="Subtotal" value="<?php echo $subtotal; ?>" />
        </div>
	    
	    <input type="hidden" name="id_detail_trx" value="<?php echo $id_detail_trx; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('transaksi_detail'.'?'.param_get()) ?>" class="btn btn-default">Cancel</a>
	</form>
   