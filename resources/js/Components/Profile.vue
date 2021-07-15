<template>
    <div class="h-full bg-gray-100 rounded-r-md p-2 customScroll overflow-y-auto">
        <header class="flex flex-row justify-between items-center">
            <h4 class="text-base font-bold text-gray-500">Profile</h4>
            <button @click="closeSection" type="button" class="p-2 ml-2 text-gray-400 rounded-full hover:text-gray-600 hover:bg-gray-300 focus:outline-none focus:ring">
                <svg class="fill-current h-6 w-6" viewBox="0 0 20 20">
                    <path d="M15.898,4.045c-0.271-0.272-0.713-0.272-0.986,0l-4.71,4.711L5.493,4.045c-0.272-0.272-0.714-0.272-0.986,0s-0.272,0.714,0,0.986l4.709,4.711l-4.71,4.711c-0.272,0.271-0.272,0.713,0,0.986c0.136,0.136,0.314,0.203,0.492,0.203c0.179,0,0.357-0.067,0.493-0.203l4.711-4.711l4.71,4.711c0.137,0.136,0.314,0.203,0.494,0.203c0.178,0,0.355-0.067,0.492-0.203c0.273-0.273,0.273-0.715,0-0.986l-4.711-4.711l4.711-4.711C16.172,4.759,16.172,4.317,15.898,4.045z"></path>
                </svg>
            </button>
        </header>
        <main>
            <div class="flex flex-col px-3 justify-center items-center my-4">
                <img src="/user.png" class="w-32 contrast bg-gray-700 h-32 mb-4 rounded-full" alt="">
                <!-- Change Name -->
                <form @submit.prevent="updateUserInfo" class="w-full  mt-5">
                    <div class="flex flex-col items-start py-5 px-2 rounded-md justify-between w-full">

                        <span class="text-sm mb-2 block text-gray-400 font-semibold">Your name</span>

                        <div v-if="editName" class="flex w-full items-center justify-between">
                            <input
                                v-model="userInfoform.name"
                                type="text"
                                class="w-full py-2 pl-2 mr-2 text-sm text-gray-400 placeholder-gray-500 bg-gray-600 border-gray-300 rounded-md outline-none search-input bg-opacity-10 focus:border-gray-500 focus:ring-transparent focus:outline-none"
                            />
                            <button type="submit" class="p-2 ml-2 text-gray-400 rounded-full hover:text-gray-600 hover:bg-gray-300 focus:outline-none focus:ring">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </button>
                        </div>

                        <div v-else class="flex w-full items-center justify-between">
                            <h2 class="text-base text-gray-700">
                                {{ $page.props.user.name }}
                            </h2>
                            <button @click="editingName" type="button" class="p-2 ml-2 text-gray-400 rounded-full hover:text-gray-600 hover:bg-gray-300 focus:outline-none focus:ring">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <!-- Change Email -->
                    <div class="flex flex-col items-start pb-5 mt-2 px-2 rounded-md justify-between w-full">
                        <span class="text-sm mb-2 block text-gray-400 font-semibold">Your email</span>

                        <div v-if="editEmail" class="flex w-full items-center justify-between">
                            <input
                                v-model="userInfoform.email"
                                type="email"
                                class="w-full py-2 pl-2 mr-2 text-sm text-gray-400 placeholder-gray-500 bg-gray-600 border-gray-300 rounded-md outline-none search-input bg-opacity-10 focus:border-gray-500 focus:ring-transparent focus:outline-none"
                            />
                            <button type="submit" class="p-2 ml-2 text-gray-400 rounded-full hover:text-gray-600 hover:bg-gray-300 focus:outline-none focus:ring">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </button>
                        </div>

                        <div v-else class="flex w-full items-center justify-between">
                            <h2 class="text-base text-gray-700">
                                {{ $page.props.user.email }}
                            </h2>
                            <button @click="editingEmail" type="button" class="p-2 ml-2 text-gray-400 rounded-full hover:text-gray-600 hover:bg-gray-300 focus:outline-none focus:ring">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>

<!--                Change Password-->
                <form @submit.prevent="updatePassword" class="mt-5 w-full px-2 py-5">
                    <span class="text-sm mb-2 block text-gray-400 font-semibold">Current password</span>
                    <input
                        ref="current_password"
                        v-model="userPasswordForm.current_password"
                        id="current_password"
                        type="password"
                        class="w-full py-2 pl-2 mr-2 my-4 text-sm text-gray-400 placeholder-gray-500 bg-gray-600 border-gray-300 rounded-md outline-none search-input bg-opacity-10 focus:border-gray-500 focus:ring-transparent focus:outline-none"
                    />
                    <span class="text-sm mb-2 block text-gray-400 font-semibold">New password</span>
                    <input
                        v-model="userPasswordForm.password"
                        id="password"
                        type="password"
                        class="w-full py-2 pl-2 mr-2 my-4 text-sm text-gray-400 placeholder-gray-500 bg-gray-600 border-gray-300 rounded-md outline-none search-input bg-opacity-10 focus:border-gray-500 focus:ring-transparent focus:outline-none"
                    />
                    <span class="text-sm mb-2 block text-gray-400 font-semibold">Confirm Password</span>
                    <input
                        v-model="userPasswordForm.password_confirmation"
                        id="password_confirmation"
                        type="password"
                        class="w-full py-2 pl-2 mr-2 my-4 text-sm text-gray-400 placeholder-gray-500 bg-gray-600 border-gray-300 rounded-md outline-none search-input bg-opacity-10 focus:border-gray-500 focus:ring-transparent focus:outline-none"
                    />
                    <div class="flex items-center justify-end w-full my-3">
                        <button type="submit" class="px-5 py-2 text-sm text-white bg-blue-500 rounded-md focus:outline-none hover:bg-blue-600 hover:shadow-lg">Save</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</template>

<script>
import JetLabel from '@/Jetstream/Label';

export default {
    name: "Profile",
    components: {
        JetLabel
    },
    props: {
        changeCurrentLeftSide: Function,
        currentLeftSide: String
    },
    data() {
        return {
            editName: false,
            editEmail: false,
            userInfoform: this.$inertia.form({
                _method: 'put',
                name: this.$page.props.user.name,
                email: this.$page.props.user.email,
            }),
            userPasswordForm: this.$inertia.form({
                _method: 'put',
                current_password: "",
                password: "",
                password_confirmation: ""
            }),
        }
    },
    methods: {
        editingName() {
            this.editName = true;
            this.userInfoform.name = this.$page.props.user.name
        },
        editingEmail() {
            this.editEmail = true;
            this.userInfoform.email = this.$page.props.user.email
        },
        doneEditingName() {
            this.editName = false;
        },
        doneEditingEmail() {
            this.editName = false;
        },
        closeSection() {
            this.changeCurrentLeftSide('');
            this.editName = false;
            this.editName = false;
        },
        updatePassword() {
            this.userPasswordForm.put(route('user-password.update'), {
                errorBag: 'updatePassword',
                preserveScroll: true,
                onSuccess: () => this.userPasswordForm.reset('password', 'password_confirmation', 'current_password'),
                onError: () => {
                    if (this.userPasswordForm.errors.password) {
                        this.userPasswordForm.reset('password', 'password_confirmation')
                        this.$refs.password.focus()
                    }

                    if (this.userPasswordForm.errors.current_password) {
                        this.userPasswordForm.reset('current_password')
                        this.$refs.current_password.focus()
                    }
                }
            })
        },
        updateUserInfo() {
            this.userInfoform.put(route('user-profile-information.update'), {
                errorBag: 'updateProfileInformation',
                preserveScroll: true,
                onSuccess: () => {
                    this.userInfoform.reset();
                    this.editName = false;
                    this.editEmail = false;
                },
            });
        }
    },
    computed: {
        currentLeftSideState() {
            return this.currentLeftSide;
        }
    },
    watch: {
        currentLeftSideState(value) {
            this.editName = false;
            this.editEmail = false;
        }
    }
}
</script>

<style scoped>
    .contrast {
        filter: grayscale(1) invert(1);
    }
</style>
