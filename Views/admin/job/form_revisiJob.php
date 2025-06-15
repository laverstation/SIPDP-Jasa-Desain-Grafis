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
		<?php foreach ($job as $j) : ?>
			<form method="POST" action="<?php echo base_url('admin/data_job/form_revisi_aksi') ?>" enctype="multipart/form-data">

				<div class="form-group">
					<label>Detail Job</label>
					<input type="hidden" name="id_job" class="form-control" value="<?php echo $j->id_job ?>">
					<input type="hidden" name="id_jabatan" class="form-control" value="<?php echo $j->id_jabatan ?>">
					<input type="hidden" name="id_pegawai" class="form-control" value="<?php echo $j->id_pegawai ?>">
					<input type="hidden" name="harga_job" class="form-control" value="<?php echo $j->harga_job ?>">
					<input type="hidden" name="tgl_deadline" class="form-control" value="<?php echo $j->tgl_deadline ?>">
					<textarea class="form-control" name="detail_job" id="exampleFormControlTextarea1" rows="5"><?php echo $j->detail_job ?></textarea>
				</div>
				<div class="form-group">
					<label>Detail Revisi</label>
					<textarea class="form-control" name="detail_revisi" id="exampleFormControlTextarea1" rows="5"><?php echo $j->detail_revisi ?></textarea>
				</div>
				<button type="submit" class="btn btn-success">Simpan</button>
				<button type="reset" class="btn btn-danger">Reset</button>
				<a href="<?php echo base_url('admin/data_job') ?>" class="btn btn-warning">Kembali</a>
			</form>
		<?php endforeach; ?>
	</div>