<script>
    $(function(){

        // initial value
        var materialDetail = {};

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
                "url": "<?php echo base_url() ?>spks/fetch",
                "type": "POST"
			},
			columnDefs: [{
				"targets":[-1, -2],
				"orderable":false,
			}],
            order: [
                [ 0, 'desc' ]
            ]
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
            $("input").prop("disabled", false);
            $("select").prop("disabled", false);
            $("textarea").prop("disabled", false);

            // Set default value first
            $('#spk_status').val("Mulai"); // 0 = Mulai, 1 = Dalam Proses, 2 = Selesai

            var today = moment().format('YYYY-MM-DD');
            $('#created_at').val(today);
            $('#spk_start').val(today);
            $('#spk_end').val(today);
            // End set default value

            /* get detail */
            var idMaterial = $('#id_material');
            var rawMaterialQty = $('#qty_m_base');

            // Get initial value first
            getMaterialDetail(idMaterial.val());
            // get value again when change
            idMaterial.on('change', function(){
                getMaterialDetail(idMaterial.val());
                reCalcMaterialConvert(idMaterial.val());
            });

            rawMaterialQty.on('change', function(){
                reCalcMaterialConvert(idMaterial.val());
            });
            /* End of get detail */

            $('#myModal').modal('show');
            $('#myModal').find('.modal-title').text('Buat SPK');
            $('#myForm').attr('action', '<?php echo base_url() ?>spks/addSpk'); // langsung panggil controller
            // clear error first
            $('#myForm input').removeClass('is-invalid');
        });

        function reCalcMaterialConvert(idMaterial){
            // console.log(materialDetail[idMaterial].conversion);
            rawMaterialConvert = $('#qty_m_base').val() * parseFloat(materialDetail[idMaterial].conversion);
            $('#qty_m_convert').val(rawMaterialConvert);
        }

        function getMaterialDetail(id){
            for (key in materialDetail) {
                // jika sudah dipanggil material id nya tidak us panggil lagi biar cepet
                if (materialDetail.hasOwnProperty(id)) {
                    return false;
                }
            }

            $.ajax({
                type: 'ajax',
                // parameter passed -> limit-offset
                url: '<?php echo base_url() ?>materials/getMaterialByID/' + id,
                async: false,
                dataType: 'json',
                success: function(data){
                    if ( data == false ) {
                        return false;
                    }

                    // save to variable
                    materialDetail[id] = data[0];
                    return false;
                },
                error: function(){
                    alert('Tidak ada data di database!');
                }
            });
        }

        $('#btnSave').click(function(){
            var url = $('#myForm').attr('action');
            var data = $('#myForm').serialize();
            //validate form
            var spk_start = $('input[name=spk_start]');
            var spk_end = $('input[name=spk_end]');
            var qty_m_base = $('input[name=qty_m_base]');
            var qty_part = $('input[name=qty_part]');
            var result = '';

            if(spk_start.val()==''){
                spk_start.addClass('is-invalid');
            }else{
                spk_start.removeClass('is-invalid');
                result +='1';
            }

            if(spk_end.val()==''){
                spk_end.addClass('is-invalid');
            }else{
                spk_end.removeClass('is-invalid');
                result +='2';
            }

            if(qty_m_base.val()==''){
                qty_m_base.addClass('is-invalid');
            }else{
                qty_m_base.removeClass('is-invalid');
                result +='3';
            }

            if(qty_part.val()==''){
                qty_part.addClass('is-invalid');
            }else{
                qty_part.removeClass('is-invalid');
                result +='4';
            }

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
                                var type = "perbarui"
                            }
                            $('.alert-success').html('SPK berhasil di '+type).fadeIn().delay(4000).fadeOut('slow');
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
			$('#myModal').find('.modal-title').text('Ubah SPK');
            $('#myForm').attr('action', '<?php echo base_url() ?>spks/updateSpk'); // langsung panggil controller

			$.ajax({
				type: 'ajax',
				method: 'get',
				url: '<?php echo base_url() ?>spks/editSpk', // langsung panggil controller
				data: {id: id},
				async: false,
				dataType: 'json',
				success: function(data){
                    // console.log(data);

                    if ( data.spk_status == "0" ) {
                        spkStatusWord = 'Mulai';
                    }

                    // return false;
					$('input[name=txtId]').val(data.id);
                    $('input[name=spk_no]').val(data.spk_no);
                    $('input[name=spk_status]').val(spkStatusWord);
                    $('#id_customer').val(data.id_customer);
                    $('input[name=spk_co_number]').val(data.spk_co_number);
                    $('#id_material').val(data.id_material);
                    $('input[name=qty_m_base]').val(data.qty_m_base);
                    $('#id_uom_base').val(data.id_uom_base);
                    $('input[name=qty_m_convert]').val(data.qty_m_convert);
                    $('#id_uom_convert').val(data.id_uom_convert);
                    $('input[name=created_at]').val(data.created_at);
                    $('input[name=spk_closed]').val(data.spk_closed);
                    $('input[name=spk_start]').val(data.spk_start);
                    $('input[name=spk_end]').val(data.spk_end);

                    $('#created_at').val(moment(data.created_at).format('YYYY-MM-DD'));
                    $('#spk_start').val(moment(data.spk_start).format('YYYY-MM-DD'));
                    $('#spk_end').val(moment(data.spk_end).format('YYYY-MM-DD'));

                    $('input[name=spk_rework]').val(data.spk_rework);
                    $('#id_part').val(data.id_part);
                    $('input[name=qty_part]').val(data.qty_part);
                    $('#id_uom_part').val(data.id_uom_part);
                    $('#spk_notes').val(data.spk_notes);

                    /* get detail */
                    var idMaterial = $('#id_material');
                    var rawMaterialQty = $('#qty_m_base');

                    // Get initial value first
                    getMaterialDetail(idMaterial.val());
                    // get value again when change
                    idMaterial.on('change', function(){
                        getMaterialDetail(idMaterial.val());
                        reCalcMaterialConvert(idMaterial.val());
                    });

                    rawMaterialQty.on('change', function(){
                        reCalcMaterialConvert(idMaterial.val());
                    });
                    /* End of get detail */

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
					url: '<?php echo base_url() ?>spks/deleteSpk', // langsung panggil controller
					data:{id:id},
					dataType: 'json',
					success: function(response){
						if(response.success){
							$('#deleteModal').modal('hide');
							$('.alert-success').html('SPK berhasil dihapus').fadeIn().delay(4000).fadeOut('slow');
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