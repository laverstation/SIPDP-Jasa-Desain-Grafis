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
	<div class="card" style="width: 40%">
		<div class="card-body">
			<form method="POST" action="<?php echo base_url('ganti_password/ganti_password_aksi') ?>">

				<div class="form-grup">
					<label>Password Baru</label>
					<input type="password" name="passBaru" class="form-control">

				</div>

				<div class="form-grup">
					<label>Ulangi Password Baru</label>
					<input type="password" name="ulangPass" class="form-control">

				</div>
				<br>
				<button type="submit" class="btn btn-success">Simpan</button>
			</form>
		</div>
	</div>

</div>