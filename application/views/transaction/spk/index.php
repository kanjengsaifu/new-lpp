<br>
	<div class="table-title">
		<h3>Daftar SPK <a href="#" class="btn btn-sm btn-primary" id="btnAdd">Tambah Baru</a></h3>
	</div>
	<div class="alert alert-success alert-float" style="display: none;"></div>
	<br>

    <div class="table-responsive-md table-font-small">
        <table id="datatable" class="table table-hover table-sm" style="margin-top: 20px;">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>No. SPK</th>
                    <th>SPK Mulai</th>
                    <th>SPK Akhir</th>
                    <th>SPK Tutup</th>
                    <th>Pelanggan</th>
                    <th>Nama Part</th>
                    <th>SPK Status</th>
                    <th width="100px;">Action</th>
                </tr>
            </thead>
        </table>
    </div>

<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
	  	<h5 class="modal-title">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        	<form id="myForm" action="" method="post" class="form-horizontal">
        		<input type="hidden" name="txtId" value="0">

				<div class="row">
					<!-- Kolom Left -->
					<div class="col-6">
						<div class="row">
							<div class="col-6">
								<div class="form-group">
									<label for="spk_no" class="col-form-label">Nomor SPK:</label>
									<input type="text" class="form-control" id="spk_no" name="spk_no" readonly>
									<small class="text-muted">
										* Otomatis setelah SPK tersimpan
									</small>
								</div>
							</div>
							<div class="col-6">
								<div class="form-group">
									<label for="spk_status" class="col-form-label">SPK Status:</label>
									<input type="text" class="form-control" id="spk_status" name="spk_status" readonly>
								</div>
							</div>

							<div class="col-12">
								<div class="form-group">
									<label class="col-form-label">Pilih Pelanggan:</label>
									<select class="custom-select" id="id_customer" name="id_customer">
										<?php
										foreach($active_customer as $customer) {
											echo '<option value="'.$customer->id.'">'.$customer->name.'</option>';
										}
										?>
									</select>
								</div>
							</div>

							<div class="col-12">
								<div class="form-group">
									<label for="spk_co_number" class="col-form-label">Nomor Order Pelanggan:</label>
									<input type="text" class="form-control" id="spk_co_number" name="spk_co_number">
									<small class="text-muted">
										* Tulis CO Customer jika ini pesanan Customer, contoh: OSP1810102
									</small>
								</div>
							</div>

							<div class="col-12">

								<div class="alert alert-secondary" role="alert">

									<div class="form-group">
										<label class="col-form-label">Pilih Bahan Baku:</label>
										<select class="custom-select" id="id_material" name="id_material">
											<?php
											foreach($active_material as $material) {
												echo '<option value="'.$material->id.'">'. $material->material_kode . " - " . $material->name.'</option>';
											}
											?>
										</select>
									</div>

									<div class="row">

										<div class="col-6">
											<div class="form-group">
												<label for="qty_m_base" class="col-form-label">Jumlah Bahan Baku:</label>
												<input type="number" steps="any" class="form-control" id="qty_m_base" name="qty_m_base">
											</div>
										</div>

										<div class="col-6">
											<div class="form-group">
												<label class="col-form-label">Satuan:</label>
												<select class="custom-select" id="id_uom_base" name="id_uom_base">
													<?php
													foreach($active_uom as $uom) {
														if ( $uom->id == 3 ) { // satuan batang otomatis terpilih
															echo '<option value="'.$uom->id.'" selected="selected">'.$uom->uom. " - " . $uom->uom_description .'</option>';
														} else {
															echo '<option value="'.$uom->id.'">'.$uom->uom. " - " . $uom->uom_description .'</option>';
														}
													}
													?>
												</select>
											</div>
										</div>

									</div>

									<div class="row">
										<div class="col-6">
											<div class="form-group">
												<label for="qty_m_convert" class="col-form-label">Jumlah Bahan Baku (KG):</label>
												<input type="number" steps=".01" class="form-control" id="qty_m_convert" name="qty_m_convert" readonly>
												<small class="text-muted">
													* Otomatis terhitung
												</small>
											</div>
										</div>

										<div class="col-6">
											<div class="form-group">
												<label class="col-form-label">Satuan dalam KG:</label>
												<select class="custom-select" id="id_uom_convert" name="id_uom_convert" readonly>
													<option value="2" selected>KG - Kilogram</option>
												</select>
											</div>
										</div>
									</div>

								</div>

							</div>

						</div>
					</div>
					<!-- Kolom Left Akhir -->

					<!-- Kolom Right -->
					<div class="col-6">

						<div class="row">
							<div class="col-6">
								<div class="form-group">
									<label for="created_at" class="col-form-label">SPK Dibuat:</label>
									<input type="date" class="form-control" id="created_at" name="created_at" readonly>
									<small class="text-muted">
										* Tanggal SPK dibuat
									</small>
								</div>
							</div>

							<div class="col-6">
								<div class="form-group">
									<label for="spk_closed" class="col-form-label">SPK Tutup:</label>
									<input type="date" class="form-control" id="spk_closed" name="spk_closed" readonly>
									<small class="text-muted">
										* Otomatis pada saat SPK tutup
									</small>
								</div>
							</div>

							<div class="col-6">
								<div class="form-group">
									<label for="spk_start" class="col-form-label">SPK Mulai:</label>
									<input type="date" class="form-control" id="spk_start" name="spk_start">
								</div>
							</div>

							<div class="col-6">
								<div class="form-group">
									<label for="spk_end" class="col-form-label">SPK Akhir:</label>
									<input type="date" class="form-control" id="spk_end" name="spk_end">
								</div>
							</div>

						</div>

						<div class="form-group">
							<label for="spk_rework" class="col-form-label">Nomor SPK Rework:</label>
							<input type="text" class="form-control" id="spk_rework" name="spk_rework">
							<small class="text-muted">
								* Tulis nomor SPK sebelumnya dengan lengkap untuk referensi.
							</small>
						</div>

						<div class="alert alert-secondary" role="alert">

							<div class="form-group">
								<label class="col-form-label">Pilih Part:</label>
								<select class="custom-select" id="id_part" name="id_part">
									<?php
									foreach($active_part as $part) {
										echo '<option value="'.$part->id.'">'.$part->part_kode . " - " . $part->part_name .'</option>';
									}
									?>
								</select>
							</div>

							<div class="row">
								<div class="col-6">
									<div class="form-group">
										<label for="qty_part" class="col-form-label">Jumlah Part (dalam Pcs):</label>
										<input type="number" steps="any" class="form-control" id="qty_part" name="qty_part">
									</div>
								</div>

								<div class="col-6">
									<div class="form-group">
										<label class="col-form-label">Satuan dalam Pcs:</label>
										<select class="custom-select" id="id_uom_part" name="id_uom_part">
											<option value="1" selected>PCS - Pieces</option>
										</select>
									</div>
								</div>
							</div>

						</div>

					</div>
					<!-- Kolom Kanan Akhir -->

					<div class="col-12">
						<div class="form-group">
							<label for="spk_notes">Note:</label>
							<textarea id="spk_notes" class="form-control" rows="3" name="spk_notes"></textarea>
						</div>
					</div>
				</div><!-- .row -->

        	</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        <button type="button" id="btnSave" class="btn btn-primary">Simpan</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div id="deleteModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title">Peringatan</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			Hapus SPK?
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
			<button type="button" id="btnDelete" class="btn btn-danger">Hapus</button>
		</div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->