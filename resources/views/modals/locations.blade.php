<!-- Search Modal -->
{{-- @php	$locs = $locations->pluck('name');	@endphp --}}
<template>
    <div class="modal fade" id="locations" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div id="#wb-settings-block" class="modal-dialog modal-lg">
            <div class="modal-content" style="padding: 30px;">
                <div class="row">
                    <div class="col-md-4">
                        <h4 class="title">Locations Category 1</h4> <br />
                        <div class="form-group">
                            <input type="checkbox" id="loc1" value="Location 1"><label for="loc1">Location 1</label> <br />
                        </div>
                    </div>
                </div><!-- /.row -->
                <br /> <br />
                <a href="#" class="btn wb-btn-outline-primary blur">Save</a>
            </div><!-- /.wb-box -->
        </div>
    </div>
</template>
@push('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$('#success-confirmation').modal('show');
	})
</script>
@endpush