<template>
    <div class="flex flex-col flex-auto h-full px-5">
<!--        <div class="flex flex-col divide-y-2 divide-gray-100">-->
<!--            <div v-for="topic in currentTopics" :key="topic.id" class="flex flex-col py-8">-->
<!--                <div class="flex flex-col flex-shrink-0 mb-6 md:w-64 md:mb-0">-->
<!--                <span class="font-semibold text-gray-700 title-font">{{ topic.created_by.name }}</span>-->
<!--                <span class="mt-1 text-sm text-gray-500">{{ getFormattedDate(topic.created_at) }}</span>-->
<!--                </div>-->
<!--                <div class="md:flex-grow">-->
<!--                <h2 class="mb-2 text-2xl font-medium text-gray-900 title-font">{{ topic.title }}</h2>-->
<!--                <p class="leading-relaxed">{{ topic.description }}</p>-->
<!--                <inertia-link :href="route('home', { topicId: topic.id })" :only="['topicConversations', 'middleSection']" class="inline-flex items-center mt-4 text-indigo-500">Enter Conversations-->
<!--                    <svg class="w-4 h-4 ml-2" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">-->
<!--                    <path d="M5 12h14"></path>-->
<!--                    <path d="M12 5l7 7-7 7"></path>-->
<!--                    </svg>-->
<!--                </inertia-link>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->

        <div v-if="currentTopics">


            <inertia-link
                :href="route('home', { topicId: topic.id, tn: topic.title })"
                :only="['topicConversations', 'currentTopicConversations', 'middleSection', 'topicName']"
                v-for="topic in currentTopics"
                :key="topic.id"
            >
                <div class="w-full mx-auto mt-2 hover:bg-gray-200 rounded-md my-4 p-5 bg-white">
                    <div class="flex items-center">
                        <span class="font-light text-xs text-gray-600">{{ getFormattedDate(topic.created_at) }}</span>
                        <span class="flex flex-row">
<!--                        <div class="mr-4">-->
                            <!--                            <img src="/user.png" class="w-8 h-8 bg-gray-700 rounded-full contrast" alt="">-->
                            <!--                        </div>-->
                        <div class="flex flex-col justify-center">
                            <h2 class="text-sm font-semibold text-blue-400">&nbsp;@{{ topic.created_by.name }}</h2>
                        </div>
                    </span>
                    </div>
                    <div>
                        <span class="text-base font-bold text-gray-700 hover:text-gray-600">{{ topic.title }}</span>
                        <p class="mt-2 text-sm text-gray-600">
                            {{ topic.description }}
                        </p>
                    </div>
                </div>
<!--                <div class="flex items-center justify-between mt-1">-->
<!--                    <inertia-link  :href="route('home', { topicId: topic.id })" :only="['topicConversations', 'currentTopicConversations', 'middleSection', 'topicName']" class="inline-flex items-center mt-4 text-indigo-500">-->
<!--                        <button type="button" class="px-5 py-2 text-sm text-white bg-gray-400 rounded-md focus:outline-none hover:bg-gray-500 hover:shadow-lg">-->
<!--                            Messages-->
<!--                        </button>-->
<!--                    </inertia-link>-->
<!--                </div>-->
            </inertia-link>
        </div>
    </div>
</template>

<script>
import moment from 'moment';

export default {
    name: "Messages",
    props: {
        currentTopics: Array,
        changeCurrentMiddleSection: Function,
        setCurrentTopic: Function
    },
    methods: {
        getFormattedDate(date) {
            return moment(date).format("DD MMM YYYY H:m");
        }
    }
}
</script>

<style scoped>
 .contrast {
        filter: grayscale(1) invert(1);
    }
</style>
