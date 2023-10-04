<template>
    <div v-if="paginationData">
        <div class="container text-center">
            <div class="row">
                <nav class="col-md-9" aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                        <li v-for="(link) in paginationData.links" @click="link.url && find($event, link.url)"
                            class="page-item cursorPointer" :class="{ 'active': link.active }"><a class="page-link"
                                v-html="link.label"></a></li>
                    </ul>
                </nav>
                <form class="col-md-3" @submit="goToPage">
                    <div class="input-group" :class="{ 'is-invalid': goToPageErr }">
                        <input name="page" class="form-control" :placeholder="paginationData.current_page">
                        <button class="btn btn-outline-secondary" type="submit"><i
                                class="fa-solid fa-arrow-right"></i></button>
                    </div>
                    <div class="invalid-feedback">{{ goToPageErr }}</div>
                </form>
            </div>
        </div>
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
    data() {
        return {
            goToPageErr: '',
        }
    },
    methods: {
        goToPage(e) {
            e.preventDefault();
            var page = e.target['page'].value.trim();
            if (page < 1 || page > this.paginationData.last_page || !this.isInt(page)) {
                this.goToPageErr = __('Page out of range');
                return;
            }
            this.goToPageErr = '';
            this.find(null, this.paginationData.first_page_url.replace('?page=1', '?page=' + page));
        },
        ucfirst(str) {
            if (str) {
                return str[0].toUpperCase() + str.slice(1);
            }
        },
        isInt(str) {
            return /^\+?([1-9]\d*)$/.test(str);
        }
    }
}
</script>
