<template>
    <div class="flex flex-col w-full h-full">
        <div id="scrolling" class="=w-full px-3">
            <ul class="w-full" v-if="currentTopicConversations" scroll-region>

                <li
                    v-for="message in currentTopicConversations" :key="message.id" class="flex mt-1 space-x-3"
                    :class="$page.props.user.id === message.created_by.id ? 'justify-end' : 'justify-start'"
                >
                    <div :class="$page.props.user.id === message.created_by.id ? 'flex flex-col items-end' : 'flex flex-col items-start'">
                        <div
                            :class="$page.props.user.id === message.created_by.id ? 'bg-blue-400 text-white rounded-l-lg rounded-br-lg' : 'bg-gray-300 rounded-r-lg rounded-bl-lg'"
                            class="bg-gray-300 p-3 mt-3 max-w-3xl maxHeight"
                        >
                            <span
                                :class="$page.props.user.id === message.created_by.id ? 'text-gray-200 justify-end' : 'text-gray-500 justify-start'"
                                class="text-xs flex items-center  text-gray-500 mt-1 mr-1 mb-2">{{ message.created_by.name }}</span>
                            <p class="text-sm">{{ message.message }}</p>
                            <div v-if="message.file">
                                <a :href="'/download/' + message.file.filename" target="_blank" class="flex flex-col  justify-center mt-3 text-xs font-semibold">
                                    <img v-if="message.file.extension === 'pdf'" src="/pdf.png" alt="pdf" class="h-8 w-8 mr-2" />
                                    <img v-if="message.file.extension === 'xlsx'" src="/excel.png" alt="Excell" class="h-8 w-8 mr-2" />
                                    <img v-if="message.file.extension === 'doc'" src="/word.png" alt="Word" class="h-8 w-8 mr-2" />
                                    <img
                                        ref="convImg"
                                        v-if="message.file.extension === 'jfif' || message.file.extension === 'jpg' || message.file.extension === 'jpeg' || message.file.extension === 'png'"
                                        :src="`/image-get/${message.file.filename}`" alt="Img" class="imageSize"
                                    />
                                    <img v-if="message.file.extension === 'rtf' || message.file.extension === 'txt'" src="/doc.png" alt="Document" class="h-8 w-8 mr-2" />
                                    {{ message.file.original_filename }}
                                </a>
                            </div>
                        </div>
                        <span class="text-xs text-gray-500 mt-1 mx-2 leading-none">{{ calculateMessageTime(message.created_at) }}</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import moment from 'moment';

export default {
    name: "TopicConversations",
    props: {
        currentTopicConversations: Array
    },
    methods: {
        scrollingToBottom() {
            const el = document.getElementById('scrolling');
            if (el) {
                el.scrollIntoView(false)
            }

        },
        calculateMessageTime(createdAt) {
            return moment(createdAt).fromNow();
        }
    },
    mounted() {
        if (this.currentTopicConversations) {
            this.scrollingToBottom();
        }
    }
}
</script>

<style scoped>
    .contrast {
        filter: grayscale(1) invert(1);
    }
    .imageSize {
        max-width: 100%;
        height: auto;
        aspect-ratio: 6/4;
        object-fit: cover;
    }
</style>
