<template>
    <div class="flex flex-col items-stretch justify-start w-full overflow-y-hidden bg-white border-l-2 border-r-2 border-gray-100 lg:rounded-r-md xl:rounded-none">
        <!-- Header with name -->
        <div v-if="$page.props.user.current_team" class="flex flex-row items-center justify-between px-3 py-2 border-b-2 border-gray-100 bg-gray-50 bg-opacity-40">
            <div class="flex items-center">
                <inertia-link v-show="middleSection === 'topic-conversations'" :href="route('home')" :only="['middleSection']">
                    <button type="button" class="p-2 mr-2 text-gray-400 rounded-full hover:text-gray-600 hover:bg-gray-300 focus:outline-none focus:ring">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                        </svg>
                    </button>
                </inertia-link>
                <h2>
                    <span class="font-semibold text-blue-400">{{ $page.props.user.current_team.name }}</span>
                    <inertia-link v-show="middleSection === 'topics'" :href="route('home')" :only="['middleSection']">
                        <span class="font-semibold text-blue-400">
                        <span class="text-gray-500"> / </span>
                            Topics</span>
                    </inertia-link>
                    <span class="font-semibold text-blue-400" v-show="middleSection === 'topic-conversations'">
                        <inertia-link :href="route('home')" :only="['middleSection']">
                            <span class="font-semibold text-blue-400">
                            <span class="text-gray-500"> / </span>
                                Topics</span>
                        </inertia-link>
                            <span class="text-gray-500"> / </span>
                            Conversations</span>
                            <span class="text-gray-500"> / </span>
                            {{  }}
                    </h2>
            </div>
            <div class="flex flex-row">

                <button v-show="middleSection === 'topics'" @click="openShowAddTopicForm" type="button" class="p-2 ml-2 text-gray-400 rounded-full hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring" aria-label="Search">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </button>

                <button @click="changeCurrentLeftSide('search')" type="button" class="p-2 ml-2 text-gray-400 rounded-full hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring" aria-label="Search">
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                        <path d="M12.323,2.398c-0.741-0.312-1.523-0.472-2.319-0.472c-2.394,0-4.544,1.423-5.476,3.625C3.907,7.013,3.896,8.629,4.49,10.102c0.528,1.304,1.494,2.333,2.72,2.99L5.467,17.33c-0.113,0.273,0.018,0.59,0.292,0.703c0.068,0.027,0.137,0.041,0.206,0.041c0.211,0,0.412-0.127,0.498-0.334l1.74-4.23c0.583,0.186,1.18,0.309,1.795,0.309c2.394,0,4.544-1.424,5.478-3.629C16.755,7.173,15.342,3.68,12.323,2.398z M14.488,9.77c-0.769,1.807-2.529,2.975-4.49,2.975c-0.651,0-1.291-0.131-1.897-0.387c-0.002-0.004-0.002-0.004-0.002-0.004c-0.003,0-0.003,0-0.003,0s0,0,0,0c-1.195-0.508-2.121-1.452-2.607-2.656c-0.489-1.205-0.477-2.53,0.03-3.727c0.764-1.805,2.525-2.969,4.487-2.969c0.651,0,1.292,0.129,1.898,0.386C14.374,4.438,15.533,7.3,14.488,9.77z"></path>
                    </svg>
                </button>

                <button @click="changeCurrentLeftSide('profile')" type="button" class="p-2 ml-2 text-gray-400 rounded-full hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring" aria-label="Open">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd" />
                    </svg>
                </button>
                <button @click="changeCurrentLeftSide('group-settings')" type="button" class="p-2 ml-2 text-gray-400 rounded-full hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring" aria-label="More">
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24">
                        <path fill-rule="nonzero" d="M12,16 C13.1045695,16 14,16.8954305 14,18 C14,19.1045695 13.1045695,20 12,20 C10.8954305,20 10,19.1045695 10,18 C10,16.8954305 10.8954305,16 12,16 Z M12,10 C13.1045695,10 14,10.8954305 14,12 C14,13.1045695 13.1045695,14 12,14 C10.8954305,14 10,13.1045695 10,12 C10,10.8954305 10.8954305,10 12,10 Z M12,4 C13.1045695,4 14,4.8954305 14,6 C14,7.1045695 13.1045695,8 12,8 C10.8954305,8 10,7.1045695 10,6 C10,4.8954305 10.8954305,4 12,4 Z"/>
                    </svg>
                </button>
            </div>
        </div>


        <div class="flex-grow overflow-y-auto customScroll">
            <form @submit.prevent="postTopic($page.props.user.current_team_id)" v-if="showAddTopicForm" class="flex flex-row items-center justify-between p-3 myForm">
                <div class="flex flex-col flex-1 px-3">
                    <input v-model="topicForm.title" class="p-2 mb-4 text-sm bg-gray-100 border border-gray-300 rounded-md outline-none focus:border-gray-500 focus:ring-transparent title" spellcheck="false" placeholder="Title" type="text">
                    <textarea v-model="topicForm.description" class="p-3 text-sm bg-gray-100 border border-gray-300 rounded-md outline-none focus:ring-transparent focus:border-gray-500 description sec"
                              spellcheck="false"
                              placeholder="Describe everything about this post here"
                              max-rows="3"
                    ></textarea>
                    <div class="flex items-center justify-end w-full my-3">
                        <button @click="closeShowAddTopicForm" type="button" class="px-5 py-2 mr-2 text-sm text-white bg-gray-400 rounded-md focus:outline-none hover:bg-gray-500 hover:shadow-lg">Cancel</button>
                        <button type="submit" class="px-5 py-2 text-sm text-white bg-blue-500 rounded-md focus:outline-none hover:bg-blue-600 hover:shadow-lg">Post</button>
                    </div>
                </div>
            </form>
        <!-- Messages -->
        <!-- Input for writing a messages -->

            <messages :setCurrentTopic="setCurrentTopic" v-show="currentMiddleSection === 'topics'" :currentTopics="currentTopics" :changeCurrentMiddleSection="changeCurrentMiddleSection" />
            <topic-conversations
                :currentTopicConversations="currentTopicConversations"
                v-if="currentMiddleSection === 'topic-conversations'"
                :changeCurrentMiddleSection="changeCurrentMiddleSection"
            />
        </div>
        <form v-show="currentMiddleSection === 'topic-conversations'" @submit.prevent="writeMessage" class="flex flex-row items-center justify-between p-3 border-t-2 border-gray-200">
            <div class="">
                <button type="button" class="p-2 text-gray-400 rounded-full hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring" aria-label="Upload a files">
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                        <path d="M4.317,16.411c-1.423-1.423-1.423-3.737,0-5.16l8.075-7.984c0.994-0.996,2.613-0.996,3.611,0.001C17,4.264,17,5.884,16.004,6.88l-8.075,7.984c-0.568,0.568-1.493,0.569-2.063-0.001c-0.569-0.569-0.569-1.495,0-2.064L9.93,8.828c0.145-0.141,0.376-0.139,0.517,0.005c0.141,0.144,0.139,0.375-0.006,0.516l-4.062,3.968c-0.282,0.282-0.282,0.745,0.003,1.03c0.285,0.284,0.747,0.284,1.032,0l8.074-7.985c0.711-0.71,0.711-1.868-0.002-2.579c-0.711-0.712-1.867-0.712-2.58,0l-8.074,7.984c-1.137,1.137-1.137,2.988,0.001,4.127c1.14,1.14,2.989,1.14,4.129,0l6.989-6.896c0.143-0.142,0.375-0.14,0.516,0.003c0.143,0.143,0.141,0.374-0.002,0.516l-6.988,6.895C8.054,17.836,5.743,17.836,4.317,16.411"></path>
                    </svg>
                </button>
            </div>
            <div class="flex-1 px-3">
                <input
                    v-model="form.message"
                    type="text"
                    placeholder="Write your message ..."
                    class="w-full py-2 pl-2 mr-2 text-sm text-gray-400 placeholder-gray-500 bg-gray-600 border-gray-300 rounded-md outline-none search-input bg-opacity-10 focus:border-gray-500 focus:ring-transparent focus:outline-none"
                />
            </div>
            <div class="flex flex-row">
                <button type="button" class="p-2 text-gray-400 rounded-full hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring" aria-label="Show emojis">
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M4.285 9.567a.5.5 0 0 1 .683.183A3.498 3.498 0 0 0 8 11.5a3.498 3.498 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.498 4.498 0 0 1 8 12.5a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/>
                    </svg>
                </button>
                <button type="button" class="p-2 ml-2 text-gray-400 rounded-full hover:text-gray-600 hover:bg-gray-100 focus:outline-none focus:ring" aria-label="Record a voice">
                    <svg class="w-6 h-6 fill-current" viewBox="0 0 20 20">
                        <path d="M10.403,15.231v2.035h2.827c0.223,0,0.403,0.181,0.403,0.404c0,0.223-0.181,0.403-0.403,0.403H6.77c-0.223,0-0.404-0.181-0.404-0.403c0-0.224,0.181-0.404,0.404-0.404h2.826v-2.035C6.89,15.024,4.751,12.758,4.751,10c0-0.223,0.181-0.403,0.404-0.403S5.559,9.777,5.559,10c0,2.449,1.992,4.441,4.441,4.441c2.449,0,4.441-1.992,4.441-4.441c0-0.223,0.182-0.403,0.404-0.403s0.403,0.18,0.403,0.403C15.248,12.758,13.108,15.024,10.403,15.231 M13.026,4.953V10c0,1.669-1.357,3.027-3.027,3.027S6.972,11.669,6.972,10V4.953c0-1.669,1.358-3.028,3.028-3.028S13.026,3.284,13.026,4.953M12.221,4.953c0-1.225-0.996-2.22-2.221-2.22s-2.221,0.995-2.221,2.22V10c0,1.225,0.996,2.22,2.221,2.22s2.221-0.995,2.221-2.22V4.953z"></path>
                    </svg>
                </button>
            </div>
        </form>

    </div>
</template>

<script>
import Messages from "@/Components/Messages";
import TopicConversations from "@/Components/TopicConversations";

export default {
    name: "MiddleSection",
    components: {
        Messages,
        TopicConversations
    },
    props: {
        changeCurrentLeftSide: Function,
        currentTopics: Array,
        middleSection: String,
        currentTopicConversations: Array
    },
    data() {
        return {
            showAddTopicForm: false,
            currentMiddleSection: 'topics',
            currentTopic: "",
            topicForm: this.$inertia.form({
                _method: "post",
                title: "",
                description: "",
                team_id: null
            }),
            form: this.$inertia.form({
                _method: 'post',
                message: ''
            })
        }
    },
    methods: {
        openShowAddTopicForm() {
            this.showAddTopicForm = true;
        },
        closeShowAddTopicForm() {
            this.showAddTopicForm = false;
        },
        changeCurrentMiddleSection(component) {
            this.currentMiddleSection = component;
        },
        setCurrentTopic(topicName) {
            this.currentTopic = topicName;
        },
        postTopic(teamId) {
            this.topicForm.team_id = teamId;
            this.topicForm.post(route('topic.store'
            ), {
                preserveState: true,
                replace: false,
                onSuccess: () => {
                    this.topicForm.reset();
                    this.showAddTopicForm = false;
                }
            })
        },
        writeMessage() {
            this.form.post(route('conversation.store', { topicId: this.$page.url.split('=')[1] }), {
                preserveScroll: true,
                onSuccess: () => {
                    this.form.reset();
                }
            });
        }
    },
    mounted() {
        this.currentMiddleSection = this.middleSection;
    }
}
</script>

<style scoped>
 .customScroll::-webkit-scrollbar {
        width: 6px;               /* width of the entire scrollbar */
    }
    .customScroll::-webkit-scrollbar-track {
        background: lightgrey;        /* color of the tracking area */
    }
    .customScroll::-webkit-scrollbar-thumb {
        background-color: gray;    /* color of the scroll thumb */
        border-radius: 10px;       /* roundness of the scroll thumb */ /* creates padding around scroll thumb */
    }
</style>
