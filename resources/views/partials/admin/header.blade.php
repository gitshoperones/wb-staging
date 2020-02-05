@section('css')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@7.28.2/dist/sweetalert2.min.css" rel="stylesheet" />
<link href="{{ asset('assets/css/admin_custom.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('assets/vendor/adminlte/vendor/font-awesome/css/font-awesome.min.css') }}">
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<link href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
<link href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">
<link href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<style>
	td a {
		display:block;
		width:100%;
		text-decoration: none;
		color: #000;
	}
    .rating a {
        display: inline;
    }
	.pen-den{
		position:relative;
		top:10px;
	}
	.yellow-btn{
		color: #000 !important;
		border-color: #e4e400 !important;
		background-color: #FFFF00 !important;
	}
	.orange-btn {
		color: #000 !important;
		border-color: #ff9c00 !important;
		background-color: #e08e0b !important;
	}
	.gray-btn{
		color: #000 !important;
		border-color: #777 !important;
		background-color: #999 !important;
	}
	.violet-btn{
		border-color: #373654 !important;
		background-color: #373654 !important;
	}
	.comment-text{
		margin-left: 20px !important;
	}
	.note-btn{
		margin-top: 20px;
		float: right;
	}
	.reference-btn{
		margin-top: 20px;
		float: right;
	}
	.box-success{
		margin-top:20px;
	}
	.box-warning{
		margin-top:20px;
	}
	.comment-text{
		margin-bottom:20px;
	}
	input[type=search] {
		width: 130px;
		line-height: 2em;
		-webkit-transition: width 0.4s ease-in-out;
		transition: width 0.4s ease-in-out;
	}

	/* When the input field gets focus, change its width to 100% */
	input[type=search]:focus {
		width: 100%;
	}
	.page-numbers{
		padding: 5px 15px 5px 15px;
		margin-right: 5px;
		margin-left: 5px;
		color: #333 !important;
		border: 1px solid #979797;
		background-color: white;
		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%, #fff), color-stop(100%, #dcdcdc));
		background: -webkit-linear-gradient(top, #fff 0%, #dcdcdc 100%);
		background: -moz-linear-gradient(top, #fff 0%, #dcdcdc 100%);
		background: -ms-linear-gradient(top, #fff 0%, #dcdcdc 100%);
		background: -o-linear-gradient(top, #fff 0%, #dcdcdc 100%);
		background: linear-gradient(to bottom, #fff 0%, #dcdcdc 100%);
	}

	.info{
		padding-top: 15px;
	}

</style>
@stack('css')
@stop
