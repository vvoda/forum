<template>
        <div class="h-screen bg-gray-100 rounded-r-md p-2 customScroll overflow-y-auto">
            <header class="flex flex-row justify-end items-center">
                <button @click="changeCurrentLeftSide('')" type="button" class="p-2 ml-2 text-gray-400 rounded-full hover:text-gray-600 hover:bg-gray-300 focus:outline-none focus:ring">
                    <svg class="fill-current h-6 w-6" viewBox="0 0 20 20">
                        <path d="M15.898,4.045c-0.271-0.272-0.713-0.272-0.986,0l-4.71,4.711L5.493,4.045c-0.272-0.272-0.714-0.272-0.986,0s-0.272,0.714,0,0.986l4.709,4.711l-4.71,4.711c-0.272,0.271-0.272,0.713,0,0.986c0.136,0.136,0.314,0.203,0.492,0.203c0.179,0,0.357-0.067,0.493-0.203l4.711-4.711l4.71,4.711c0.137,0.136,0.314,0.203,0.494,0.203c0.178,0,0.355-0.067,0.492-0.203c0.273-0.273,0.273-0.715,0-0.986l-4.711-4.711l4.711-4.711C16.172,4.759,16.172,4.317,15.898,4.045z"></path>
                    </svg>
                </button>
            </header>
            <main>
                <div class="flex flex-col justify-center items-center my-4">
                    <div class="relative">
                        <img src="/group.png" class="w-32 contrast bg-gray-700 h-32 mb-4 rounded-full" alt="">
                        <button v-if="$page.props.user.current_team && $page.props.user.id === $page.props.user.current_team.owner.id" type="button" class="p-1.5 absolute top-0 right-0 ml-2 text-gray-400 rounded-full hover:text-gray-600 bg-gray-300 focus:outline-none focus:ring">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                        </button>
                    </div>
                    <div v-if="!editTeamName" class="flex items-center w-full justify-center relative">
                        <h2 v-if="$page.props.user.current_team" class="font-bold text-lg text-gray-700">
                            {{ $page.props.user.current_team.name }}
                        </h2>
                        <button v-if="$page.props.user.current_team && $page.props.user.id === $page.props.user.current_team.owner.id" @click="editingTeamName" type="button" class="p-1 ml-2 text-gray-400 rounded-full hover:text-gray-600 bg-gray-300 focus:outline-none focus:ring">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                            </svg>
                        </button>
                    </div>
                    <div v-else class="w-full">
                        <form v-if="$page.props.user.current_team && $page.props.user.id === $page.props.user.current_team.owner.id" @submit.prevent="changeTeamName"  class="w-full flex flex-col px-3 items-center">
                            <input
                                v-model="form.name"
                                type="text"
                                class="w-full py-2 pl-2 mr-2 text-sm text-gray-400 placeholder-gray-500 bg-gray-600 border-gray-300 rounded-md outline-none search-input bg-opacity-10 focus:border-gray-500 focus:ring-transparent focus:outline-none"
                            />
                            <div class="flex items-center justify-center">
                                <button type="submit" class="p-2 ml-2 text-gray-400 rounded-full hover:text-gray-600 hover:bg-gray-300 focus:outline-none focus:ring">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                                <button type="button" @click="doneEditingTeamName" class="flex text-gray-400 hover:text-gray-600 flex-col items-center justify-center p-2 ml-2 rounded-full focus:ring-2 hover:bg-gray-300 hover:bg-opacity-30 focus:outline-none" aria-label="Add">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                        <path d="M15.898,4.045c-0.271-0.272-0.713-0.272-0.986,0l-4.71,4.711L5.493,4.045c-0.272-0.272-0.714-0.272-0.986,0s-0.272,0.714,0,0.986l4.709,4.711l-4.71,4.711c-0.272,0.271-0.272,0.713,0,0.986c0.136,0.136,0.314,0.203,0.492,0.203c0.179,0,0.357-0.067,0.493-0.203l4.711-4.711l4.71,4.711c0.137,0.136,0.314,0.203,0.494,0.203c0.178,0,0.355-0.067,0.492-0.203c0.273-0.273,0.273-0.715,0-0.986l-4.711-4.711l4.711-4.711C16.172,4.759,16.172,4.317,15.898,4.045z"></path>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                    <p class="text-xs mt-5 text-gray-500">Administrator:</p>
                    <p v-if="$page.props.user.current_team" class="text-gray-600">{{ $page.props.user.current_team.owner.name }}</p>
                </div>
                <div class="my-6">
                    <ul class="flex flex-row justify-center items-center">
                        <li>
                            <button
                                type="button"
                                class="flex flex-col justify-center items-center p-2 m-2 w-16 h-16 text-gray-400 rounded-full hover:text-gray-600 hover:bg-gray-300 focus:outline-none focus:ring"
                                @click="changeCurrentComponent('group')"
                                :class="currentComponent === 'group' ? 'bg-gray-200' : ''"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <p class="text-xs font-semibold">Group</p>
                            </button>
                        </li>
                        <li>
                            <button
                                @click="changeCurrentComponent('invite-to-group')"
                                type="button"
                                :class="currentComponent === 'invite-to-group' ? 'bg-gray-200' : ''"
                                class="flex flex-col justify-center items-center p-2 m-2 w-16 h-16 text-gray-400 rounded-full hover:text-gray-600 hover:bg-gray-300 focus:outline-none focus:ring"
                            >
                                <svg class="fill-current h-6 w-6 mb-2" viewBox="0 0 24 24">
                                    <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm0 8c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4zm-6 4c.22-.72 3.31-2 6-2 2.7 0 5.8 1.29 6 2H9zm-3-3v-3h3v-2H6V7H4v3H1v2h3v3z"/>
                                </svg>
                                <p class="text-xs font-semibold">Add</p>
                            </button>
                        </li>
                        <li>
                            <button type="button" class="flex flex-col justify-center items-center p-2 m-2 w-16 h-16 text-gray-400 rounded-full hover:text-gray-600 hover:bg-gray-300 focus:outline-none focus:ring">
                                <svg class="fill-current h-6 w-6 mb-2" viewBox="0 0 24 24">
                                    <path fill-rule="nonzero" d="M11,20 L13,20 C13.5522847,20 14,20.4477153 14,21 C14,21.5128358 13.6139598,21.9355072 13.1166211,21.9932723 L13,22 L11,22 C10.4477153,22 10,21.5522847 10,21 C10,20.4871642 10.3860402,20.0644928 10.8833789,20.0067277 L11,20 L13,20 L11,20 Z M3.30352462,2.28241931 C3.6693482,1.92735525 4.23692991,1.908094 4.62462533,2.21893936 L4.71758069,2.30352462 L21.2175807,19.3035246 C21.6022334,19.6998335 21.5927842,20.332928 21.1964754,20.7175807 C20.8306518,21.0726447 20.2630701,21.091906 19.8753747,20.7810606 L19.7824193,20.6964754 L18.127874,18.9919007 L18,18.9999993 L4,18.9999993 C3.23933773,18.9999993 2.77101468,18.1926118 3.11084891,17.5416503 L3.16794971,17.4452998 L5,14.6972244 L5,8.9999993 C5,7.98873702 5.21529462,7.00715088 5.62359521,6.10821117 L3.28241931,3.69647538 C2.89776658,3.3001665 2.90721575,2.66707204 3.30352462,2.28241931 Z M7.00817933,8.71121787 L7,9 L7,14.6972244 C7,15.0356672 6.91413188,15.3676193 6.75167088,15.6624466 L6.66410059,15.8066248 L5.86851709,17 L16.1953186,17 L7.16961011,7.7028948 C7.08210009,8.02986218 7.02771758,8.36725335 7.00817933,8.71121787 Z M12,2 C15.7854517,2 18.8690987,5.00478338 18.995941,8.75935025 L19,9 L19,12 C19,12.5522847 18.5522847,13 18,13 C17.4871642,13 17.0644928,12.6139598 17.0067277,12.1166211 L17,12 L17,9 C17,6.23857625 14.7614237,4 12,4 C11.3902636,4 10.7970241,4.10872043 10.239851,4.31831953 C9.72293204,4.51277572 9.14624852,4.25136798 8.95179232,3.734449 C8.75733613,3.21753002 9.01874387,2.6408465 9.53566285,2.4463903 C10.3171048,2.15242503 11.1488212,2 12,2 Z"></path>
                                </svg>
                                <p class="text-xs font-semibold">Mute</p>
                            </button>
                        </li>
                        <li v-if="$page.props.user.current_team && $page.props.user.id != $page.props.user.current_team.owner.id">
                            <button type="button" class="flex flex-col justify-center items-center p-2 m-2 w-16 h-16 text-gray-400 rounded-full hover:text-gray-600 hover:bg-gray-300 focus:outline-none focus:ring">
                                <svg class="fill-current h-6 w-6 mb-2" viewBox="0 0 24 24">
                                    <g><path d="M0,0h24v24H0V0z" fill="none"/></g><g><path d="M17,8l-1.41,1.41L17.17,11H9v2h8.17l-1.58,1.58L17,16l4-4L17,8z M5,5h7V3H5C3.9,3,3,3.9,3,5v14c0,1.1,0.9,2,2,2h7v-2H5V5z"/></g>
                                </svg>
                                <p class="text-xs font-semibold">Leave</p>
                            </button>
                        </li>
                        <li v-else>
                            <button @click="openDeleteModal" type="button" class="flex flex-col justify-center items-center p-2 m-2 w-16 h-16 text-gray-400 rounded-full hover:text-gray-600 hover:bg-gray-300 focus:outline-none focus:ring">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                <p class="text-xs font-semibold">Delete Group</p>
                            </button>
                        </li>
                    </ul>
                    <jet-dialog-modal :show="showDeleteModal" @close="closeDeleteModal">
                        <template #content>
                            <div class="text-center p-5 flex-auto justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 -m-1 flex items-center text-red-500 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 flex items-center text-red-500 mx-auto" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <h2 class="text-xl font-bold py-4 ">Are you sure?</h2>
                                    <p class="text-sm text-gray-500 px-8">Do you really want to delete your group?
                                        This process cannot be undone</p>
                            </div>
                        </template>
                        <template #footer>
                            <div class="p-3  mt-2 text-center space-x-4 md:block">
                                <button @click="closeDeleteModal" class="mb-2 md:mb-0 bg-white px-5 py-2 text-sm shadow-sm font-medium tracking-wider border text-gray-600 rounded-full hover:shadow-lg hover:bg-gray-100">
                                    Cancel
                                </button>
                                <button type="button" @click="deleteTeam" class="mb-2 md:mb-0 bg-red-500 border border-red-500 px-5 py-2 text-sm shadow-sm font-medium tracking-wider text-white rounded-full hover:shadow-lg hover:bg-red-600">Delete</button>
                            </div>
                        </template>
                    </jet-dialog-modal>
                </div>

                <div v-show="currentComponent === 'invite-to-group'">
                    <invite-to-group :pendingGroupInvites="pendingGroupInvites" :findUsers="findUsers" />
                </div>

                <div v-show="currentComponent === 'group'" class="">
                    <ul class="flex flex-row justify-between items-center bg-gray-300 rounded-lg p-1">
                        <li
                            @click="changeCurrentGroupStorage('media')"
                            class="px-3 py-1 text-xs font-semibold rounded-md cursor-pointer"
                            :class="currentGroupStorage === 'media' ? 'bg-white' : ''"
                        >Media</li>
                        <li
                            @click="changeCurrentGroupStorage('links')"
                            class="px-3 py-1 text-xs font-semibold rounded-md cursor-pointer"
                            :class="currentGroupStorage === 'links' ? 'bg-white' : ''"
                        >Links</li>
                        <li
                            @click="changeCurrentGroupStorage('files')"
                            class="px-3 py-1 text-xs font-semibold rounded-md cursor-pointer"
                            :class="currentGroupStorage === 'files' ? 'bg-white' : ''"
                        >Files</li>
                        <li
                            @click="changeCurrentGroupStorage('users')"
                            class="px-3 py-1 text-xs font-semibold rounded-md cursor-pointer"
                            :class="currentGroupStorage === 'users' ? 'bg-white' : ''"
                        >Users</li>
                    </ul>

                    <ul v-show="currentGroupStorage === 'media'" class="grid grid-cols-3 gap-2 my-3">
                        <li class="">
                            <img class="rounded-md" src="https://hips.hearstapps.com/ghk.h-cdn.co/assets/16/38/1474395998-ghk-0216-comfortfoodcover-meatballs.jpg?crop=0.856xw:0.571xh;0.0224xw,0.296xh&resize=640:*" alt="">
                        </li>
                        <li class="">
                            <img class="rounded-md" src="https://media.self.com/photos/5f189b76c58e27c99fbef9e3/1:1/w_768,c_limit/blackberry-vanilla-french-toast.jpg" alt="">
                        </li>
                        <li class="">
                            <img class="rounded-md" src="https://hips.hearstapps.com/hmg-prod.s3.amazonaws.com/images/gettyimages-1036880806.jpg?crop=0.6666666666666666xw:1xh;center,top&resize=640:*" alt="">
                        </li>
                        <li class="">
                            <img class="rounded-md" src="https://images.immediate.co.uk/production/volatile/sites/30/2020/08/chorizo-mozarella-gnocchi-bake-cropped-9ab73a3.jpg?quality=90&resize=700%2C636" alt="">
                        </li>
                    </ul>

                    <!-- Group Users -->
                    <div v-show="currentGroupStorage === 'users'" class="my-4 px-5">
                        <ul v-if="$page.props.user.current_team && $page.props.user.current_team.users">
                            <li v-for="user in $page.props.user.current_team.users" :key="user.id" class="flex flex-row my-3">
                                <div class="mr-4">
                                    <img src="/user.png" class="w-12 contrast bg-gray-700 h-12 rounded-full" alt="">
                                </div>
                                <div class="flex flex-col justify-center">
                                    <h2 class="text-sm font-bold">{{ user.name }}</h2>
                                    <p class="text-xs text-blue-600 font-normal">Online</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </main>
        </div>

</template>

<script>
import InviteToGroup from "@/Components/InviteToGroup";
import JetDialogModal from '@/Jetstream/DialogModal';

export default {
    name: "RightSection",
    components: {
        InviteToGroup,
        JetDialogModal
    },
    props: {
        changeCurrentLeftSide: Function,
        rightSideComponent: String,
        findUsers: Array,
        pendingGroupInvites: Array
    },
    data() {
        return {
            currentGroupStorage: 'media',
            currentComponent: 'group',
            editTeamName: false,
            showDeleteModal: false,
            form: this.$inertia.form({
                name: ""
            })

        }
    },
    methods: {
        changeCurrentGroupStorage(storage) {
            localStorage.setItem('cgs', storage);
            this.currentGroupStorage = storage;
        },
        changeCurrentComponent(component) {
            localStorage.setItem('cgc', component);
            this.currentComponent = component;
        },
        editingTeamName() {
            this.form.name = this.$page.props.user.current_team.name;
            this.editTeamName = true;
        },
        doneEditingTeamName() {
            this.editTeamName = false;
        },
        openDeleteModal() {
            this.showDeleteModal = true;
        },
        closeDeleteModal() {
            this.showDeleteModal = false;
        },
        changeTeamName() {
            if (this.$page.props.user.id === this.$page.props.user.current_team.owner.id) {
                this.form.put(route('teams.update', this.$page.props.user.current_team), {
                    errorBag: 'updateTeamName',
                    preserveScroll: true,
                    onSuccess: () => {
                        this.form.reset();
                        this.editTeamName = false;
                    }
                });
            }
        },
        deleteTeam() {
            if (this.$page.props.user.current_team && this.$page.props.user.id === this.$page.props.user.current_team.owner.id) {
                this.$inertia.delete(route('teams.destroy', this.$page.props.user.current_team), {
                    errorBag: 'deleteTeam',
                    onSuccess: () => {
                        this.showDeleteModal = false;
                        this.changeCurrentLeftSide("");
                    }
                });
            }
        }
    },
    watch: {
        rightSideComponent: {
            immediate: true,
            deep: true,
            handler(newValue, oldValue) {
                if (newValue === 'invite-to-group') {
                    this.currentComponent = newValue;
                }
            }

        }
    },
    mounted() {
        let cgs = localStorage.getItem('cgs');
        let cgc = localStorage.getItem('cgc');
        if (cgs) {
            this.currentGroupStorage = cgs;
        }
        if (cgc) {
            this.currentComponent = cgc;
        }
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
    .contrast {
        filter: grayscale(1) invert(1);
    }
</style>
