@extends('layouts.dashboard')

@section('content')
<section id="wb-verify-business" class="wb-verify-business wb-bg-grey" style="padding: 40px 0px 0px;">
    <div class="container-fluid">
        <div class="box box-widget">
            <div class="box-header bg-dusty with-border" style="line-height: normal;">
                <h3 class="box-title" style="line-height: normal; margin-bottom: 20px; text-transform: uppercase;">
                    Help Us Verify Your Business
                </h3><!-- /.box-title -->
                <p style="font-weight: 300">
                    To maintain our professional community, it's important that we verify all businesses. To help us get your account live as quickly as possible, please provide the below details:
                </p>
            </div><!-- /.box-header with-border -->
            <div class="box-body"> <br/ >
                <div class="col-sm-9 col-md-6">
                    <form action="{{ url('/dashboard/verify-business') }}" method="POST" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        @include('partials.alert-messages')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Your ABN <span class="required">*</span></label>
                                    <input type="text" value="{{ $abn }}" name="abn" class="form-control">
                                </div>
                            </div>
                        </div> <br />
                        <div class="row">
                            <div class="col-md-12">
                                <label>Photo Identification for Sole Traders <i class="fa fa-question-circle" data-toggle="tooltip" title="Please upload a photo of yourself holding your drivers licence or passport."></i></label>
                                <input type="file"
                                    accept=".jpg, .jpeg, .png"
                                    placeholder="No file chosen"
                                    class="form-control"
                                    name="verification_photo"/>
                            </div>
                        </div> <br />
                        <div class="row">
                            <div class="col-md-12">
                                <label>Legal Documentation for Companies <i class="fa fa-question-circle" data-toggle="tooltip" title="A letter from a government agency (e.g. ASIC) or a service bill (e.g. electricity). It must show your Business Name, ABN/ACN and Registered Business Address."></i> </label>
                                <input type="file"
                                    accept=".pdf, .doc, .docx, .txt, .text"
                                    placeholder="No file chosen"
                                    class="form-control"
                                    name="verification_document"/>
                            </div>
                        </div><br /><br />
                        <div class="row">
                            <div class="col-md-12">
                                <div class="action-block"><input type="submit" value="Submit" class="btn wb-btn-orange"></div>
                            </div><!-- /.col-md4 -->
                        </div><!-- /.row -->
                        <br /><br />
                    </form>
                </div><!-- /.col-sm-9 -->
            </div><!-- /.box-body -->
        </div><!-- /.box box-widget -->
    </div>
    @if(session()->has('success_notification'))
        @include('modals.notification', [
            'title' => '',
            'body' => 'Thanks for submitting your details. Your account is being reviewed and we will be in touch shortly.'
        ])
    @endif
</section>
@endsection