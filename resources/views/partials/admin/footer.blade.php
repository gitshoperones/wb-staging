@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.2/dist/sweetalert2.min.js"></script>
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
	<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
	@stack('scripts')
	<script>
		$(document).ready(function() {
			$('#dataInfo').DataTable({searching: false, paging: false, info: false});

			//Date picker
			$('.datepicker').datepicker({
				format: 'yyyy-mm-dd'
			});

			$('.newsletter').change(function() {
				if($(this).is(":checked")) {
					$.ajax({
						url: "{{ url('admin/newsletter/add')}}"+ "/" + this.value,
						method: 'GET',
						dataType: 'application/json; charset=utf-8',
					});
				}else{
					$.ajax({
						url: "{{ url('admin/newsletter/delete')}}"+ "/" + this.value,
						method: 'GET',
						dataType: 'application/json; charset=utf-8',
					});
				}
			});

			$('.note-btn').click(function() {
				var id = $(this).val();
				var desc = $('textarea#note-description').val();
				var d = new Date('MM YYYY');

				if (desc == '') {
					alert('Note message is required');
					return false;
				}
				
				$.ajax({
					dataType: 'json',
					url: `{{ url('admin/note') }}/${id}`,
					data: {
						_token: '{{ csrf_token() }}',
						description: desc
					},
					method: 'POST',
					success: function (data) {
						if (data.response) {
							var html = `
								<div class="comment-text">
									<span class="username">
										${data.name}
										<span class="text-muted pull-right">Just now</span>
									</span>
									${desc}
									<hr/>
								</div>
							`;
							$('#note-data').append(html);
							$('textarea#note-description').val("")
						}
					},
					error: function (data) {
						var required = JSON.parse(data.responseText)
						var html = `
							<div class="comment-text">
								<span class="username" style="color:red">${required.message}
									<span class="text-muted pull-right">Just now</span>
								</span>
								<hr/>
							</div>
						`;
						
						$('#note-data').append(html);
						$('textarea#note-description').val("")
					},
				});
			});

			$('.reference-btn').click(function() {
				var id = $('button.reference-btn').val();
				var desc = $('textarea#reference-description').val();
				var d = new Date('MM YYYY');
				$.ajax({
					dataType: 'application/json; charset=utf-8',
					url: "{{ url('admin/reference')}}"+"/"+id,
					data: { description: desc, _token: '{{csrf_token()}}'} ,
					method: 'POST',
					success: function (data) {
					},
					error: function (data) {
						var html = '<div class="comment-text">';
						html += '<span class="username">'+data['responseText'];
						html += '<span class="text-muted pull-right">Just now</span>';
						html += '</span>';
						html += desc;
						html += '<hr/>';
						html += '</div>';
						$('#reference-data').append(html);
						$('textarea#reference-description').val("")
					},
				});
			});
		});

		window.setTimeout(function() {
			$(".alert.alert-dismissable").fadeTo(500, 0).slideUp(500, function(){
				$(this).remove();
			});
		}, 8000);
	</script>
@stop
