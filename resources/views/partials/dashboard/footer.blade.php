<script type="text/javascript">
	$(function() {
	   //data tables
	   var rowData = [];
	   var count = 1;
	   $('table.table thead th').each(function(index, el) {
		rowData[count] = $.trim($(this).text());
		tabledata = 'td:nth-child('+count+')';
		$(this).closest('table').find(tabledata).attr('data-title',rowData[count]);

		count++;
	   });
	});
</script>

<footer class="main-footers">
	<div class="left">
		<div class="logo-footer">
			<img style="max-width: 45px; margin-top: -9px; margin-right: 7px;" src=" {{ asset('assets/images/wedbooker-white-icon.png') }} " alt="">
		</div>
		<div class="copyright item">Copyright &copy; {{ now()->year }} wedBooker Australia Pty Ltd All Rights Reserved.</div>
	</div>
	<div class="right">
		<div class="tac item">
			<a href=" {{ url('/community-guidelines')}} ">Community Guidelines</a> &nbsp;&nbsp;&nbsp;
			<a href=" {{ url('/privacy-policy')}} ">Privacy Policy</a> &nbsp;&nbsp;&nbsp;
			<a href=" {{ url('/terms-and-conditions')}} ">Terms & Conditions</a>
		</div>
	</div>
	<!-- <span class="pull-right message-icon">
		<img src=" {{-- {{ asset('assets/images/message-icon.png') }} --}}"/>
	</span> -->
</footer>
<div class="dashboard overlay"></div>