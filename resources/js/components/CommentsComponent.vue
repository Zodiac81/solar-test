<template>
    <div class="w-3/5 mx-auto">
        <div class="col-sm-6 col-md-6">
        <comment v-for="comment in comments" :comment="comment" :key="comment.id" :method="deleteComment" :updateComment="update"></comment>
    </div>
    </div>
</template>

<script>

    import Comment from './CommentComponent'


    export default {

        components: {Comment},

        data()  {
            return {
                comments: [],
                loading: false
            }
        },

        methods: {


            getAllComments() {

                this.loading = true
                axios.get('api/v1/comment')
                    .then((response) => {
                         this.comments = response.data
                    })
                    .finally(response => {
                        this.loading = false
                    })
            },

            deleteComment(comment) {

                const result = confirm('Delete ?');
                if(result){
                    axios.delete(`api/v1/comment/${comment.id}`).
                    then(() => { this.getAllComments() })
                }

            },

            update(comment, body) {
                axios.patch(`api/v1/comment/${comment.id}`, {
                    body : body
                }).then(() => { this.getAllComments() })
            },
        },

        mounted() {

            this.getAllComments()
        }

    }
</script>

<style scoped>

</style>