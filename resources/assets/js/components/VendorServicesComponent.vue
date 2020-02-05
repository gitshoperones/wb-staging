<template>
    <div>
        <dl class="selectdropdown" style="width: 100%;">
            <dt style="max-width: 600px; margin: auto;">
                <a href="#" style="min-height: 58px; text-align: center;">
                    <p style="text-align: center; text-transform: none;">
                        <span class="tag" v-for="expertise in vExpertises"> {{ expertise+', ' }} </span>
                    </p>
                    <div class="expertise-title">BUSINESS SERVICES</div>
                    <span @click.prevent="toggleDropdown()"
                        class="btn wb-btn-orange mini" style="color: #fff;">
                        Edit Your Services
                    </span>
                </a>
            </dt>
            <dd style="max-width: 600px; margin: auto;">
                <div class="mutliSelect">
                    <ul :class="{ show: selectVisible }">
                        <li v-for="(expertise, index) in JSON.parse(expertises)">
                            <input type="checkbox"
                                :id="'exp'+index"
                                v-model="vExpertises"
                                name="expertises[]"
                                class="vendor-expertise"
                                :value="expertise" />
                            <label :for="'exp'+index">{{ expertise }}</label>
                        </li>
                    </ul>
                </div>
            </dd>
        </dl>
        <property-types v-if="hasVenue"
            :property-types="propertyTypes"
            :vendor-property-types="vendorPropertyTypes"
            style="color: #fff;"></property-types>
        <property-features v-if="hasVenue"
            :property-features="propertyFeatures"
            :vendor-property-features="vendorPropertyFeatures"
            style="color: #fff;"></property-features>
    </div>
</template>
<script>
    import PropertyTypes from './VendorPropertyTypesComponent';
    import PropertyFeatures from './VendorPropertyFeatures';

    export default {
        components: {
            PropertyTypes,
            PropertyFeatures
        },
        props: [
            'guestsCapacity',
            'vendorExpertises',
            'expertises',
            'propertyTypes',
            'vendorPropertyTypes',
            'propertyFeatures',
            'vendorPropertyFeatures',
        ],
        computed: {
            hasVenue() {
                return this.vExpertises.includes('Venues');
            }
        },
        data() {
            return {
                vExpertises: JSON.parse(this.vendorExpertises),
                selectVisible: false,
            }
        },
        methods: {
            toggleDropdown() {
                this.selectVisible = !this.selectVisible;
            }
        },
    }
</script>