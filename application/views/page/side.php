<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="image/user/<?php echo $this->session->userdata('foto'); ?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $this->session->userdata('nama'); ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- search form -->
      <!-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU KHUSUS KASIR</li>
        
        <?php if ($this->session->userdata('level') == 'admin') { ?>
        <li><a href="app"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
        
        <li><a href="transaksi"><i class="fa fa-clone"></i> <span>Table Reservation</span></a></li>
        <li><a href="app/pengembangan"><i class="fa fa-pencil"></i> <span>Monitor User</span></a></li>
        <li><a href="paket_bermain"><i class="fa fa-quote-left"></i> <span>Paket Bermain</span></a></li>
        <li><a href="member"><i class="fa fa-building-o"></i> <span>Data Member</span></a></li>
        <li><a href="app/pengembangan"><i class="fa fa-arrow-right"></i> <span>Pembayaran</span></a></li>
        <li><a href="app/pengembangan"><i class="fa fa-files-o"></i> <span>Waiting List</span></a></li>
        <li><a href="app/pengembangan"><i class="fa fa-image"></i> <span>Laporan</span></a></li>

        <li class="header">MENU KHUSUS BAR</li>
        
        <li><a href="app/pengembangan"><i class="fa fa-clone"></i> <span>Semua Meja</span></a></li>
        <li><a href="app/pengembangan"><i class="fa fa-pencil"></i> <span>Order Makanan & Minuman</span></a></li>
        <li><a href="app/pengembangan"><i class="fa fa-quote-left"></i> <span>Data Makanan & Minuman</span></a></li>

        <li class="header">MENU KHUSUS INVENTORY</li>
        
        <li><a href="app/pengembangan"><i class="fa fa-clone"></i> <span>Pembelian Barang</span></a></li>
        <li><a href="app/pengembangan"><i class="fa fa-pencil"></i> <span>Stok Makanan & Minuman</span></a></li>
        <li><a href="app/pengembangan"><i class="fa fa-quote-left"></i> <span>History Stok</span></a></li>
        <li><a href="app/pengembangan"><i class="fa fa-quote-left"></i> <span>Laporan</span></a></li>

        <li><a href="app/pengembangan"><i class="fa fa-clone"></i> <span>Harga Perjam</span></a></li>
        <li><a href="a_user"><i class="fa fa-users"></i> <span>Manajemen User</span></a></li>


        <?php } else {
          ?>
          
          <?php
        } ?>
        <!-- <li class="header">LABELS</li>
        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Faqs</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Tentang Aplikasi</span></a></li> -->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>