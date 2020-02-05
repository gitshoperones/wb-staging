<template>
	<div class="loc-value editOn">
		<div class="expertise-title"><i class="fa fa-map-marker"></i> SERVICE REGIONS</div>
		<div class="resizing-input editOn">
			<span class="tag" v-for="city in cities">{{ city+', ' }}</span>
		</div>
		<a class="btn wb-btn-orange mini" style="color: #fff;" @click="show">Edit Your Service Locations</a>
		<div class="modal fade" id="locations" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
			<div id="#wb-settings-block" class="modal-dialog modal-lg">
				<div class="modal-content location-modal ss" style="padding: 30px;">
					<div class="overfy">
						<div class="row" v-for="(group, key) in data">
							<div class="col-md-4" v-for="(location, state) in group">
								<h4 class="title">{{ state }}</h4> <br />
								<div class="form-group" v-for="loc in location">
									<input type="checkbox"
                                        :id="'loc'+loc.id"
                                        class="vendor-service-locations"
                                        :value="loc.name"
                                        v-model="cities">
									<label style="color:#353554!important" class="label" :for="'loc'+loc.id">
										{{ loc.name }} {{ loc.abbr ? ' - '+loc.abbr : '' }}
									</label> <br />
								</div>
							</div>
						</div><!-- /.row -->
					</div><!-- /.overfy -->
					<br /> <br />
				   <div class="action"> <a href="#" class="btn wb-btn-primary blur" @click="hide">Save</a></div><!-- /.action -->
				</div><!-- /.wb-box -->
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		computed: {
			data() {
				return JSON.parse(this.locations);
			}
		},
		data() {
			return {
				modal: false,
				cities: JSON.parse(this.query) || []
			}
		},
		methods: {
			show() {
				$('#locations').modal('show');
			},
			hide() {
				$('#locations').modal('hide');
			}
		},
		props: ['locations', 'query', 'defaultLabel'],
	}
</script>