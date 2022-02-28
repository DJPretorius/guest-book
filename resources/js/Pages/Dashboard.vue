<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
import { Head, useForm} from '@inertiajs/inertia-vue3';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import { Inertia } from '@inertiajs/inertia'
import axios from 'axios';

defineProps({
    posts: Object,
    sendReplyRoute: String,
    createCommentRoute: String
})
</script>

<script>
import Comment from '@/Components/Comment.vue';
export default {
    components: {
        'comment' : Comment
    },
}
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="pt-12 pb-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        Leave a message about your stay
                    </div>
                </div>
            </div>
        </div>
        <div class="pb-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <comment
                            :send-reply-route="sendReplyRoute"
                            :create-comment-route="createCommentRoute"
                            :post="null"
                        ></comment>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <p class="text-lg pb-2">History</p>
                <template v-for="post in posts.data.data" :key="post.id">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <comment
                                :send-reply-route="sendReplyRoute"
                                :create-comment-route="createCommentRoute"
                                :post="post"
                            ></comment>
                        </div>
                    </div>
                    
                </template>
                <p v-if="posts.data.data.length <= 0" class="font-size-4">No Comments Yet</p>
                
                <paginator class="flex justify-center mt-2"
                    :links="posts.links"
                ></paginator>
            </div>
        </div>
        
    </BreezeAuthenticatedLayout>
</template>
