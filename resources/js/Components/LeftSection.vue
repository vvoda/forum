<template>
    <div class="flex flex-col items-stretch justify-start w-full p-3 bg-white rounded-md lg:rounded-none lg:rounded-l-md">
        <div class="flex flex-col flex-auto">
            <div class="flex flex-row flex-auto">
                <div class="w-full p-1">
                    <div class="flex items-center w-full p-1">
                        <input
                            type="text"
                            placeholder="Search"
                            class="w-full py-1 pl-10 mr-2 text-sm text-gray-400 placeholder-gray-500 bg-gray-600 border-gray-300 rounded-md outline-none search-input bg-opacity-10 focus:border-gray-500 focus:ring-transparent focus:outline-none"
                        />
                        <jet-dropdown>
                            <template #trigger>
                                <button class="flex flex-col items-center justify-center p-2 rounded-full focus:ring-2 hover:bg-gray-200 hover:bg-opacity-30 focus:outline-none" aria-label="Add">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 25 25">
                                        <path d="M11 11v-11h1v11h11v1h-11v11h-1v-11h-11v-1h11z"/>
                                    </svg>
                                </button>
                            </template>
                            <template #content>
                                <jet-dropdown-link @click="changeCurrentRightSide('add-group')" as="button">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
                                        </svg>
                                        Add Group
                                    </div>
                                </jet-dropdown-link>
                                <jet-dropdown-link @click="changeCurrentRightSide('add-contact')" as="button">
                                    <div class="flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M8 9a3 3 0 100-6 3 3 0 000 6zM8 11a6 6 0 016 6H2a6 6 0 016-6zM16 7a1 1 0 10-2 0v1h-1a1 1 0 100 2h1v1a1 1 0 102 0v-1h1a1 1 0 100-2h-1V7z" />
                                        </svg>
                                        Add Contact
                                    </div>
                                </jet-dropdown-link>
                            </template>
                        </jet-dropdown>
                    </div>

                    <ul v-if="$page.props.user.all_teams" class="overflow-y-auto groupList">
                        <li
                            @click.prevent="switchToTeam(team.id)"
                            v-for="team in $page.props.user.all_teams"
                            :key="team.id"
                            class="flex flex-row p-2 my-2 rounded-lg cursor-pointer hover:bg-gray-200"
                            :class="$page.props.user.current_team_id === team.id ? 'bg-gray-200' : ''"
                        >
                            <img src="/group.png" class="w-12 h-12 mr-4 bg-gray-700 rounded-full contrast" alt="">
                            <div class="flex flex-col justify-center w-full">
                                <div class="flex flex-row items-center justify-between">
                                    <h2 class="text-xs font-bold">{{ team['name']}}</h2>
                                    <div class="flex flex-row text-xs">
                                        <!-- If Message was read/seen -->
                                        <svg class="w-4 h-4 mr-1 text-blue-600 fill-current" viewBox="0 0 19 14">
                                            <path fill-rule="nonzero" d="M4.96833846,10.0490996 L11.5108251,2.571972 C11.7472185,2.30180819 12.1578642,2.27443181 12.428028,2.51082515 C12.6711754,2.72357915 12.717665,3.07747757 12.5522007,3.34307913 L12.4891749,3.428028 L5.48917485,11.428028 C5.2663359,11.6827011 4.89144111,11.7199091 4.62486888,11.5309823 L4.54038059,11.4596194 L1.54038059,8.45961941 C1.2865398,8.20577862 1.2865398,7.79422138 1.54038059,7.54038059 C1.7688373,7.31192388 2.12504434,7.28907821 2.37905111,7.47184358 L2.45961941,7.54038059 L4.96833846,10.0490996 L11.5108251,2.571972 L4.96833846,10.0490996 Z M9.96833846,10.0490996 L16.5108251,2.571972 C16.7472185,2.30180819 17.1578642,2.27443181 17.428028,2.51082515 C17.6711754,2.72357915 17.717665,3.07747757 17.5522007,3.34307913 L17.4891749,3.428028 L10.4891749,11.428028 C10.2663359,11.6827011 9.89144111,11.7199091 9.62486888,11.5309823 L9.54038059,11.4596194 L8.54038059,10.4596194 C8.2865398,10.2057786 8.2865398,9.79422138 8.54038059,9.54038059 C8.7688373,9.31192388 9.12504434,9.28907821 9.37905111,9.47184358 L9.45961941,9.54038059 L9.96833846,10.0490996 L16.5108251,2.571972 L9.96833846,10.0490996 Z"></path>
                                        </svg>
                                        <!-- When the Message was read/seen -->
                                        <span class="text-gray-400">
                                        10:45
                                      </span>
                                    </div>
                                </div>
                                <div class="flex flex-row items-center justify-between">
                                    <!-- Ultimate Message -->
                                    <p class="text-xs text-gray-500">On projection apartments unsatiable...</p>
                                    <!-- New unread messages count -->
                                    <span class="w-5 h-5 text-sm font-bold text-center text-white bg-blue-500 rounded-full">4</span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import JetDropdown from '@/Jetstream/Dropdown';
import JetDropdownLink from '@/Jetstream/DropdownLink'

export default {
    name: "LeftSection",
    components: {
        JetDropdown,
        JetDropdownLink
    },
    props: {
        changeCurrentRightSide: Function,
        switchToTeam: Function
    },
    methods: {
        getTeams() {
            let list = [];
            for (let [key, value] of Object.entries(this.$page.props.user.all_teams)) {
                list.push(value);
            }
            return list;
        },

    }
}
</script>

<style scoped>
    .search-input {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%239ca3af' d='M18.109,17.776l-3.082-3.081c-0.059-0.059-0.135-0.077-0.211-0.087c1.373-1.38,2.221-3.28,2.221-5.379c0-4.212-3.414-7.626-7.625-7.626c-4.212,0-7.626,3.414-7.626,7.626s3.414,7.627,7.626,7.627c1.918,0,3.665-0.713,5.004-1.882c0.006,0.085,0.033,0.17,0.098,0.234l3.082,3.081c0.143,0.142,0.371,0.142,0.514,0C18.25,18.148,18.25,17.918,18.109,17.776zM9.412,16.13c-3.811,0-6.9-3.089-6.9-6.9c0-3.81,3.089-6.899,6.9-6.899c3.811,0,6.901,3.09,6.901,6.899C16.312,13.041,13.223,16.13,9.412,16.13z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: left 0.75rem center;
        background-size: 0.9rem 1.25rem;
    }
    .contrast {
        filter: grayscale(1) invert(1);
    }
    .groupList {
        height: 90vh;
    }
    .groupList::-webkit-scrollbar {
        width: 6px;               /* width of the entire scrollbar */
    }
    .groupList::-webkit-scrollbar-track {
        background: lightgrey;        /* color of the tracking area */
    }
    .groupList::-webkit-scrollbar-thumb {
        background-color: gray;    /* color of the scroll thumb */
        border-radius: 10px;       /* roundness of the scroll thumb */ /* creates padding around scroll thumb */
    }
</style>
