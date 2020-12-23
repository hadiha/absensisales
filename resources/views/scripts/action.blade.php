<script type="text/javascript">

	function saveData(formid) {
		// show loading
		$('#' + formid).find('.loading.dimmer').addClass('active');

		// begin submit
		$("#" + formid).ajaxSubmit({
			success: function(resp){
				console.log('save...')
				swal({
					title:'Tersimpan!',
					text:'Data berhasil disimpan.',
					type:'success',
					allowOutsideClick: false,
					showCancelButton: false,

					confirmButtonColor: '#0052DC',
					confirmButtonText: 'Tutup',
					
					cancelButtonColor: '#6E6E6E',
					cancelButtonText: 'Print'
				}).then((result) => { // ok
					location.href = '{{ url($pageUrl) }}';

				}, function(dismiss) { // cancel
					// if (dismiss === 'cancel') { // you might also handle 'close' or 'timer' if you used those
					// 	console.log('print 2')
					// 	getNewTab('{{ url('print') }}/' + resp.registration);

					// 	@if(isset($action) && $action == 'create')
					// 		location.href = '{{ url($action.'/'.$jalur) }}';
					// 	@else
					// 		location.href = '{{ url('/') }}';
					// 	@endif
					// } else {
					// 	throw dismiss;
					// }
				})
			},
			error: function(resp){
				$('#' + formid).find('.loading.dimmer').removeClass('active');
				// $('#cover').hide();
				var response = resp.responseJSON;
				$.each(response.errors, function(index, val) {
					clearFormError(index,val);
					showFormError(index,val);
				});
				time = 5;
				interval = setInterval(function(){
					time--;
					if(time == 0){
						clearInterval(interval);
						$('.pointing.prompt.label.transition.visible').fadeOut('slideUp', function(e) {
							$(this).remove();
						});
						$('.error').each(function (index, val) {
							$(val).removeClass('error');
						});
					}
				},1000)
				// var error = $('<ul class="list"></ul>');
				// $.each(resp.responseJSON.errors, function(index, val) {
				// 	error.append('<li>'+val+'</li>');
				// });
				// $('#' + formid).find('.ui.error.message').html(error).show();	
			}
		});
	}

	function deleteData(url) {
		swal({
			title: 'Menghapus Data',
			text: "Apakah akan menghapus data tersebut?",
			type: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			confirmButtonText: 'Ya',
			cancelButtonColor: '#d33',
			cancelButtonText: 'Tidak',
			reverseButtons: true,
		}).then((result) => {
			if (result) {
				$.ajax({
					url: url,
					type: 'POST',
					// dataType: 'json',
					data: {
						'_method' : 'DELETE',
						'_token' : '{{ csrf_token() }}'
					}
				})
				.done(function(response) {
					swal({
				    	title: 'Data Berhasil Dihapus',
						text: " ",
						type: 'success',
						allowOutsideClick: false
				    }).then((res) => {
				    	dt.draw('page');
				    })
				})
				.fail(function(response) {
					swal({
				    	title: 'Data Gagal Dihapus',
						text: " ",
						type: 'error',
						allowOutsideClick: false
				    }).then((res) => {

				    })
				})

			}
		})
	}

	function loadModal(param) {
		var url    = (typeof param['url'] === 'undefined') ? '#' : param['url'];
		var modal  = (typeof param['modal'] === 'undefined') ? 'formModal' : param['modal'];
		var formId = (typeof param['formId'] === 'undefined') ? 'formData' : param['formId'];
		var onShow = (typeof param['onShow'] === 'undefined') ? function(){} : param['onShow'];

		$(modal).modal({
			bottom: 'auto',
			inverted: true,
			observeChanges: true,
			closable: false,
			detachable: false, 
			autofocus: false,
			onApprove : function() {
				$(formId).form('validate form');
				if($(formId).form('is valid')){
					$(modal).find('.loading.dimmer').addClass('active');
					$(formId).ajaxSubmit({
						success: function(resp){
							$(modal).modal('hide');
							swal(
							'Tersimpan!',
							'Data berhasil disimpan.',
							'success'
							).then((result) => {
								dt.draw('page');
								return true;
							})
						},
						error: function(resp){
							$(modal).find('.loading.dimmer').removeClass('active');
							// $('#cover').hide();
							var response = resp.responseJSON;
							$.each(response.errors, function(index, val) {
								clearFormError(index,val);
								showFormError(index,val);
							});
							time = 5;
							interval = setInterval(function(){
								time--;
								if(time == 0){
									clearInterval(interval);
									$('.pointing.prompt.label.transition.visible').fadeOut('slideUp', function(e) {
										$(this).remove();
									});
									$('.error').each(function (index, val) {
										$(val).removeClass('error');
									});
								}
							},1000)
							// $(modal).find('.loading.dimmer').removeClass('active');
							// var error = $('<ul class="list"></ul>');

							// $.each(resp.responseJSON.errors, function(index, val) {
							// 	error.append('<li>'+val+'</li>');
							// });

							// if(resp.responseJSON.status=='errors'){
							// 	error.append('<li>'+resp.responseJSON.message+'</li>');
							// }

							// $(modal).find('.ui.error.message').html(error).show();
						}
					});	
				}
				return false;
			},
			onShow: function(){
				$(modal).find('.loading.dimmer').addClass('active');
				$.get(url, { _token: "{{ csrf_token() }}" } )
				.done(function( response ) {
					$(modal).html(response);
					// execute script
					// console.log('ini eksekusi dari onshow')
					onShow();
				});
			},
			onHidden: function(){
				$(modal).html(`<div class="ui inverted loading dimmer">
										<div class="ui text loader">Loading</div>
									</div>`);
			}
		}).modal('show');
	}

	function postNewTab(url, param){
        var form = document.createElement("form");
        form.setAttribute("method", 'POST');
        form.setAttribute("action", url);
        form.setAttribute("target", "_blank");

        $.each(param, function(key, val) {
            var inputan = document.createElement("input");
                inputan.setAttribute("type", "hidden");
                inputan.setAttribute("name", key);
                inputan.setAttribute("value", val);
            form.appendChild(inputan);
        });

        document.body.appendChild(form);
        form.submit();

        document.body.removeChild(form);
    }

    function getNewTab(url){
        var win = window.open(url, '_blank');
  		win.focus();
    }

	function showFormError(key, value)
	{
		if(key.includes("."))
		{
			res = key.split('.');
			key = res[0] + '[' + res[1] + ']';
			if(res[1] == 0)
			{
				key = res[0] + '\\[\\]';
			}
		}
		var elm = $('#dataForm' + ' [name=' + key + ']').closest('.field');
		$(elm).addClass('error');
		var message = `<div class="ui basic red pointing prompt label transition visible">`+ value +`</div>`;

		var showerror = $('#dataForm' + ' [name=' + key + ']').closest('.field');
		$(showerror).append('<div class="ui basic red pointing prompt label transition visible">' + value + '</div>');
	}

	function clearFormError(key, value)
	{
		if(key.includes("."))
		{
			res = key.split('.');
			key = res[0] + '[' + res[1] + ']';
			if(res[1] == 0)
			{
				key = res[0] + '\\[\\]';
			}
			console.log(key);
		}
		var elm = $('#dataForm' + ' [name=' + key + ']').closest('.field');
		$(elm).removeClass('error');

		var showerror = $('#dataForm' + ' [name=' + key + ']').closest('.field').find('.ui.basic.red.pointing.prompt.label.transition.visible').remove();
	}
</script>