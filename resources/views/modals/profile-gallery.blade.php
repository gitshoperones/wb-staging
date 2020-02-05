<!-- Search Modal -->
<div class="modal fade" id="profile-gallery" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="">
        <div class="modal-dialog" style="width: 800px;">
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h4>Click any images you'd like to add to the quote</h4>
                </div>
                <div class="modal-body">
                    <div class="row jq-gallery" style="overflow: auto; max-height: 300px;">
                        @foreach($profileGallery as $item)
                            <div class="col-md-4 jq-img galImg">
                                <div class="selImg">
                                    <input type="checkbox" id="profile-gallery-{{ $item->id }}" value="{{ $item->id }}" name="profileGallery[]">
                                    <label for="profile-gallery-{{ $item->id }}"></label>
                                </div>
                                <img src="{{ Storage::url($item->meta_filename) }}" class="img-responsive selectImg" width="143" />
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group">
                    <a href="" data-dismiss="modal" class="btn wb-btn-orange">SELECT</a>
                    {{-- <a href="" data-dismiss="modal" class="btn wb-btn-primary">CLOSE</a> --}}
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script type="text/javascript">
    $('#addFromProfile').click(function() {
        $('#profile-gallery').modal('show');
    })

    $('.galImg input[type="checkbox"]').change(function() {
        var preview = $('#job-quote-gallery'),
            src = $(this).parents('.galImg').find('img.selectImg').attr('src'),
            item_id = $(this).attr('id'),
            item = `<div class="col-md-4 jq-img jobImg img-profile-gallery" data-galId="${item_id}">
                        <div class="delImg">
                            <i class="fa fa-close fa-2x" style="color: #ff0000;"></i>
                        </div>
                        <img src="${src}" class="img-responsive" width="143" />
                    </div>`;

        if($(this).is(':checked')) {
            preview.append(item)
        }else {
            preview.find(`div[data-galId="${item_id}"]`).remove()
        }
    })

    $('.selectImg').click(function(e) {
        var checkbox = $(this).parents('.galImg').find('input[type="checkbox"]');

        checkbox.trigger('click');
    })
</script>
@endpush