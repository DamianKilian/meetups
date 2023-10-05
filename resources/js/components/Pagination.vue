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
            <div v-for="(meetup) in paginationData.data" class="border-top">
                <User :meetup="meetup" />
            </div>
        </div>
    </div>
</template>

<script>
import User from './User.vue';

export default {
    components: {
        User
    },
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
        isInt(str) {
            return /^\+?([1-9]\d*)$/.test(str);
        }
    }
}
</script>
