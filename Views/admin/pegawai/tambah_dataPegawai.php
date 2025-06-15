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
		<form method="POST" action="<?php echo base_url('admin/data_pegawai/tambah_data_aksi') ?>" enctype="multipart/form-data">

			<div class="form-group">
				<label>NIP</label>
				<input type="number" name="nip" class="form-control">

			</div>

			<div class="form-group">
				<label>Nama Pegawai</label>
				<input type="text" name="nama_pegawai" class="form-control">

			</div>

			<div class="form-group">
				<label>Username</label>
				<input type="text" name="username" class="form-control">

			</div>

			<div class="form-group">
				<label>Password</label>
				<input type="password" name="password" class="form-control">

			</div>

			<div class="form-group">
				<label>Jenis Kelamin</label>
				<select name="jenis_kelamin" class="form-control">
					<option value="">--Pilih Jenis Kelamin--</option>
					<option value="Laki - Laki">Laki-Laki</option>
					<option value="Perempuan">Perempuan</option>
				</select>

			</div>

			<div class="form-group">
				<label>Jabatan</label>
				<select name="id_jabatan" class="form-control">
					<option value="">--Pilih Jabatan--</option>
					<?php foreach ($id_jabatan as $j) : ?>
						<option value="<?php echo $j->id_jabatan ?>"><?php echo $j->jabatan ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="form-group">
				<label>Tanggal Masuk</label>
				<input type="date" name="tanggal_masuk" class="form-control">

			</div>

			<div class="form-group">
				<label>Kontrak</label>
				<select name="kontrak" class="form-control">
					<option value="">--Pilih Kontrak--</option>
					<option value="Karyawan Tetap">Karyawan Tetap</option>
					<option value="Freelancer">Freelancer</option>
				</select>

			</div>

			<div class="form-group">
				<label>Hak Akses</label>
				<select name="id_hak" class="form-control">
					<option value="">--Pilih Hak Akses--</option>
					<option value="1">Admin</option>
					<option value="2">Pegawai</option>
				</select>
			</div>

			<div class="form-group">
				<label>Photo</label>
				<input type="file" name="photo" class="form-control">
			</div>


			<button type="submit" class="btn btn-success">Simpan</button>
			<button type="reset" class="btn btn-danger">Reset</button>
			<a href="<?php echo base_url('admin/data_pegawai') ?>" class="btn btn-warning">Kembali</a>

		</form>
	</div>
</div>