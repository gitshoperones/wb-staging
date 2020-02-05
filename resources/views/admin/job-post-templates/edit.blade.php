@extends('adminlte::page')
@include('partials.admin.header')
@section('title', 'Job Post Templates')

@section('content')
    <div class="container">
        <form action="{{ url(sprintf('/admin/job-post-templates/%s', $template->id)) }}"
            method="POST">
            <div class="row">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PATCH">
                <input type="hidden" name="template_id" value="{{ $template->id }}">
                @include('partials.alert-messages')
                <div class="col-lg-4 form-group">
                    <label>Template Title</label>
                    <input type="text" class="form-control" name="title" value="{{ isset($template) ? $template->title : old('title') }}" required>
                </div>
                <div class="col-lg-12 form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="approximate" id="approximate" value="1" {{ ($template->approximate) ? 'checked' : '' }}>
                            <strong> Step 2 - Require Approx Number of Guests</strong>
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="approxDisplay" id="approxDisplay" value="1" {{ ($template->approxDisplay) ? 'checked' : '' }}>
                            <strong> Step 2 - Show Approx Number of Guests</strong>
                        </label>
                    </div>
                    <a class="btn btn-primary addField">Add Custom Field in Step 2</a>
                </div>
                <div class="customFields col-lg-12"></div>
                <div class="col-lg-12 form-group">
                    <label>Step 3 - Hint Text</label>
                    <input type="text" class="form-control" name="custom_text" value="{{ isset($template) ? $template->custom_text : old('custom_text') }}">
                </div>
                <div class="col-lg-12 form-group">
                    <label>Step 3 - Body</label>
                    <div id="template-body-editor" style="height: 0px;background-color: white;"></div>
                    <input type="hidden" id="template-body" name="body" value="{{ isset($template) ? $template->body : old('body') }}">
                </div>
                <div class="col-lg-12 form-group">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="images_option" id="images_option" value="1" {{ $template->images_option ? 'checked' : '' }}>
                            <strong> Step 4 - Images Step</strong>
                        </label>
                    </div>
                </div>
                <div class="col-lg-12 form-group">
                    <input type="submit" class="btn btn-success"  value="Update" />
                </div>
            </div>
        </form>
    </div>
    @push('css')
    <link href="{{ asset('assets/js/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/js/Trumbowyg/ui/trumbowyg.min.css') }}" rel="stylesheet" />
    @endpush
    @push('scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('assets/js/Trumbowyg/trumbowyg.min.js') }}"></script>
        <script type="text/javascript">
           var editor = $('#template-body-editor');
           var editorContent = $('#template-body');

            editor.trumbowyg({
                removeformatPasted: true,
                btns: [
                    ['formatting'],
                    ['strong', 'em', 'underline'],
                    ['justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull'],
                    ['unorderedList', 'orderedList'],
                ],
            }).on('tbwchange', function(){
                updateWysiwygContent();
             }).on('tbwblur', function(){
                updateWysiwygContent();
             }).on('tbwfocus', function(){
                updateWysiwygContent();
             });
            editor.trumbowyg('html', $('#template-body').val());
            $('body').on('click', function(){
                updateWysiwygContent();
            });

            function updateWysiwygContent() {
                editorContent.val(editor.trumbowyg('html'));
            }

            $(document).ready(function(){
                var i=0;
                $('.addField').click(function() {
                    $('.customFields').append(`
                    <div class="row ft`+i+`">
                        <a data-id="`+i+`" class="btn btn-danger btn_remove"><i class="fa fa-close"></i></a>
                        <div class="col-lg-1 form-group text-center">
                            <label for="req`+i+`" class="flabel">Required</label>
                            <input type="checkbox" name="fields[`+i+`][req]" id="req`+i+`" value="1">
                        </div>
                        <div class="col-lg-2 form-group">
                            <label for="ft`+i+`">Field Type</label>
                            <select class="form-control fieldType" data-id="`+i+`" name="fields[`+i+`][type]" required>
                                <option value="" disabled selected>Select Field Type</option>
                                @foreach($fieldTypes as $value => $name)
                                <option value="{{ $value }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-lg-3 form-group">
                            <label for="f`+i+`">Field Text</label>
                            <input type="text" class="form-control" id="f`+i+`" name="fields[`+i+`][text]" placeholder="Field Text" required>
                        </div>
                        <div class="col-lg-3 form-group">
                            <label for="jp`+i+`" class="jptlabel">Field text to show on job page</label>
                            <input type="text" class="form-control jptinput" id="jp`+i+`" name="fields[`+i+`][jtext]" placeholder="Field text to show on job page" required>
                        </div>
                    </div>`);
                    i++;
                    $( ".customFields" ).sortable({
                        update: function(event, ui) {
                            $('.customFields .row').each(function(index) {
                                $(this).attr('class', $(this).attr('class').replace(/ft\d/, ('ft'+index)));
                                $(this).find('.btn_remove').attr('data-id', $(this).find('.btn_remove').attr('data-id').replace(/\d/, (index)));
                                $(this).find('.flabel').attr('for', $(this).find('.flabel').attr('for').replace(/req\d/, ('req'+index)));
                                $(this).find('.ftlabel').attr('for', $(this).find('.ftlabel').attr('for').replace(/f\d/, ('f'+index)));
                                $(this).find('.jptlabel').attr('for', $(this).find('.jptlabel').attr('for').replace(/jp\d/, ('jp'+index)));
                                var prefix = "fields[" + index + "]";
                                $(this).find("input, select").each(function() {
                                    this.name = this.name.replace(/fields\[\d+\]/, prefix);
                                    if($(this).hasClass('finput')) {
                                        $(this).attr('id', $(this).attr('id').replace(/req\d/, ('req'+index)));
                                    }else if ($(this).hasClass('ftinput')) {
                                        $(this).attr('id', $(this).attr('id').replace(/f\d/, ('f'+index)));
                                    }else if ($(this).hasClass('jptinput')) {
                                        $(this).attr('id', $(this).attr('id').replace(/jp\d/, ('jp'+index)));
                                    }else if ($(this).hasClass('doinput')) {
                                        $(this).attr('id', $(this).attr('id').replace(/do\d/, ('do'+index)));
                                    }
                                    if($(this).attr('data-id') !== undefined) {
                                        $(this).attr('data-id', index);
                                    }
                                });
                            })
                        }
                    });
                })
                
                $(document).on('change', '.fieldType', function(){
                    var id = $(this).attr('data-id');
                    var fieldOptions = `<div class="col-lg-3 form-group fop">
                                    <label class="doinput">Field Options</label>
                                    <input id="do`+id+`" class="doinput" type="text" data-role="tagsinput" placeholder="Separated by comma" name="fields[`+id+`][opts]" required/> 
                                </div>`;
                    if($(this).val() == 'custom' || $(this).val() == 'custom_multi' ) {
                        $(this).parents('.row.ft' + id).find('#do' + id).parents('.fop').remove();
                        $(this).parents('.row.ft' + id).append(fieldOptions);
                        $("#do"+id).tagsinput();
                        $("#do"+id).prev().addClass('form-control');
                    } else {
                        $(this).parents('.row.ft' + id).find('#do' + id).parents('.fop').remove();
                    }

                    if ($(this).val() == 'text' || $(this).val() == 'numeric') {
                        fieldOptions = `<div class="col-lg-3 form-group icop">
                            <label for="f`+id+`" class="ftlabel">Field Icon</label>
                            <input class="form-control" type="text" id="ico`+id+`" placeholder="Field Icon" name="fields[`+id+`][icon]" /> 
                            (<em>Get icons <a href="https://fontawesome.com/v4.7.0/icons" target="_blank">here</a> e.g. fa fa-address-book</em>)
                        </div>`;

                        $(this).parents('.row.ft' + id).find('#ico' + id).parents('.icop').remove();
                        $(this).parents('.row.ft' + id).append(fieldOptions);
                    } else {
                        $(this).parents('.row.ft' + id).find('#ico' + id).parents('.icop').remove();
                    }
                });
                
                $(document).on('click', '.btn_remove', function(){
                    var button_id = $(this).attr("data-id"); 
                    $('.ft'+button_id+'').remove();
                });

                
                @if($template->fields)
                function htmlEntities(str) {
                    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
                }
                var types = {!! json_encode($fieldTypes) !!}, fields = {!! $template->fields !!}, req = '', text = '', opts = '';

                $.each(fields, function(){
                    var dropdown = '';
                    for (var type in types) {
                        var selected = (this.type == type) ? 'selected' : '' ;
                        dropdown += `<option value="`+type+`" `+selected+`>`+types[type]+`</option>`;
                    }
                   
                    req = (this.req) ? 'checked' : '';

                    if(this.opts != undefined) {
                        opts = `<div class="col-lg-3 form-group fop">
                            <label class="flabel">Field Options</label>
                            <input id="do`+i+`" class="doinput" type="text" value="`+this.opts+`" data-role="tagsinput" placeholder="Separated by comma" name="fields[`+i+`][opts]" required/> 
                        </div>`;
                    } else if (this.type == 'text' || this.type == 'numeric') {
                        opts = `<div class="col-lg-3 form-group icop">
                            <label for="f`+i+`" class="ftlabel">Field Icon</label>
                            <input class="form-control" type="text" id="ico`+i+`" value="${(this.icon) ? this.icon : '' }" placeholder="Field Icon" name="fields[`+i+`][icon]" /> 
                            (<em>Get icons <a href="https://fontawesome.com/v4.7.0/icons" target="_blank">here</a> e.g. fa fa-address-book</em>)
                        </div>`
                    } else {
                        opts = '';
                    }

                    $('.customFields').append(`
                    <div class="row ft`+i+`">
                        <a data-id="`+i+`" class="btn btn-danger btn_remove"><i class="fa fa-close"></i></a>
                        <div class="col-lg-1 form-group text-center">
                            <label for="req`+i+`" class="flabel">Required</label>
                            <input type="checkbox" class="finput" name="fields[`+i+`][req]" id="req`+i+`" value="1" `+req+`>
                        </div>
                        <div class="col-lg-2 form-group">
                            <label>Field Type</label>
                            <select class="form-control fieldType" data-id="`+i+`" name="fields[`+i+`][type]" required>
                                <option value="" disabled selected>Select Field Type</option>
                                `+dropdown+`
                            </select>
                        </div>
                        <div class="col-lg-3 form-group">
                            <label for="f`+i+`" class="ftlabel">Field Text</label>
                            <input type="text" class="form-control ftinput" id="f`+i+`" name="fields[`+i+`][text]" value="`+htmlEntities(this.text)+`" placeholder="Field Text" required>
                        </div>
                        <div class="col-lg-3 form-group">
                            <label for="jp`+i+`" class="jptlabel">Field text to show on job page</label>
                            <input type="text" class="form-control jptinput" id="jp`+i+`" name="fields[`+i+`][jtext]" value="`+htmlEntities(this.jtext)+`" placeholder="Field text to show on job page" required>
                        </div>
                        `+opts+`
                    </div>`);
                    $("#do"+i).tagsinput();
                    $("#do"+i).prev().addClass('form-control');
                    i++;
                });
                $( ".customFields" ).sortable({
                        update: function(event, ui) {
                            $('.customFields .row').each(function(index) {
                                $(this).attr('class', $(this).attr('class').replace(/ft\d/, ('ft'+index)));
                                $(this).find('.btn_remove').attr('data-id', $(this).find('.btn_remove').attr('data-id').replace(/\d/, (index)));
                                $(this).find('.flabel').attr('for', $(this).find('.flabel').attr('for').replace(/req\d/, ('req'+index)));
                                $(this).find('.ftlabel').attr('for', $(this).find('.flabel').attr('for').replace(/req\d/, ('f'+index)));
                                var prefix = "fields[" + index + "]";
                                $(this).find("input, select").each(function() {
                                    this.name = this.name.replace(/fields\[\d+\]/, prefix);
                                    if($(this).hasClass('finput')) {
                                        $(this).attr('id', $(this).attr('id').replace(/req\d/, ('req'+index)));
                                    }else if ($(this).hasClass('ftinput')) {
                                        $(this).attr('id', $(this).attr('id').replace(/f\d/, ('f'+index)));
                                    }else if ($(this).hasClass('jptinput')) {
                                        $(this).attr('id', $(this).attr('id').replace(/jp\d/, ('jp'+index)));
                                    }else if ($(this).hasClass('doinput')) {
                                        $(this).attr('id', $(this).attr('id').replace(/do\d/, ('do'+index)));
                                    }
                                    if($(this).attr('data-id') !== undefined) {
                                        $(this).attr('data-id', index);
                                    }
                                });
                            })
                        }
                    });
                @endif
            })
        </script>
    @endpush
@stop


@include('partials.admin.footer')