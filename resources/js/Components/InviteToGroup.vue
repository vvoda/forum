<template>
    <div class="px-3">
        <input
            v-model="searchUserQuery"
            class="w-full py-1 text-sm text-gray-700 bg-gray-200 border-gray-300 rounded focus:border-gray-500 focus:ring-transparent"
            type="text"
            placeholder="Search by name or email address"
        />

        <ul v-if="findUsers" class="mt-5">
            <li v-for="user in findUsers" :key="user.id" class="flex mt-5 w-full items-center my-3">
                <div v-if="user.id != $page.props.user.id" class="w-full">
                    <div class="mr-2">
                        <img src="/user.png" class="w-12 bg-gray-700 rounded-full contrast" alt="">
                    </div>
                    <div class="flex w-full items-center justify-between">
                        <div class="flex flex-col justify-center">
                            <h2 class="text-sm font-bold">{{ user.name }}</h2>
                            <span class="text-sm text-gray-400">{{ user.email }}</span>
                        </div>

                        <button
                            @click="addTeamMember(user)"
                            type="button"
                            class="flex flex-col justify-center items-center p-1  w-8 h-8 text-gray-400 rounded-full hover:text-gray-600 hover:bg-gray-300 focus:outline-none focus:ring"
                        >
                            <svg class="fill-current h-6 w-6" viewBox="0 0 24 24">
                                <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm0 8c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4zm-6 4c.22-.72 3.31-2 6-2 2.7 0 5.8 1.29 6 2H9zm-3-3v-3h3v-2H6V7H4v3H1v2h3v3z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </li>
        </ul>
        <ul v-if="pendingGroupInvites && pendingGroupInvites.length > 0" class="border-t border-gray-200 pt-3 mt-2">
            <h2 class="text-base text-gray-500 mb-5 font-semibold">Pending</h2>

            <li v-for="invite in pendingGroupInvites" :key="invite.id" class="mb-3">
                <div class="w-full flex items-center justify-between">
                    <span class="text-sm text-gray-700">{{ invite.email }}</span>
                    <span class="text-xs text-gray-500">{{ getFormattedDate(invite.created_at) }}</span>
                    <button type="button" class="p-1.5 ml-2 text-gray-400 rounded-full hover:text-gray-600 bg-gray-300 focus:outline-none focus:ring">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    import _ from 'lodash';
    import moment from 'moment';

    export default {
        props: {
            findUsers: Array,
            pendingGroupInvites: Array
        },
        data() {
            return {
                searchUserQuery: "",
                addMemberForm: this.$inertia.form({
                    _method: 'post',
                    email: '',
                    role: ''
                })
            }
        },
        methods: {
            searchUser: _.debounce(function() {
                this.$inertia.visit(route('home'), {
                    data: {
                        fu: this.searchUserQuery
                    },
                    only: ['findUsers', 'rightSideComponent'],
                    preserveState: true,
                    preserveScroll: true,
                });
            }, 400),
            addTeamMember(user) {
                this.addMemberForm.email = user.email;
                this.addMemberForm.role = 'editor'
                this.addMemberForm.post(route('team-members.store', this.$page.props.user.current_team), {
                    errorBag: 'addTeamMember',
                    preserveScroll: true,
                    onSuccess: () => {
                        this.addMemberForm.reset();
                    }
                });
            },
            getFormattedDate(date) {
                return moment(date).format("DD MMM YYYY H:m")
            }
        },
        watch: {
            searchUserQuery(value) {
                this.searchUser();
            }
        }
    }
</script>

<style scoped>
.contrast {
    filter: grayscale(1) invert(1);
}
</style>
