<template>
    <div>
        <form @submit="find" id="findMeetups">
            <div class="mb-3">
                <label for="name" class="form-label">{{ __('Name') }}</label>
                <input class="form-control" id="name" name="name">
                <div class="form-text">{{ __('Name of a user') }}</div>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">{{ __('Email') }}</label>
                <input class="form-control" id="email" name="email" placeholder="name@example.com">
                <div class="form-text">{{ __('Email of a user') }}</div>
            </div>
            <button type="submit" class="btn btn-primary">{{ __('Find') }}</button>
        </form>
    </div>
    <div class="mt-3">
        <h3>{{ __('Search results') }}:</h3>
        <div>
            <div v-for="(meetup, index) in meetups">
                <div>{{ meetup.name }}</div>
                <div>{{ meetup.email }}</div>
                <div>{{ meetup.gender }}</div>
                <div>{{ meetup.birth_date }}</div>
                <div>{{ meetup.created_at }}</div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['findMeetupsUrl'],
    data() {
        return {
            meetups: null
        }
    },
    methods: {
        find(e) {
            e.preventDefault();
            var formData = new FormData(document.getElementById('findMeetups'));
            console.debug(formData);//mmmyyy
            axios
                .post(this.findMeetupsUrl, formData)
                .then((response) => {
                    this.meetups = response.data;
                }).catch((error) => {
                    console.log(error);//mmmyyy
                });
        },
    },
    mounted() {
        console.log('Component mounted.')
    }
}
</script>
