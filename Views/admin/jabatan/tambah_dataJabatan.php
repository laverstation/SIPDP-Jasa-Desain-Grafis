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
		<form method="POST" action="<?php echo base_url('admin/data_jabatan/tambah_data_aksi') ?>">

			<div class="form-group">
				<label>Jabatan</label>
				<input type="text" name="jabatan" class="form-control">
			</div>



			<button type="submit" class="btn btn-success">Simpan</button>
			<button type="reset" class="btn btn-danger">Reset</button>
			<a href="<?php echo base_url('admin/data_jabatan') ?>" class="btn btn-warning">Kembali</a>
		</form>
	</div>
</div>