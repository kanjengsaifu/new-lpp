	<br>
	<div class="table-title">
		<h3>Daftar Parts <a href="#" class="btn btn-sm btn-primary" id="btnAdd">Tambah Baru</a></h3>
	</div>
	<div class="alert alert-success alert-float" style="display: none;"></div>

    <div class="table-responsive-md table-font-small">
        <table id="datatable" class="table table-hover table-sm" style="margin-top: 20px;">
            <thead class="thead-light">
                <tr>
					<!-- <th>ID</th> -->
                    <th>Kode Part</th>
                    <th>Nama Part</th>
                    <th>Kode SPK</th>
                    <th>Kategori Part</th>
                    <th>Konversi</th>
                    <th>Dibuat</th>
                    <th width="100px;">Action</th>
                </tr>
            </thead>
			<br>
        </table>
    </div>

<div id="myModal" class="modal fade" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
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
                <div class="form-group">
					<label for="part_kode" class="col-form-label">Kode Part:</label>
					<input type="text" class="form-control" id="part_kode" name="part_kode">
        		</div>
        		<div class="form-group">
					<label for="part_name" class="col-form-label">Nama Part:</label>
					<input type="text" class="form-control" id="part_name" name="part_name">
        		</div>
				<div class="form-group">
				    <label class="col-form-label">Kategori:</label>
					<select class="custom-select" id="partcategory_id" name="partcategory_id">
						<?php
						foreach($profile_partcategory as $row) {
							echo '<option value="'.$row->id.'">'.$row->partcategory_alias . " - " . $row->partcategory_name.'</option>';
						}
						?>
					</select>
				</div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="spk_kode" class="col-form-label">Kode SPK:</label>
                            <input type="number" class="form-control" id="spk_kode" name="spk_kode">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="conversion" class="col-form-label">Kilogram / Pcs:</label>
                            <input type="number" step="any" class="form-control" id="conversion" name="conversion">
                        </div>
                    </div>
                </div>
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
			Hapus Part?
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
			<button type="button" id="btnDelete" class="btn btn-danger">Hapus</button>
		</div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
	$(function(){
		var dtable = $('#datatable').DataTable({
			dom: 'Bfrtip',
			buttons: [{
				extend: "excelHtml5",
				className: "btn-sm btn-success",
				titleAttr: 'Export to Excel',
				text: 'Export to Excel',
				exportOptions: {
                    columns: 'th:not(:last-child)'
                }
			}],
			// responsive: true,
			fixedHeader: {},
			processing: true,
			serverSide: true,
			ajax: {
                "url": "<?php echo base_url() ?>parts/fetch",
                "type": "POST"
			},
			columnDefs: [{
				"targets":[2,4,5,6],
				"orderable":false,
			}]
		});

		function refreshDtTable(){
			dtable.ajax.reload();
		}

		// Grab the datatables input box and alter how it is bound to events
		$(".dataTables_filter input")
			.unbind() // Unbind previous default bindings
			.bind("input", function(e) { // Bind our desired behavior
				// If the length is 3 or more characters, or the user pressed ENTER, search
				if(this.value.length >= 3 || e.keyCode == 13) {
					// Call the API search function
					dtable.search(this.value).draw();
				}
				// Ensure we clear the search if they backspace far enough
				if(this.value == "") {
					dtable.search("").draw();
				}
				return;
			});

		//Add New
		$('#btnAdd').click(function(){
			// reset first
			$('#myForm')[0].reset();

			$('#myModal').modal('show');
			$('#myModal').find('.modal-title').text('Tambah Part');
			$('#myForm').attr('action', '<?php echo base_url() ?>parts/addPart'); // langsung panggil controller
			// clear error first
			$('#myForm input').removeClass('is-invalid');
		});

		$('#btnSave').click(function(){
			var url = $('#myForm').attr('action');
			var data = $('#myForm').serialize();
			//validate form
			var part_name = $('input[name=part_name]');
			var part_kode = $('input[name=part_kode]');
			var spk_kode = $('input[name=spk_kode]');
			var conversion = $('input[name=conversion]');
			var result = '';

			if(part_name.val()==''){
				part_name.addClass('is-invalid');
			}else{
				part_name.removeClass('is-invalid');
				result +='1';
			}

			if(part_kode.val()==''){
				part_kode.addClass('is-invalid');
			}else{
				part_kode.removeClass('is-invalid');
				result +='2';
			}

            if(spk_kode.val()==''){
				spk_kode.addClass('is-invalid');
			}else{
				spk_kode.removeClass('is-invalid');
				result +='3';
			}

            if(conversion.val()==''){
				conversion.addClass('is-invalid');
			}else{
				conversion.removeClass('is-invalid');
				result +='4';
			}
            // End of validation

			if(result=='1234'){
				$.ajax({
					type: 'ajax',
					method: 'post',
					url: url,
					data: data,
					async: false,
					dataType: 'json',
					success: function(response){
						if(response.success){
							$('#myModal').modal('hide');
							$('#myForm')[0].reset();
							if(response.type=='add'){
								var type = 'tambahkan'
							}else if(response.type=='update'){
								var type ="perbarui"
							}
							$('.alert-success').html('Part berhasil di '+type).fadeIn().delay(4000).fadeOut('slow');
							refreshDtTable();
						}else{
							alert('Error');
						}
					},
					error: function(){
						alert('Tidak bisa menyimpan data');
					}
				});
			}
		});

		//edit
		$('#datatable').on('click', '.item-edit', function(){
			var id = $(this).attr('data');
			$('#myModal').modal('show');
			$('#myModal').find('.modal-title').text('Ubah Part');
			$('#myForm').attr('action', '<?php echo base_url() ?>parts/updatePart'); // langsung panggil controller
			$.ajax({
				type: 'ajax',
				method: 'get',
				url: '<?php echo base_url() ?>parts/editPart', // langsung panggil controller
				data: {id: id},
				async: false,
				dataType: 'json',
				success: function(data){
					// console.log(data);
					$('input[name=txtId]').val(data.id);
                    $('input[name=part_name]').val(data.part_name);
                    $('input[name=part_kode]').val(data.part_kode);
                    $('input[name=spk_kode]').val(data.spk_kode);
					$('input[name=conversion]').val(data.conversion);
					$("#partcategory_id").val(data.id_partcategory);
				},
				error: function(){
					alert('Tidak bisa mengubah data');
				}
			});
		});

		//delete-
		$('#datatable').on('click', '.item-delete', function(e){
			e.preventDefault();
			var id = $(this).attr('data');
			$('#deleteModal').modal('show');
			//prevent previous handler - unbind()
			$('#btnDelete').unbind().click(function(){
				$.ajax({
					type: 'ajax',
					method: 'get',
					async: false,
					url: '<?php echo base_url() ?>parts/deletePart', // langsung panggil controller
					data:{id:id},
					dataType: 'json',
					success: function(response){
						if(response.success){
							$('#deleteModal').modal('hide');
							$('.alert-success').html('Part berhasil dihapus').fadeIn().delay(4000).fadeOut('slow');
							refreshDtTable();
						}else{
							alert('Error');
						}
					},
					error: function(){
						alert('Tidak bisa di delete');
					}
				});
			});
		});

	});
</script>