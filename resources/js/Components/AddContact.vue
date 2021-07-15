<template>
    <div :class="currentRightSide === 'add-contact' ? 'slideIn' : 'slideOut'" class="absolute w-full flex flex-col items-stretch justify-start p-3 rounded-md addContact bg-gray-50 lg:rounded-none lg:rounded-l-md">
        <div class="flex flex-col flex-auto">
            <div class="flex flex-row flex-auto">
                <div class="w-full p-1">
                    <form>
                        <div class="flex items-start w-full p-1">
                            <input v-model="fc" class="w-full py-1 text-sm text-gray-700 bg-gray-200 border-gray-300 rounded focus:border-gray-500 focus:ring-transparent" type="text" placeholder="Contact name or email address" />
                            <button type="button" @click="changeRightSide('groups')" class="flex flex-col items-center justify-center p-2 ml-2 rounded-full focus:ring-2 hover:bg-gray-200 hover:bg-opacity-30 focus:outline-none" aria-label="Add">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                                    <path d="M15.898,4.045c-0.271-0.272-0.713-0.272-0.986,0l-4.71,4.711L5.493,4.045c-0.272-0.272-0.714-0.272-0.986,0s-0.272,0.714,0,0.986l4.709,4.711l-4.71,4.711c-0.272,0.271-0.272,0.713,0,0.986c0.136,0.136,0.314,0.203,0.492,0.203c0.179,0,0.357-0.067,0.493-0.203l4.711-4.711l4.71,4.711c0.137,0.136,0.314,0.203,0.494,0.203c0.178,0,0.355-0.067,0.492-0.203c0.273-0.273,0.273-0.715,0-0.986l-4.711-4.711l4.711-4.711C16.172,4.759,16.172,4.317,15.898,4.045z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <ul v-if="findContacts" class="contactList">
                <li v-for="contact in findContacts" :key="contact.id" class="flex flex-row my-3">
                    <div class="mr-4">
                        <img src="/user.png" class="w-12 h-12 bg-gray-700 rounded-full contrast" alt="">
                    </div>
                    <div class="flex flex-col justify-center">
                        <h2 class="text-sm font-bold">{{ contact.name }}</h2>
                        <span class="text-sm text-gray-400">{{ contact.email }}</span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import _ from 'lodash';

export default {
    name: "AddContact",
    props: {
        changeCurrentRightSide: Function,
        currentRightSide: String,
        findContacts: Array
    },
    data() {
        return {
            fc: ""
        }
    },
    methods: {
        findContact: _.debounce(function() {
            this.$inertia.visit(route('home'), {
                preserveState: true,
                preserveScroll: true,
                data: {
                    fc: this.fc
                }
            })
        }, 400),
        changeRightSide(component) {
            this.changeCurrentRightSide(component);
            this.fc = "";
        }
    },
    watch: {
        fc: function(value) {
            this.findContact()
        }
    },
}
</script>

<style scoped>
    .addContact {
        top: 0;
        left: 0;
        height: 100%;
        transition: transform .7s;
    }
    .slideOut {
        transform: translateX(-100%);
    }
    .slideIn {
        transform: translateX(0);
    }
    .contrast {
        filter: grayscale(1) invert(1);
    }
    .contactList {
        height: 95vh;
    }
</style>
