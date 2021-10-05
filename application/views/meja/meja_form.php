
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Kode <?php echo form_error('kode') ?></label>
            <input type="text" class="form-control" name="kode" id="kode" placeholder="Kode" value="<?php echo $kode; ?>" />
        </div>
	    <div class="form-group">
            <label for="varchar">Nama Meja <?php echo form_error('nama_meja') ?></label>
            <input type="text" class="form-control" name="nama_meja" id="nama_meja" placeholder="Nama Meja" value="<?php echo $nama_meja; ?>" />
        </div>
	    <input type="hidden" name="id_meja" value="<?php echo $id_meja; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('meja') ?>" class="btn btn-default">Cancel</a>
	</form>
   