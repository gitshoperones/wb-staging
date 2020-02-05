<template>
    <dl class="selectdropdown" style="width: 100%;">
        <dt style="max-width: 600px; margin: auto;">
            <a style="min-height: 58px; text-align: center;"
                class="select-btn">
                <p style="text-align: center; text-transform: none;">
                    <span class="tag" v-for="type in vPropertyTypes"> {{ type+', ' }} </span>
                </p>
                <div class="expertise-title">PROPERTY TYPES</div>
                <span @click.prevent="toggleDropdown()"
                    class="btn wb-btn-orange mini"
                    style="color: #fff;">
                    Edit Property Types
                </span>
            </a>
        </dt>
        <dd style="max-width: 600px; margin: auto;">
            <div class="mutliSelect">
                <ul :class="{ show: selectVisible }" style="color: #353554">
                    <li v-for="(item, index) in JSON.parse(propertyTypes)">
                        <input type="checkbox"
                            :id="'type'+index"
                            v-model="vPropertyTypes"
                            class="vendor-property-types"
                            :value="item" />
                        <label :for="'type'+index">{{ item }}</label>
                    </li>
                </ul>
            </div>
        </dd>
    </dl>
</template>
<script>
    export default {
        props: ['vendorPropertyTypes', 'propertyTypes'],
        data() {
            return {
                vPropertyTypes: JSON.parse(this.vendorPropertyTypes) || [],
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