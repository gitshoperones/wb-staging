<!-- Modal -->
<div class="modal fade wb-modal-password" id="verify-email" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div id="wb-modal-success" class="modal-dialog">
        <div class="modal-dialog">
            <div class="logo-container">
                <div class="logo">
                    <span><i class="fa fa-key"></i></span>
                </div>
            </div>
            <div class="modal-content text-center">
                <div class="modal-header">
                    <h4>{{ $title }}</h4>
                </div>
                <div class="modal-body">
                    <p>
                        {{ $body }}
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script type="text/javascript">
    $(document).ready(function(){
        $('#verify-email').modal('show');
    })
</script>
@endpush