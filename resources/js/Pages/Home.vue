<template>
    <div class="h-screen">
        <section class="flex w-full overflow-hidden rounded-md shadow-xl lg:mx-auto">
            <!-- Left section -->

            <div class="relative w-2/6">
                <left-section :changeCurrentRightSide="changeCurrentRightSide" :switchToTeam="switchToTeam" />
                <add-group :changeCurrentRightSide="changeCurrentRightSide" :currentRightSide="currentRightSide" />
                <add-contact :findContacts="findContacts" :changeCurrentRightSide="changeCurrentRightSide" :currentRightSide="currentRightSide" />
            </div>

            <div class="flex w-full h-full bg-gray-100">
                <middle-section
                    :currentTopicConversations="currentTopicConversations"
                    :middleSection="middleSection"
                    :currentTopics="currentTopics"
                    :changeCurrentLeftSide="changeCurrentLeftSide"
                />
                <div
                    :class="currentLeftSide === 'search' || currentLeftSide === 'profile' || currentLeftSide === 'group-settings' ? 'rightSlideIn' : 'rightSlideOut'"
                    class="relative w-4/6 h-full"
                >
                    <div
                        v-if="currentLeftSide === 'search'"
                        class="w-full h-full">
                        <group-search  :changeCurrentLeftSide="changeCurrentLeftSide" />
                    </div>
                    <div
                        v-if="currentLeftSide === 'profile'"
                        class="w-full h-full">
                        <profile :currentLeftSide="currentLeftSide"  :changeCurrentLeftSide="changeCurrentLeftSide" />
                    </div>
                    <div
                        v-if="currentLeftSide === 'group-settings'"
                        class="w-full h-full">
                        <right-section :findUsers="findUsers" :rightSideComponent="rightSideComponent" :changeCurrentLeftSide="changeCurrentLeftSide" />
                    </div>
                </div>

            </div>

        </section>
    </div>
</template>

<script>
import LeftSection from "@/Components/LeftSection";
import MiddleSection from "@/Components/MiddleSection";
import RightSection from "@/Components/RightSection";
import AddGroup from "@/Components/AddGroup";
import AddContact from "@/Components/AddContact";
import Profile from "@/Components/Profile";
import GroupSearch from "@/Components/GroupSearch";

export default {
    components: {
        Profile,
        RightSection,
        MiddleSection,
        LeftSection,
        AddGroup,
        AddContact,
        GroupSearch
    },
    props: {
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
        rightSide: String,
        findContacts: Array,
        currentTopics: Array,
        currentTopicConversations: Array,
        middleSection: String,
        rightSideComponent: '',
        findUsers: Array
    },
    data() {
        return {
            currentRightSide: 'groups',
            currentLeftSide: '',
            team_id: null,

        }
    },
    methods: {
        changeCurrentRightSide(component) {
            this.currentRightSide = component;
        },
        switchToTeam(teamId) {
            this.$inertia.put(route('current-team.update'), {
                'team_id': teamId
            }, {
                preserveState: false
            })
        },
        changeCurrentLeftSide(component) {
            localStorage.setItem('cr_side', component);
            this.currentLeftSide = component;
        },
        checkLastLeftSide() {
            let component = localStorage.getItem('cr_side');
            if (component) {
                this.currentLeftSide = component;
            }
        },
    },
    mounted() {
        if (this.rightSide) {
            this.currentRightSide = this.rightSide;
        }
        this.checkLastLeftSide();
    }
}
</script>

<style scoped>
    section {
        height: 100vh;
        max-height: 100vh;
    }
    .rightSlideIn {
        transform: translateX(0);
        transition: .5s;
    }
    .rightSlideOut {
        transform: translateX(100%);
        width: 0;
        opacity: .5;
        transition: .5s;
    }
</style>


