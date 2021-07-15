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
                        {{ message.message }}
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
