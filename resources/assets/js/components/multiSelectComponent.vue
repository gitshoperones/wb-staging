<template>
    <dl class="selectdropdown" style="width: 100%;">
        <dt>
            <a class="dropdown">
                <p class="multiSel">
                    <span class="tag" v-for="item in uSelected"> {{ item+', ' }} </span>
                </p>
            </a>
        </dt>
        <dd style="max-width: 600px; margin: auto;">
            <div>
                <ul :class="{ show: selectVisible }" style="color: #353554">
                    <li v-for="(item, index) in options">
                        <input type="checkbox"
                            :name="customName+'[]'"
                            :id="customName+item.id"
                            v-model="uSelected"
                            :value="item.name" />
                        <label :for="customName+item.id">{{ item.name }}</label>
                    </li>
                </ul>
            </div>
        </dd>
    </dl>
</template>
<script>
    export default {
        props: ['selected', 'options', 'customName'],
        data() {
            return {
                uSelected:  this.selected || [],
                selectVisible: false,
            }
        },
        methods: {
            toggleDropdown() {
                this.selectVisible = !this.selectVisible;
            },
        },
    }
</script>