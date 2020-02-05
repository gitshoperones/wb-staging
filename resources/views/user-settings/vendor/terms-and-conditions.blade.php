@extends('layouts.public')

@section('content')
<section id="wb-settings-block">
	<div class="container">
		<div class="text-center">
			@include('partials.user-settings.vendor-tab-header')
			<div class="row">
				<div class="wb-box">
                    @include('modals.alert-messages')
					<h4 class="title">T&C for your wedBooker Bookings</h4>
					<p class="text-primary">wedBooker Terms & Conditions apply for bookings that take place on wedBooker.com. Where you have additional Terms & Conditions applicable to your provision of services, you may save these to your account, and attach them to quotes. Where your Terms & Conditions conflict with the wedBooker Terms & Conditions, the wedBooker Terms & Conditions will apply.</p>
					<form method="POST" action="{{ url('terms-and-conditions') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
						<div class="form-group">
							<div class="row">
								<div class="col-md-5">
                                    <div class="custom-file">
                                        <input type="file"
                                            accept=".pdf,.doc,.docx,.txt,.text, .zip"
                                            placeholder="No file ."
                                            class="custom-file-input"
                                            name="tc_file"
                                            id="tc_file"
                                            required/>
                                        <label class="custom-file-label" for="tc_file">Upload document</label>
                                    </div>
                                </div>
							</div>
                        </div>
                        
                        {!! count($tcFiles) ? '<h4 class="title">Your Saved Documents</h4>' : ''!!}
                        <ul class="list-group">
                            @foreach($tcFiles as $file)
                            <li class="list-item">
                                <a href="{{ $file->meta_filename }}" target="_blank" class="btn btn-default">
                                    {{ $file->meta_original_filename }}
                                </a>
                                <button type="button" style="margin-top: 0px;" class="btn btn-default delete-tc" data-id="{{ $file->id }}">
                                    <i class="fa fa-trash text-danger"></i>
                                </button>
                            </li>
                            @endforeach
                        </ul>

                        <div class="action-block">
                            <input type="submit" value="SAVE CHANGES" class="btn wb-btn-orange">
                        </div>
                    </form>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@push('css')
<style>
.custom-file {
    position: relative;
    display: inline-block;
    width: 100%;
    height: calc(2.25rem + 2px);
    margin-bottom: 0;
}
.custom-file-input {
    position: relative;
    z-index: 2;
    height: calc(2.25rem + 2px);
    margin: 0;
    opacity: 0;
}
.custom-file-label {
    position: absolute;
    top: 0;
    right: 0;
    left: 0;
    z-index: 1;
    padding: .375rem .75rem;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    border: 1px solid #ced4da;
    border-radius: .25rem;
}
.custom-file-label::after {
    position: absolute;
    top: 0;
    right: 0;
    bottom: 0;
    z-index: 3;
    display: block;
    padding: .375rem .75rem;
    line-height: 1.5;
    color: #495057;
    content: "Browse";
    background-color: #e9ecef;
    border-left: 1px solid #ced4da;
    border-radius: 0 .25rem .25rem 0;
}
.list-item {
    margin-bottom: 5px;
}
.list-group {
    list-style: none;
    padding-left: 0px;
    margin-bottom: 30px;
}
</style>
@endpush

@push('scripts')
    <script type="text/javascript">
        $('#tc_file').change(function() {
            var file = $(this).val(),
                filename = file.substring(file.lastIndexOf('\\') + 1);
            $('.custom-file-label').text(filename);
        });

        $('.delete-tc').on('click', function(e) {
            var msg = 'This will permanently delete the file. Click OK to continue or Cancel to abort.',
                confirm = window.confirm(msg),
                button = $(this),
                id = button.data('id');

            if (confirm) {
                $.ajax({
                    type: 'DELETE',
                    url: '/terms-and-conditions/' + id,
                    data: {
                        "_token": csrf_token
                    },
                    success: function(data) {
                        button.parent('.list-item').remove();
                    },
                    error: function (error) {
                        // handle error
                    },
                })
                return true;
            } else {
                e.preventDefault();
                return false;
            }
        })
    </script>
@endpush