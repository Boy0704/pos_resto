
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">No Transaksi <?php echo form_error('no_transaksi') ?></label>
            <input type="text" class="form-control" name="no_transaksi" id="no_transaksi" placeholder="No Transaksi" value="<?php echo $no_transaksi; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Member <?php echo form_error('id_member') ?></label>
            <select name="id_member" class="form-control select2">
                <option value="<?php echo $id_member ?>"><?php echo get_data('member','id_member',$id_member,'nama') ?></option>
                <?php foreach ($this->db->get('member')->result() as $key => $value): ?>
                    <option value="<?php echo $value->id_member ?>"><?php echo $value->nama ?></option>
                <?php endforeach ?>
            </select>
        </div>
	    <div class="form-group">
            <label for="varchar">Nama <?php echo form_error('nama') ?></label>
            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" value="<?php echo $nama; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Meja <?php echo form_error('id_meja') ?></label>
            <select name="id_meja" class="form-control select2">
                <option value="<?php echo $id_meja ?>"><?php echo get_data('meja','id_meja',$id_meja,'nama_meja') ?></option>
                <?php foreach ($this->db->get('meja')->result() as $key => $value): ?>
                    <option value="<?php echo $value->id_meja ?>"><?php echo $value->nama_meja ?></option>
                <?php endforeach ?>
            </select>
        </div>
	    <div class="form-group">
            <label for="int">Durasi <?php echo form_error('durasi') ?></label>
            <input type="text" class="form-control" name="durasi" id="durasi" placeholder="Durasi (harus dalam satuan menit)" value="<?php echo $durasi; ?>" />
        </div>
	    
	    <input type="hidden" name="id_transaksi" value="<?php echo $id_transaksi; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('transaksi') ?>" class="btn btn-default">Cancel</a>
	</form>
   