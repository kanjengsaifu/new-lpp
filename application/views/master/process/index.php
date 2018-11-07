	<br>
	<div class="table-title">
		<h3>Daftar Proses <a href="#" class="btn btn-sm btn-primary" id="btnAdd">Tambah Baru</a></h3>
	</div>
	<div class="alert alert-success alert-float" style="display: none;"></div>
	<br>

    <div class="table-responsive-md table-font-small">
        <table id="datatable"  class="table table-hover table-sm" style="margin-top: 20px;">
            <thead class="thead-light">
                <tr>
                    <!-- <th>ID</th> -->
                    <th>Kode Proses</th>
                    <th>Nama Proses</th>
                    <th>Alias</th>
                    <th>Dibuat</th>
                    <th width="100px;">Action</th>
                </tr>
            </thead>
        </table>
		<br>
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
					<label for="kode_proses" class="col-form-label">Kode Proses:</label>
					<input type="number" step="any" class="form-control" id="kode_proses" name="kode_proses">
        		</div>
        		<div class="form-group">
					<label for="nama_proses" class="col-form-label">Nama Proses:</label>
					<input type="text" class="form-control" id="nama_proses" name="nama_proses">
        		</div>
                <div class="form-group">
					<label for="alias" class="col-form-label">Alias:</label>
					<input type="text" class="form-control" id="alias" name="alias">
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
			Hapus Proses?
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
                "url": "<?php echo base_url() ?>process/fetch",
                "type": "POST"
			},
			columnDefs: [{
				"targets":[3,4],
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
			$('#myModal').find('.modal-title').text('Tambah Proses');
			$('#myForm').attr('action', '<?php echo base_url() ?>process/addProcess'); // langsung panggil controller
			// clear error first
			$('#myForm input').removeClass('is-invalid');
		});

		$('#btnSave').click(function(){
			var url = $('#myForm').attr('action');
			var data = $('#myForm').serialize();
			//validate form
			var kode_proses = $('input[name=kode_proses]');
			var nama_proses = $('input[name=nama_proses]');
			var alias = $('input[name=alias]');
			var result = '';

			if(nama_proses.val()==''){
				nama_proses.addClass('is-invalid');
			}else{
				nama_proses.removeClass('is-invalid');
				result +='1';
			}

            if(kode_proses.val()==''){
				kode_proses.addClass('is-invalid');
			}else{
				kode_proses.removeClass('is-invalid');
				result +='2';
			}

             if(alias.val()==''){
				alias.addClass('is-invalid');
			}else{
				alias.removeClass('is-invalid');
				result +='3';
			}

			if(result=='123'){
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
							$('.alert-success').html('Proses berhasil di '+type).fadeIn().delay(4000).fadeOut('slow');
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
		$('#datatable').on('click', '.item-edit', function(e){
			e.preventDefault();
			var id = $(this).attr('data');
			$('#myModal').modal('show');
			$('#myModal').find('.modal-title').text('Ubah Proses');
			$('#myForm').attr('action', '<?php echo base_url() ?>process/updateProcess'); // langsung panggil controller
			$.ajax({
				type: 'ajax',
				method: 'get',
				url: '<?php echo base_url() ?>process/editProcess', // langsung panggil controller
				data: {id: id},
				async: false,
				dataType: 'json',
				success: function(data){
					// console.log(data);
					$('input[name=txtId]').val(data.id);
					$('input[name=nama_proses]').val(data.name);
					$('input[name=kode_proses]').val(data.kode_proses);
					$('input[name=alias]').val(data.alias);
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
					url: '<?php echo base_url() ?>process/deleteProcess', // langsung panggil controller
					data:{id:id},
					dataType: 'json',
					success: function(response){
						if(response.success){
							$('#deleteModal').modal('hide');
							$('.alert-success').html('Proses berhasil dihapus').fadeIn().delay(4000).fadeOut('slow');
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