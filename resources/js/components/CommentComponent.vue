<template>
    <div>
        <div class="alert-message alert-message-default">
            <h4>{{userName}}</h4>
            <time> {{ comment.created_at }}</time>
            <p>{{ comment.body }}</p>
            <div class="text-right">
                <div class="actions">

                    <button @click.prevent="showCommentInput = ! showCommentInput; setReply(comment)" title="Reply">
                        <img src="https://img.icons8.com/android/24/000000/reply-arrow.png"/>
                    </button>

                    <button @click.prevent="showCommentInputUpdate = ! showCommentInputUpdate; setUpdate(comment)"
                            title="Update">
                        <img src="https://img.icons8.com/ios-glyphs/30/000000/approve-and-update.png"/>
                    </button>

                    <button @click.prevent="deleteReply(comment)" title="Delete"><img
                            src="https://img.icons8.com/ios-glyphs/30/000000/delete-sign.png"/>
                    </button>

                </div>
            </div>
            <div v-if="showCommentInput" class="mt-3">
                <div class="d-flex">
                    <input v-model="body"
                           class="border border-indigo-200  hover:bg-indigo-100 focus:bg-indigo-100 outline-none pr-12 px-3 py-2 rounded text-sm w-100"
                           placeholder="Write something">
                    <button @click="postComment">Send</button>
                </div>
            </div>
            <div v-if="showCommentInputUpdate" class="mt-3">
                <div class="d-flex">
                    <input v-model="body"
                           class="border border-indigo-200  hover:bg-indigo-100 focus:bg-indigo-100 outline-none pr-12 px-3 py-2 rounded text-sm w-100">
                    <button @click="update(comment)">Update</button>
                </div>
            </div>
        </div>

        <!-- replies -->
        <div class="replies px-4 col-sm-6 col-md-12">
            <comment v-for="reply in comment.replies" :comment="reply" :key="reply.id" :method="method"
                     :updateComment="updateComment"></comment>
        </div>


    </div>
</template>

<script>
    export default {
        props: {
            comment: {type: Object},
            method: {type: Function},
            updateComment: {type: Function},
        },

        data() {
            return {
                body: '',
                comments: [],
                userNameArray: ['Peter', 'John', 'Anne', 'Michael'],
                userName: false,
                showCommentInput: false,
                showCommentInputUpdate: false,
                replyingTo: {},


            }
        },

        methods: {

            postComment() {
                console.log(this.body)
                axios.post(`api/v1/comment`, {
                    parent_id: this.replyingTo.id ? this.replyingTo.id : null,
                    body: this.body,
                }).then(response => {
                    this.body = ''
                    this.showCommentInput = false
                    if (!this.replyingTo.id) {
                        this.comments.push(response.data)
                    } else {
                        this.replyingTo.replies.push(response.data)
                    }

                })
            },

            deleteReply(comment) {
                this.method(comment)
            },

            setUpdate(comment) {
                this.showCommentInput = false
                this.body = comment.body
            },

            update(comment) {
                this.showCommentInputUpdate = false
                this.updateComment(comment, this.body)
                this.body = ''
            },

            setReply(comment) {
                this.showCommentInputUpdate = false
                this.replyingTo = comment
                this.body = ''
            }
        },

        mounted() {
            const random = Math.floor(Math.random() * this.userNameArray.length);
            this.userName = this.userNameArray[random]
        }

    }
</script>

<style scoped>

    .actions img {
        width: 15px;
    }

    .alert-message {
        margin: 20px 0;
        padding: 20px;
        border-left: 3px solid #eee;
    }

    .alert-message h4 {
        margin-top: 0;
        margin-bottom: 5px;
    }

    .alert-message p:last-child {
        margin-bottom: 0;
    }

    .alert-message code {
        background-color: #fff;
        border-radius: 3px;
    }

    .alert-message-success {
        background-color: #F4FDF0;
        border-color: #3C763D;
    }

    .alert-message-success h4 {
        color: #3C763D;
    }

    .alert-message-default {
        background-color: #EEE;
        border-color: #B4B4B4;
    }

    .alert-message-default h4 {
        color: #000;
    }

</style>