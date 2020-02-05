<template>
    <span class="heart" :title="title" @click="send">
        <i class="fa fa-heart red" v-if="isSaved" ></i>
        <i class="fa fa-heart-o" v-else></i>
    </span>
</template>
<script>
    export default {
        props: ['saved', 'jobId'],
        computed: {
            isSaved() {
                return this.save;
            },
            title() {
                return this.isSaved ? 'Remove saved job' : 'Save job';
            }
        },
        data() {
            return {
                save: this.saved,
            }
        },
        methods: {
            send() {
                NProgress.start();

                if (this.isSaved) {
                    this.deleteSavedJob();
                } else {
                    this.addSavedJob();
                }
            },
            deleteSavedJob() {
                let self = this;

                axios.post('/dashboard/saved-jobs/'+ self.jobId, {
                    _method: 'DELETE'
                }).then(() => {
                    self.save = false;
                    NProgress.done();
                });
            },
            addSavedJob() {
                let self = this;

                axios.post('/dashboard/saved-jobs', {
                    job_post_id: self.jobId
                }).then(() => {
                    self.save = true;
                    NProgress.done();
                });
            }
        },
    }
</script>