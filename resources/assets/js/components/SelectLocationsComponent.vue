<template>
	<div class="">
		<div class="form-group selectdropdown" data-toggle="modal" data-target="#locations" >
			<dt>
				<a>
					<p class="multiSel">
						<span v-for="city in cities">{{ city+', ' }}</span>
						<span v-show="cities.length <= 0">{{ label }}</span>
						<input type="hidden" :value="city" name="locations[]" v-for="city in cities">
					</p>
				</a>
			</dt>
		 </div>
		<div class="modal fade" id="locations" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
			<div id="#wb-settings-block" class="modal-dialog modal-lg">
				<div class="modal-content location-modal" style="padding: 30px;">
					<div class="row" v-for="(group, key) in data">
						<div class="col-md-4" v-for="(location, state) in group">
							<h4 class="title">{{ state }}</h4> <br />
							<div class="form-group" v-for="loc in location">
								<input type="checkbox" :id="'loc'+loc.id" :value="loc.name" v-model="cities">
								<label style="color:#353554!important" class="label" :for="'loc'+loc.id">
                                    {{ loc.name }} {{ loc.abbr ? ' - '+loc.abbr : '' }}
                                </label> <br />
							</div>
						</div>
					</div><!-- /.row -->
					<br /> <br />
					<a href="#" class="btn wb-btn-primary blur" @click="hideModal">Save</a>
				</div><!-- /.wb-box -->
			</div>
		</div>
	</div>
</template>

<script>
	export default {
		computed: {
			label() {
				return this.defaultLabel || '';
			},
			data() {
				return JSON.parse(this.locations);
			},
		},
		data() {
			return {
				cities: JSON.parse(this.query) || []
			}
		},
		props: ['locations', 'query', 'defaultLabel'],
		methods: {
			hideModal() {
				$('#locations').modal('hide');
				$('#onboarding-vendor2').modal('show');
			},
        }
	}
</script>