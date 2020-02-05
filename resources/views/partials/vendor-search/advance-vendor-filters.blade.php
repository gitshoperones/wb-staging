<div class="row adv-search fade">
	<div class="col-md-3">
		<div class="form-group">
			<label for="owner_name">Business Name</label>
			<div class="input-bordered">
				<input type="text" class="form-control" name="business_name" value="{{ request('business_name') }}">
			</div>
		</div>
	</div>
	<div class="col-md-3 hidden">
		<div class="form-group">
			<label for="">PROPERTY TYPE (VENUE SEARCHES)</label>
			<div class=""> <!-- class: dropdown -->
				<div class="form-group">
					<multi-select
					custom-name="property_types"
					:options="{{ json_encode($propertyTypes) }}"
					:selected="{{ json_encode(request('property_types')) }}"
					></multi-select>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-3 hidden">
		<div class="form-group">
			<label for="">PROPERTY FEATURES (VENUE SEARCHES)</label>
			<div class=""> <!-- class: dropdown -->
				<div class="form-group">
					<multi-select
					custom-name="property_features"
					:options="{{ json_encode($propertyFeatures) }}"
					:selected="{{ json_encode(request('property_features')) }}"
					></multi-select>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-3">
		<div class="form-group">
			<label for="owner_name">PROPERTY CAPACITY (VENUE SEARCHES)</label>
			<div class="input-bordered">
				<input type="text" class="form-control" name="venue_capacity" value="{{ request('venue_capacity') }}">
			</div><!-- /.checkbox -->
		</div>
	</div>
</div><!-- /.row -->

@push('scripts')
<script type="text/javascript">
	$('.toggle-advsearch').on('click', function(event) {
		event.preventDefault();
		/* Act on the event */
		$('.adv-search').toggleClass('active')
	});
</script>
@endpush