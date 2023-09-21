<template>
    <div>
        <i :class="{ 'text-success': showFormSett }" class="p-2 mt-n2 me-n2 fa-solid fa-sliders float-end formSett"
            @click="showFormSett = !showFormSett"></i>
        <form @submit="find" id="findMeetups" v-if="showFormSett">
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
            <div class="mb-3">
                <input name="gender" type="radio" class="btn-check" id="none" value="" autocomplete="off" checked>
                <label class="btn btn-secondary me-1" for="none">{{ __('None') }}</label>
                <input name="gender" type="radio" class="btn-check" id="male" value="male" autocomplete="off">
                <label class="btn btn-secondary me-1" for="male">{{ __('Male') }}</label>
                <input name="gender" type="radio" class="btn-check" id="female" value="female" autocomplete="off">
                <label class="btn btn-secondary" for="female">{{ __('Female') }}</label>
            </div>
            <div class="row mb-3 gx-0 text-center">
                <label class="form-label text-start">{{ __('Birth date') }}</label>
                <label for="fromBirthDate" class="col-sm-1 col-form-label">{{ __('From') }}: </label>
                <div class="col">
                    <input name="fromBirthDate" type="date" class="form-control" aria-label="First name">
                </div>
                <label for="toBirthDate" class="col-sm-1 col-form-label">{{ __('To') }}: </label>
                <div class="col">
                    <input name="toBirthDate" type="date" class="form-control" aria-label="Last name">
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary">{{ __('Find') }}</button>
            </div>
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
            meetups: null,
            showFormSett: true
        }
    },
    methods: {
        find(e) {
            e.preventDefault();
            var formData = new FormData(document.getElementById('findMeetups'));
            axios
                .post(this.findMeetupsUrl, formData)
                .then((response) => {
                    this.meetups = response.data;
                }).catch((error) => {
                    console.log(error);
                });
        },
        formSettToggle(e) {

        }
    },
    mounted() {
        console.log('Component mounted.')
    }
}
</script>
