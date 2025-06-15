<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
	</div>
	<?php if (session()->has('errors')) : ?>
		<div class="alert alert-danger alert-dismissible fade show" role="alert">
			<strong>Ada kesalahan dalam mengisi form:</strong>
			<ul>
				<?php foreach (session('errors') as $error) : ?>
					<li><?= esc($error) ?></li>
				<?php endforeach; ?>
			</ul>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
	<?php endif; ?>

</div>
<!-- /.container-fluid -->

<div class="card" style="width: 60% ; margin-bottom: 100px">
	<div class="card-body">
		<?php foreach ($pegawai as $p) : ?>
			<form method="POST" action="<?php echo base_url('admin/data_pegawai/update_data_aksi') ?>" enctype="multipart/form-data">

				<div class="form-group">
					<label>NIP</label>
					<input type="hidden" name="id_pegawai" class="form-control" value="<?php echo $p->id_pegawai ?>">
					<input type="number" name="nip" class="form-control" value="<?php echo $p->nip ?>">

				</div>

				<div class="form-group">
					<label>Nama Pegawai</label>
					<input type="text" name="nama_pegawai" class="form-control" value="<?php echo $p->nama_pegawai ?>">

				</div>

				<div class="form-group">
					<label>Username</label>
					<input type="text" name="username" class="form-control" value="<?php echo $p->username ?>">

				</div>

				<div class="form-group">
					<label>Password</label>
					<input type="password" name="password" class="form-control" value="">

				</div>

				<div class="form-group">
					<label>Jenis Kelamin</label>
					<select name="jenis_kelamin" class="form-control" value="<?php echo $p->id_pegawai ?>">
						<option value="<?php echo $p->jenis_kelamin ?>"><?php echo $p->jenis_kelamin ?></option>
						<option value="Laki-Laki">Laki-Laki</option>
						<option value="Perempuan">Perempuan</option>
					</select>

				</div>

				<div class="form-group">
					<label>Jabatan</label>
					<select name="id_jabatan" class="form-control">
						<?php foreach ($id_jabatan as $j) :
							if ($p->id_jabatan == $j->id_jabatan) {
						?>
								<option value="<?php echo $j->id_jabatan ?>" selected><?php echo $j->jabatan ?></option>
							<?php
							} else {
							?>
								<option value="<?php echo $j->id_jabatan ?>"><?php echo $j->jabatan ?></option>
						<?php }
						endforeach; ?>
					</select>
				</div>

				<div class="form-group">
					<label>Tanggal Masuk</label>
					<input type="date" name="tanggal_masuk" class="form-control" value="<?php echo $p->tanggal_masuk ?>">

				</div>

				<div class="form-group">
					<label>Kontrak</label>
					<select name="kontrak" class="form-control">
						<option value="<?php echo $p->kontrak ?>"><?php echo $p->kontrak ?></option>
						<option value="Karyawan Tetap">Karyawan Tetap</option>
						<option value="Freelancer">Freelancer</option>
					</select>

				</div>

				<div class="form-group">
					<label>Hak Akses</label>
					<select name="id_hak" class="form-control">
						<option value="<?php echo $p->id_hak ?>">
							<?php if ($p->id_hak == '1') {
								echo "Admin";
							} else {
								echo "Pegawai";
							} ?>
						</option>
						<option value="1">Admin</option>
						<option value="2">Pegawai</option>
					</select>
				</div>

				<div class="form-group">
					<label>Photo</label>
					<input type="file" name="photo" class="form-control">
				</div>

				<button type="submit" class="btn btn-success">Simpan</button>
				<a href="<?php echo base_url('admin/data_pegawai') ?>" class="btn btn-warning">Kembali</a>

			</form>
		<?php endforeach; ?>
	</div>
</div>