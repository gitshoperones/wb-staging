<template>
    <span class="heart" :title="title" @click="send">
        <i class="fa fa-heart red" v-if="isFavorite" ></i>
        <i class="fa fa-heart-o" v-else></i>
    </span>
</template>
<script>
    export default {
        props: ['favorited', 'vendorId'],
        computed: {
            isFavorite() {
                return this.favorite;
            },
            title() {
                return this.isFavorite ? 'Remove from your favorite vendors' : 'Add to your favorite vendors';
            }
        },
        data() {
            return {
                favorite: this.favorited,
            }
        },
        methods: {
            send() {
                NProgress.start();

                if (this.isFavorite) {
                    this.deleteFavorite();
                } else {
                    this.addFavorite();
                }
            },
            deleteFavorite() {
                let self = this;

                axios.post('/dashboard/favorite-vendors/'+ self.vendorId, {
                    _method: 'DELETE'
                }).then(() => {
                    self.favorite = false;
                    NProgress.done();
                });
            },
            addFavorite() {
                let self = this;

                axios.post('/dashboard/favorite-vendors', {
                    vendor_id: self.vendorId
                }).then(() => {
                    self.favorite = true;
                    NProgress.done();
                });
            }
        },
    }
</script>