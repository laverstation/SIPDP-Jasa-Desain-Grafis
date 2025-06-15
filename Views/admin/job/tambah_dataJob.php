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
		<form method="POST" action="<?php echo base_url('admin/data_job/tambah_data_aksi') ?>" enctype="multipart/form-data">

			<div class="form-group">
				<label>Kategori</label>
				<select name="id_jabatan" id="id_jabatan" class="form-control">
					<option value="">--Pilih Kategori--</option>
					<?php foreach ($id_jabatan as $j) : ?>
						<option value="<?php echo $j->id_jabatan ?>"><?php echo $j->jabatan ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<!-- jika  kategori = 1 (animator) munculkan daftar pegawai hanya yang jabatannya animator -->
			<div class="form-group">
				<label>Pegawai</label>
				<select name="id_pegawai" id="id_pegawai" class="form-control">
					<?php foreach ($id_pegawai as $j) : ?>
						<option value="<?php echo $j->id_pegawai; ?>"><?php echo $j->nama_pegawai; ?></option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="form-group">
				<label>Detail</label>
				<textarea class="form-control" name="detail_job" id="exampleFormControlTextarea1" rows="5"></textarea>
			</div>

			<div class="form-group">
				<label>Harga</label>
				<input type="number" name="harga_job" class="form-control">
			</div>

			<div class="form-group">
				<label>Tanggal Deadline</label>
				<input type="date" name="tgl_deadline" class="form-control">
			</div>


			<button type="submit" class="btn btn-success">Simpan</button>
			<button type="reset" class="btn btn-danger">Reset</button>
			<a href="<?php echo base_url('admin/data_job') ?>" class="btn btn-warning">Kembali</a>

		</form>
	</div>
	<script>
		const idJabatanSelect = document.getElementById('id_jabatan');
		const idPegawaiSelect = document.getElementById('id_pegawai');
		// Assuming you have passed the PHP data to JavaScript as a JSON variable

		const pegawaiData = <?= json_encode($id_pegawai) ?>;
		console.log(pegawaiData);
		// Function to filter and populate options for id_pegawai based on the selected id_jabatan
		function populateIdPegawai() {
			const selectedIdJabatan = idJabatanSelect.value;
			console.log(selectedIdJabatan);
			// Filter the data for id_pegawai based on the selected id_jabatan
			const filteredData = pegawaiData.filter(pegawai => pegawai.id_jabatan === selectedIdJabatan);

			// Clear existing options
			idPegawaiSelect.innerHTML = "";

			// Populate the new options for id_pegawai
			filteredData.forEach(pegawai => {
				const optionElement = document.createElement('option');
				optionElement.value = pegawai.id_pegawai; // Set the value of the option
				optionElement.textContent = pegawai.nama_pegawai; // Set the label of the option
				idPegawaiSelect.appendChild(optionElement);
			});
		}

		// Add an event listener to update id_pegawai when id_jabatan is changed
		idJabatanSelect.addEventListener('change', populateIdPegawai);

		// Call the function initially to populate id_pegawai for the default selected id_jabatan
		populateIdPegawai();
	</script>
</div>