<script setup>
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeButton from '@/Components/Button.vue';
import { Inertia } from '@inertiajs/inertia'
import axios from 'axios';
</script>

<template>
    <div class="bg-white overflow-hidden sm:rounded-lg">
        <div class="p-2 bg-white">
            <template v-if="post != null">
                <p><span class="font-bold">{{ post.user.data.name }}</span> - {{ post.description }}</p> 
                <p class="font-light">{{ post.created_at }}</p>
                <a href="#" v-on:click="replyingId = post.id">Reply</a>&nbsp;<a v-if="deleteRoute != null" href="#" v-on:click="deletePost(post.id)">Delete</a>
                <template v-if="replyingId == post.id">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-2 bg-white border-b border-gray-200">

                            <form @submit.prevent="reply">
                                <div class="bg-white shadow-sm max-w-7xl">
                                    <div >
                                        <BreezeInput id="enter_comment" type="text" class="mt-1 block w-full" v-model="comment" required />
                                    </div>
                                </div>
                                <div class="flex justify-end mt-2">
                                    <BreezeButton class="" :class="{ 'opacity-25': processing }" :disabled="processing">
                                        Submit
                                    </BreezeButton>
                                </div>
                            </form>
                        </div>
                    </div>
                </template>
                <template v-if="post.children.data.length > 0">
                    <div v-for="childPost in post.children.data" :key="childPost.id">
                        <Comment
                            :send-reply-route="sendReplyRoute"
                            :post="childPost"
                            :delete-route="deleteRoute"
                        ></Comment>
                    </div>
                </template>
            </template>
            <template v-else>
                <form @submit.prevent="submit">
                    <div class="bg-white shadow-sm max-w-7xl">
                        <div >
                            <BreezeLabel for="enter_comment" value="Comment"/>
                            <BreezeInput id="enter_comment" type="text" class="mt-1 block w-full" v-model="comment" required />
                        </div>
                    </div>
                    <div class="flex justify-end mt-2">
                        <BreezeButton class="" :class="{ 'opacity-25': processing }" :disabled="processing">
                            Submit
                        </BreezeButton>
                    </div>
                </form>
            </template>
        </div>
    </div>
</template>

<script>
export default {
    name: "Comment",
    props: {
        post : Object,
        sendReplyRoute: String,
        createCommentRoute: String,
        deleteRoute : String
    },
    data() {
        return {
            replyingId : null,
            processing: false,
            comment : ''
        }
    },
    methods: {
        reply() {
            this.processing = true;
            axios.post(`${this.sendReplyRoute}/${this.replyingId}`, {
                comment : this.comment
            }).then(response => {
                console.log("comment", response)
                this.processing = false;
                this.comment = "";
                this.replyingId = null
                Inertia.reload()
            }).catch(error => {
                console.log("error", error);
                this.processing = false;
            })
        },
        submit() {
            this.processing = true;
            console.log("send comment url", this.createCommentRoute)
            axios.post(`${this.createCommentRoute}`, {
                comment : this.comment
            }).then(response => {
                console.log("comment", response)
                this.processing = false;
                this.comment = "";
                Inertia.reload()
            }).catch(error => {
                console.log("error", error);
                this.processing = false;
            })
        },
        deletePost(postId) {
            this.processing = true;
            axios.delete(`${this.deleteRoute}/${postId}`)
            .then(response => {
                console.log("comment", response)
                this.processing = false;
                this.comment = "";
                Inertia.reload()
            }).catch(error => {
                console.log("error", error);
                this.processing = false;
            })
        }
    }
}
</script>