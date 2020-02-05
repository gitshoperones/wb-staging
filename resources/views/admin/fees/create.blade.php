@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Fee')

@section('content')
    <div class="container">
        <form method="POST" action="{{ url('admin/fees') }}" accept-charset="UTF-8">
            {{ csrf_field() }}
            @include('partials.alert-messages')
            <div class="row">
                <div class="col-lg-6 form-group">
                    <h3>Fee Type</h3>
                    <div class="form-check">
                        <input class="form-check-input fee-type" type="radio" name="type" id="default" value="default">
                        <label class="form-check-label" for="default">
                            Default
                        </label>
                        <br/>
                        <small>
                            Notes about Default Fee:<br>
                            <i>
                                <ul>
                                    <li>This will Remove all existing default fee applied to any account</li>
                                    <li>This will become the default fee to all existing and future account that doesn't have custom fee.</li>
                                </ul>
                        </small>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input fee-type" type="radio" name="type" id="custom" value="custom">
                        <label class="form-check-label" for="custom">
                            Custom
                        </label>
                        <br/>
                        <small>
                            Notes about Custom Fee:<br>
                            <i>
                                <ul>
                                    <li>After created, this will NOT yet apply to any account.</li>
                                    <li>You can only apply this fee manually to an account.</li>
                                    <li>
                                        To apply this fee to an account, You need to view the account and click "Setup Fee" button.
                                        Then select this fee from the list of available fees.
                                    </li>
                                </ul>
                        </small>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-4 form-group">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="override_custom_fee" value="yes" id="override_custom_fee">
                            <label class="form-check-label" for="override_custom_fee">
                            Override all Existing Custom Fee
                        </label>
                        <br/>
                        <small>
                            Notes:<br>
                            <i>
                                <ul>
                                    <li>This option is only available when you select <b>Default Fee Type</b>.</li>
                                    <li>This will remove all custom fee applied to any account then apply the new default fee.</li>
                                </ul>
                        </small>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-4 form-group">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" required>
                    <small><i>Unique name of the fee.</i></small>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-4 form-group">
                    <label>Percent</label>
                    <input type="text" class="form-control" name="percent" value="{{ old('percent') }}" required>
                    <small><i>The fee percentage that will apply to all payment.</i></small>
                </div>
                <div class="clearfix"></div>
                <div class="col-lg-4 form-group">
                    <label>Who pays the fee?</label>
                    <select class="form-control" name="payer" required>
                        <option value="">Select</option>
                        @foreach ($payer as $key => $payer)
                            <option value="{{ $key }}"
                                @if (request('payer') == $key || old('payer') == $key)
                                    selected
                                @endif
                                >{{ $payer }} </option>
                        @endforeach
                    </select>
                    <small><i>The account who will be charge for the fee.</i></small>
                </div>
                <div class="clearfix"></div>
                <!-- <div class="col-lg-4 form-group">
                    <label>Expiration Date</label>
                    <input type="text"
                        name="exp_date"
                        data-date-start-date="+1d"
                        data-date-format="MM d, yyyy"
                        class="form-control date"
                        onkeydown="return false"
                        value="">
                </div> -->
                <div class="clearfix"></div>
                <div class="col-lg-12 form-group">
                    <input type="submit" class="btn btn-success"  value="Save" />
                </div>
            </div>
        </form>
    </div>
@stop
@push('scripts')
    <script type="text/javascript">
        var override = $('#override_custom_fee');
        override.attr('disabled', true);

       $('.fee-type').on('change', function(){
            var feeType = $(this).val();
            if(feeType === 'default') {
                override.attr('disabled', false);
            } else {
                override.attr('disabled', true);
                override.prop('checked', false);
            }
       })
       $('.date').datepicker();
       override.on('click', function(){
            if (override.is(':checked')) {
                alertMe(override);
            }
       })
       function alertMe(event) {
            swal({
                title: 'Are you sure?',
                text: "By checking this option, you will be removing any custom fee to all account!",
                type: 'warning',
                width: 600,
                padding: '3em',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes understood, continue override any custom fee!'
            }).then((result) => {
                if (!result.value) {
                    override.prop('checked', false);
                }
            });
       }
    </script>
@endpush
@include('partials.admin.footer')