<?=$hasMessage = false?>
<div class="modal fade" id="form-info" tabindex="-1" role="dialog" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div id="wb-modal-success" class="modal-dialog">
        <div class="modal-dialog">
            <div class="modal-content text-center">
                <div class="modal-body ">
                    @if ($errors->any())
                        <?php $hasMessage = true; ?>
                        <div class="alert wd-alert-danger fade in">
                            @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    @if(session()->has('message'))
                        <?php $hasMessage = true; ?>
                        <div class="alert wd-alert-danger fade in">
                            {{ session()->get('message') }}
                        </div>
                    @endif

                    @if (session('status'))
                        <?php $hasMessage = true; ?>
                        <div class="alert wd-alert-danger fade in">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(session()->has('success_message'))
                        <?php $hasMessage = true; ?>
                        <div class="alert wb-alert-success fade in">
                            {{ session()->get('success_message') }}
                        </div>
                    @endif

                    @if(session()->has('message'))
                        <?php $hasMessage = true; ?>
                        <div class="alert wb-alert-success fade in">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@if ($hasMessage)
    @push('scripts')
        <script type="text/javascript">
            $(document).ready(function(){
                $('#form-info').modal('show');
            })
        </script>
    @endpush
@endif