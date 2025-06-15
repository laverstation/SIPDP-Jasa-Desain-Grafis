<div class="container-fluid">
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800"><?php echo $title ?></h1>
		<?= session()->getFlashdata('pesan') ?>
	</div>
</div>

<div class="container-fluid">
	<div class="card shadow mb-4">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
					<thead class="thead-dark">
						<tr>
							<th class="text-center">No</th>
							<th class="text-center">Tanggal Mulai</th>
							<th class="text-center">Detail Job</th>
							<th class="text-center">Deadline</th>
							<th class="text-center">Desain</th>
						</tr>
					</thead>
					<tbody>
						<?php $no = 1;
						foreach ($job as $j) : ?>
							<tr>
								<td class="text-center"><?php echo $no++ ?></td>
								<td class="text-center"><?php echo $j->tgl_mulai ?></td>
								<td class="text-center"><?php echo $j->detail_job ?></td>
								<td class="text-center"><?php echo $j->tgl_deadline ?></td>
								<td class="text-center">
									<?php
									if ($j->desain) {
									?>
										<a href="<?php echo base_url('uploads/') . $j->desain ?>">
											<?php echo  $j->desain ?>
										</a>
									<?php
									} else {

									?>
										<form method="POST" action="<?php echo base_url('pegawai/job/upload_process') ?>" enctype="multipart/form-data">
											<input type="hidden" name="id_job" class="form-control" value="<?php echo $j->id_job ?>">
											<input type="file" name="file" id="file">
											<button type="submit" class="btn btn-success">Simpan</button>

										</form>
									<?php
									} ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>