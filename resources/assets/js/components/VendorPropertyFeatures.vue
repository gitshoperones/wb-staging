<template>
    <dl class="selectdropdown" style="width: 100%;">
        <dt style="max-width: 600px; margin: auto;">
            <a style="min-height: 58px; text-align: center;"
                class="select-btn">
                <p style="text-align: center; text-transform: none;">
                    <span class="tag" v-for="item in vPropertyFeatures"> {{ item+', ' }} </span>
                </p>
                <div class="expertise-title">PROPERTY FEATURES</div>
                <span @click.prevent="toggleDropdown()"
                    class="btn wb-btn-orange mini"
                    style="color: #fff;">
                    Edit Property Features
                </span>
            </a>
        </dt>
        <dd style="max-width: 600px; margin: auto;">
            <div class="mutliSelect">
                <ul :class="{ show: selectVisible }" style="color: #353554">
                    <li v-for="(item, index) in JSON.parse(propertyFeatures)">
                        <input type="checkbox"
                            :id="'other-req-'+index"
                            v-model="vPropertyFeatures"
                            class="vendor-property-features"
                            :value="item" />
                        <label :for="'other-req-'+index">{{ item }}</label>
                    </li>
                </ul>
            </div>
        </dd>
    </dl>
</template>
<script>
    export default {
        props: ['vendorPropertyFeatures', 'propertyFeatures'],
        data() {
            return {
                vPropertyFeatures: JSON.parse(this.vendorPropertyFeatures) || [],
                selectVisible: false,
            }
        },
        methods: {
            toggleDropdown() {
                this.selectVisible = !this.selectVisible;
            }
        }
    }
</script>