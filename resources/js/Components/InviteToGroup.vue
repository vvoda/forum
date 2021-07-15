<template>
    <div class="px-3">
        <input
            v-model="searchUserQuery"
            class="w-full py-1 text-sm text-gray-700 bg-gray-200 border-gray-300 rounded focus:border-gray-500 focus:ring-transparent"
            type="text"
            placeholder="Search by name or email address"
        />

        <ul v-if="findUsers" class="mt-5">
            <li v-for="user in findUsers" :key="user.id" class="flex mt-3 w-full items-center my-3">
                <div class="mr-2">
                    <img src="/user.png" class="w-12 bg-gray-700 rounded-full contrast" alt="">
                </div>
                <div class="flex w-full items-center justify-between">
                    <div class="flex flex-col justify-center">
                        <h2 class="text-sm font-bold">{{ user.name }}</h2>
                        <span class="text-sm text-gray-400">{{ user.email }}</span>
                    </div>

                    <button
                        type="button"
                        class="flex flex-col justify-center items-center p-1  w-8 h-8 text-gray-400 rounded-full hover:text-gray-600 hover:bg-gray-300 focus:outline-none focus:ring"
                    >
                        <svg class="fill-current h-6 w-6" viewBox="0 0 24 24">
                            <path d="M15 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm0 8c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4zm-6 4c.22-.72 3.31-2 6-2 2.7 0 5.8 1.29 6 2H9zm-3-3v-3h3v-2H6V7H4v3H1v2h3v3z"/>
                        </svg>
                    </button>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
    import _ from 'lodash';

    export default {
        props: {
            findUsers: Array
        },
        data() {
            return {
                searchUserQuery: ""
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
            }, 400)
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
