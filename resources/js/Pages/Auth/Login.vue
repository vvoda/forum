<template>
<!--    <jet-authentication-card>-->
<!--        <template #logo>-->
<!--            <jet-authentication-card-logo />-->
<!--        </template>-->

<!--        <jet-validation-errors class="mb-4" />-->

<!--        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">-->
<!--            {{ status }}-->
<!--        </div>-->

<!--        <form @submit.prevent="submit">-->
<!--            <div>-->
<!--                <jet-label for="email" value="Email" />-->
<!--                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus />-->
<!--            </div>-->

<!--            <div class="mt-4">-->
<!--                <jet-label for="password" value="Password" />-->
<!--                <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password" />-->
<!--            </div>-->

<!--            <div class="block mt-4">-->
<!--                <label class="flex items-center">-->
<!--                    <jet-checkbox name="remember" v-model:checked="form.remember" />-->
<!--                    <span class="ml-2 text-sm text-gray-600">Remember me</span>-->
<!--                </label>-->
<!--            </div>-->

<!--            <div class="flex items-center justify-end mt-4">-->
<!--                <inertia-link v-if="canResetPassword" :href="route('password.request')" class="underline text-sm text-gray-600 hover:text-gray-900">-->
<!--                    Forgot your password?-->
<!--                </inertia-link>-->

<!--                <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">-->
<!--                    Log in-->
<!--                </jet-button>-->
<!--            </div>-->
<!--        </form>-->
<!--    </jet-authentication-card>-->

    <div class="flex items-center min-h-screen bg-white dark:bg-gray-900">
        <div class="container mx-auto">
            <div class="max-w-md mx-auto my-10">
                <div class="text-center">
                    <h1 class="my-3 text-3xl font-semibold text-gray-700 dark:text-gray-200">Sign in</h1>
                    <p class="text-gray-500 dark:text-gray-400">Sign in to access your account</p>
                </div>
                <jet-validation-errors class="mb-4" />

                <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
                    {{ status }}
                </div>
                <div class="m-7">
                    <form @submit.prevent="submit">
                        <div class="mb-6">
                            <jet-label for="email" class="block mb-2 text-sm text-gray-600 dark:text-gray-400" value="Email" />
                            <jet-input id="email" type="email" class="w-full px-5  py-4 text-gray-700 bg-gray-200 rounded" v-model="form.email" required autofocus />
                        </div>
                        <div class="mb-2">
                            <jet-label for="password" class="text-sm text-gray-600 dark:text-gray-400" value="Password" />
                            <jet-input id="password"  type="password" class="w-full px-5  py-4 text-gray-700 bg-gray-200 rounded" v-model="form.password" required autocomplete="current-password" />
                        </div>
                        <inertia-link v-if="canResetPassword" :href="route('password.request')" class="text-sm my-1 text-gray-400 focus:outline-none focus:text-indigo-500 hover:text-indigo-500 dark:hover:text-indigo-300">
                            Forgot your password?
                        </inertia-link>
                        <div class="mt-3">
                            <button type="submit" :class="{ 'opacity-25': form.processing }" :disabled="form.processing" class="w-full px-3 py-4 text-white bg-indigo-500 rounded-md focus:bg-indigo-600 focus:outline-none">Sign in</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
    import JetButton from '@/Jetstream/Button'
    import JetInput from '@/Jetstream/Input'
    import JetCheckbox from '@/Jetstream/Checkbox'
    import JetLabel from '@/Jetstream/Label'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'

    export default {
        components: {
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors
        },

        props: {
            canResetPassword: Boolean,
            status: String
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: '',
                    password: '',
                    remember: false
                })
            }
        },

        methods: {
            submit() {
                this.form
                    .transform(data => ({
                        ... data,
                        remember: this.form.remember ? 'on' : ''
                    }))
                    .post(this.route('login'), {
                        onFinish: () => this.form.reset('password'),
                    })
            }
        }
    }
</script>
