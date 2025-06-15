<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
	</div>
	<?= session()->getFlashdata('pesan') ?>

	<div class="card mb-3">
		<div class="card-header bg-primary text-white">
			Filter Data Job
		</div>
		<div class="card-body">
			<form class="form-inline">
				<div class="form-group mb-2">
					<label for="filter-jabatan">Kategori</label>
					<select id="filter-jabatan" class="form-control ml-3">
						<option value=""> Pilih Kategori </option>
						<?php
						$processedJabatan = array();
						foreach ($job as $j) : ?>
							<?php if (!isset($processedJabatan[$j->jabatan])) : ?>
								<option value="<?php echo $j->jabatan ?>"><?php echo $j->jabatan ?></option>
								<?php $processedJabatan[$j->jabatan] = true; ?>
							<?php endif; ?>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group mb-2 ml-5">
					<label for="filter-status">Status</label>
					<select class="form-control ml-3" id="filter-status">
						<option value=""> Pilih Status </option>
						<?php
						$processedStatus = array();
						foreach ($job as $j) :
						?>
							<?php if (!isset($processedStatus[$j->status])) : ?>
								<option value="<?php echo $j->status ?>"><?php echo $j->status ?></option>
								<?php $processedStatus[$j->status] = true; ?>
							<?php endif; ?>
						<?php endforeach; ?>
					</select>
				</div>
				<a href="<?php echo base_url('admin/data_job/tambah_data') ?>" class="btn btn-success mb-2 ml-auto"><i class="fas fa-plus"></i> Tambah Job</a>
			</form>
		</div>
	</div>
</div>
<div class="container-fluid">
	<div class="card shadow mb-4">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTableJob" width="100%" cellspacing="0">
					<thead class="thead-dark">
						<tr>
							<th class="text-center">No</th>
							<th class="text-center">Kategori</th>
							<th class="text-center">Nama Pegawai</th>
							<th class="text-center">Detail</th>
							<th class="text-center">Harga</th>
							<th class="text-center">Tanggal Mulai</th>
							<th class="text-center">Deadline</th>
							<th class="text-center">Desain</th>
							<th class="text-center">Revisi</th>
							<th class="text-center">Status</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($job as $j) : ?>
							<tr>
								<td class="text-center"><?php echo $no++ ?></td>
								<td class="text-center"><?php echo $j->jabatan ?></td>
								<td class="text-center"><?php echo $j->nama_pegawai ?></td>
								<td class="text-center"><?php echo $j->detail_job ?></td>
								<td class="text-center"><?php echo $j->harga_job ?></td>
								<td class="text-center"><?php echo $j->tgl_mulai ?></td>
								<td class="text-center"><?php echo $j->tgl_deadline ?></td>
								<td class="text-center"><?php
														if ($j->desain) {
														?>
										<a href="<?php echo base_url('uploads/') . $j->desain ?>">
											<?php echo  $j->desain ?>
										</a>
									<?php
														} else {

									?>
										<form method="POST" action="<?php echo base_url('admin/data_job/upload_process_design') ?>" enctype="multipart/form-data">
										</form>
									<?php
														} ?>
								</td>
								<td class="text-center"><?php
														if ($j->revisi) {
														?>
										<a href="<?php echo base_url('uploads/') . $j->revisi ?>">
											<?php echo  $j->revisi ?>
										</a>
									<?php
														} else {

									?>
										<form method="POST" action="<?php echo base_url('admin/data_job/upload_process_revisi') ?>" enctype="multipart/form-data">
										</form>
									<?php
														} ?>
								</td>
								<td class="text-center"><?php echo $j->status ?></td>
								<td>
									<center>
										<form method="POST" action="<?php echo base_url('admin/data_job/update_status') ?>" enctype="multipart/form-data">
											<input type="hidden" name="id_job" class="form-control" value="<?php echo $j->id_job ?>">
											<select name="status" id="status">
												<option value="<?php echo $j->status ?>" selected><?php echo $j->status ?></option>
												<option value="Selesai">Selesai</option>
												<option value="Revisi">Revisi</option>
												<option value="On Deadline">On Deadline</option>
											</select>
											<button type="submit" class="btn btn-success">Simpan</button>
										</form>
										<a class="btn btn-warning" href="<?php echo base_url('admin/data_job/form_revisi/' . $j->id_job) ?>">Input</a>
										<a onclick="return confirm('Yakin Hapus?')" class="btn btn-danger" href="<?php echo base_url('admin/data_job/delete_data/' . $j->id_job) ?>">Hapus</i></a>
									</center>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>