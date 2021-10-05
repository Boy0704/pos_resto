
        <form action="<?php echo $action; ?>" method="post">
	    <div class="form-group">
            <label for="varchar">Paket <?php echo form_error('paket') ?></label>
            <input type="text" class="form-control" name="paket" id="paket" placeholder="Paket" value="<?php echo $paket; ?>" />
        </div>
	    <div class="form-group">
            <label for="int">Jam <?php echo form_error('jam') ?></label>
            <input type="text" class="form-control" name="jam" id="jam" placeholder="Jam" value="<?php echo $jam; ?>" />
        </div>
	    <div class="form-group">
            <label for="deskripsi">Deskripsi <?php echo form_error('deskripsi') ?></label>
            <textarea class="form-control" rows="3" name="deskripsi" id="deskripsi" placeholder="Deskripsi"><?php echo $deskripsi; ?></textarea>
        </div>
	    <input type="hidden" name="id_paket" value="<?php echo $id_paket; ?>" /> 
	    <button type="submit" class="btn btn-primary"><?php echo $button ?></button> 
	    <a href="<?php echo site_url('paket_bermain') ?>" class="btn btn-default">Cancel</a>
	</form>
   