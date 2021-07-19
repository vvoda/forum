<template>
    <div class="w-full h-screen flex flex-col items-stretch justify-start p-3 bg-gray-100">
        <div class="flex flex-col flex-auto">
            <div class="flex flex-row flex-auto">
                <div class="w-full p-1">
                    <form>
                        <div class="flex items-start w-full p-1">
                            <input
                                v-model="fg"
                                class="w-full py-2 text-sm text-gray-700 bg-gray-200 border-gray-300 rounded focus:border-gray-500 focus:ring-transparent"
                                type="text" placeholder="Topics or messages"
                            />
                            <button @click="changeCurrentLeftSide('')" type="button" class="p-2 ml-2 text-gray-400 rounded-full hover:text-gray-600 hover:bg-gray-300 focus:outline-none focus:ring">
                                <svg class="fill-current h-6 w-6" viewBox="0 0 20 20">
                                    <path d="M15.898,4.045c-0.271-0.272-0.713-0.272-0.986,0l-4.71,4.711L5.493,4.045c-0.272-0.272-0.714-0.272-0.986,0s-0.272,0.714,0,0.986l4.709,4.711l-4.71,4.711c-0.272,0.271-0.272,0.713,0,0.986c0.136,0.136,0.314,0.203,0.492,0.203c0.179,0,0.357-0.067,0.493-0.203l4.711-4.711l4.71,4.711c0.137,0.136,0.314,0.203,0.494,0.203c0.178,0,0.355-0.067,0.492-0.203c0.273-0.273,0.273-0.715,0-0.986l-4.711-4.711l4.711-4.711C16.172,4.759,16.172,4.317,15.898,4.045z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <ul  class="contactList">
                <li  class="flex flex-row my-3">

                </li>
            </ul>
        </div>
    </div>
</template>

<script>
export default {
    name: "GroupSearch",
    props: {
        changeCurrentLeftSide: Function
    },
    data() {
        return {
            fg: ""
        }
    }
}
</script>

<style scoped>

</style>
