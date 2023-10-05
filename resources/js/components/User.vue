<template>
    <div class="talk py-3 container" :class="{ 'talkIsOpen': talkIsOpen }">
        <div class="row">
            <div class="col-2"><img v-if="meetup.profile_photo" :src="meetup.profile_photo" class="w-100" /></div>
            <div class="col-7">
                <div><b>{{ __('Name') }}: </b>{{ meetup.name }}</div>
                <div><b>{{ __('Email') }}: </b>{{ meetup.email }}</div>
                <div><b>{{ __('Gender') }}: </b>{{ __(ucfirst(meetup.gender)) }}</div>
                <div><b>{{ __('Birth date') }}: </b>{{ meetup.birth_date }}</div>
            </div>
            <div class="col-3" style="position: relative;">
                <div><b>{{ __('Account from') }}: </b>{{ meetup.created_at }}</div>
                <button @click="openTalk" type="button" class="btn btn-primary" style="position: absolute; bottom: 0;">{{
                    talkIsOpen ? __('Close') : __('Talk') }}</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        meetup: {
            type: Object,
            default: null
        },
    },
    data() {
        return {
            talkIsOpen: false,
        }
    },
    methods: {
        openTalk() {
            this.talkIsOpen = !this.talkIsOpen;
        },
        ucfirst(str) {
            if (str) {
                return str[0].toUpperCase() + str.slice(1);
            }
        }
    }
}
</script>
