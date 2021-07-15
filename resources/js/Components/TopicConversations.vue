<template>
    <div class="flex flex-col w-full h-full">
        <div id="scrolling" class="=w-full p-2">
            <ul class="w-full" v-if="currentTopicConversations" scroll-region>
                <li class="flex items-center w-full mt-3" v-for="message in currentTopicConversations" :key="message.id">
                    <div class="flex flex-col mr-4">
                        <img src="/user.png" class="w-12 h-12 bg-gray-700 rounded-full contrast" alt="">
                        <span>{{ message.created_by.name }}</span>
                    </div>
                    <div class="p-2 bg-blue-200 rounded-md">
                        <div v-if="message.file_id">
                            <a :href="'/download/' + message.file.filename" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                {{ message.file.original_filename }}
                            </a>
                        </div>
                        <div v-else>
                            {{ message.message }}
                            
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: "TopicConversations",
    props: {
        currentTopicConversations: Array
    },
    data() {
        return {
            form: this.$inertia.form({
                _method: 'post',
                message: ''
            })
        }
    },
    methods: {
        writeMessage() {
            this.form.post(route('conversation.store', { topicId: this.$page.url.split('=')[1] }), {
               preserveScroll: true
            });
        },
        scrollingToBottom() {

            let limit = this.currentTopicConversations[this.currentTopicConversations.length - 1].id;
            const el = document.getElementById('scrolling');
            if (el) {
                el.scrollIntoView(false)
            }

        }
    },
    mounted() {
        if (this.currentTopicConversations) {
            const el = document.getElementById('scrolling');
            if (el) {
                el.scrollIntoView({block: "end" });
            }
        }
    }
}
</script>

<style scoped>
.contrast {
    filter: grayscale(1) invert(1);
}
</style>
