<template>
    <div v-if="paginationData">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li v-for="(link) in paginationData.links" @click="link.url && find($event, link.url)"
                    class="page-item cursorPointer" :class="{ 'active': link.active }"><a class="page-link"
                        v-html="link.label"></a></li>
            </ul>
        </nav>
        <div>
            <div v-for="(meetup) in paginationData.data" class="border-top py-3 container">
                <div class="row">
                    <div class="col-2"><img v-if="meetup.profile_photo" :src="meetup.profile_photo" class="w-100" /></div>
                    <div class="col-7">
                        <div><b>{{ __('Name') }}: </b>{{ meetup.name }}</div>
                        <div><b>{{ __('Email') }}: </b>{{ meetup.email }}</div>
                        <div><b>{{ __('Gender') }}: </b>{{ __(ucfirst(meetup.gender)) }}</div>
                        <div><b>{{ __('Birth date') }}: </b>{{ meetup.birth_date }}</div>
                    </div>
                    <div class="col-3">
                        <div><b>{{ __('Account from') }}: </b>{{ meetup.created_at }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        find: {
            type: Function
        },
        paginationData: {
            type: Object,
            default: null
        },
    },
    methods: {
        ucfirst(str) {
            if (str) {
                return str[0].toUpperCase() + str.slice(1);
            }
        }
    }
}
</script>
