<template>
    <div class="talk py-3 container" :class="{ 'talkIsOpen': talkIsOpen }">
        <div class="row">
            <div class="col-2"><img v-if="meetup.profile_photo" :src="meetup.profile_photo" class="w-100" /></div>
            <div class="col-7">
                {{ meetup.id }}
                <div><b>{{ __('Name') }}: </b>{{ meetup.name }}</div>
                <div><b>{{ __('Email') }}: </b>{{ meetup.email }}</div>
                <div><b>{{ __('Gender') }}: </b>{{ __(ucfirst(meetup.gender)) }}</div>
                <div><b>{{ __('Birth date') }}: </b>{{ meetup.birth_date }}</div>
            </div>
            <div class="col-3" style="position: relative;">
                <div><b>{{ __('Account from') }}: </b>{{ meetup.created_at }}</div>
                <button @click="toggleTalk" type="button" class="btn btn-primary" style="position: absolute; bottom: 0;">{{
                    talkIsOpen ? __('Close') : __('Talk') }}</button>
            </div>
        </div>
        <div v-if="talkIsOpen">
            <ul class="list-group">
                <li class="list-group-item list-group-item-light" v-for="(privMessage) in privMessages">
                    {{ privMessage.priv_message }}</li>
            </ul>
            <form class="row privMessageForm" :id="'privMessageForm' + meetup.id" @submit="sendPrivMessage">
                <input type="hidden" :value="meetup.id" name="toUserId">
                <input type="hidden" value="" :id="'privMessageInput' + meetup.id" name="privMessage">
                <div class="col-9" @focusout="privMessageFocusOut">
                    <div contenteditable="true" class="privMessage" placeholder="Type your text here"
                        :id="'privMessage' + meetup.id"></div>
                </div>
                <div class="col-3">
                    <button type="submit" class="btn btn-primary sendBtm">{{ __('Send') }}</button>
                </div>
            </form>
        </div>

    </div>
</template>

<script>
export default {
    props: {
        getPrivMessagesUrl: String,
        getPrivTalkUrl: String,
        privMessageUrl: String,
        meetup: {
            type: Object,
            default: null
        },
    },
    data() {
        return {
            talkIsOpen: false,
            privTalkId: null,
            privMessages: {},
        }
    },
    methods: {
        sendPrivMessage(e) {
            e.preventDefault();
            document.getElementById('privMessageInput' + this.meetup.id).value = document.getElementById('privMessage' + this.meetup.id).innerHTML;
            var formData = new FormData(document.getElementById('privMessageForm' + this.meetup.id));
            axios
                .post(this.privMessageUrl, formData)
                .then((response) => {
                    if (!this.privTalkId && response.data.privTalkId) {
                        this.privTalkId = response.data.privTalkId;
                        this.connectChannel();
                    }
                }).catch((error) => {
                    console.log(error);
                });
        },
        privMessageFocusOut(e) {
            if ('<br>' === e.target.innerHTML) {
                e.target.innerHTML = '';
            }
        },
        toggleTalk() {
            if (this.talkIsOpen) {
                this.disConnectPrivTalk();
            } else {
                this.connectPrivTalk();
            }
        },
        connectPrivTalk() {
            axios
                .post(this.getPrivTalkUrl, { toUserId: this.meetup.id })
                .then((response) => {
                    if (!response.data.privTalkId) {
                        this.talkIsOpen = true;
                        return;
                    }
                    this.privTalkId = response.data.privTalkId;
                    this.connectChannel();
                }).catch((error) => {
                    console.log(error);
                });
        },
        connectChannel() {
            if (!this.privTalkId) {
                return;
            }
            Echo.join('App.Models.PrivTalk.' + this.privTalkId)
                // .here((users) => {
                // })
                .listen('.PrivMessageCreated', (e) => {
                    this.addPrivMessages([e.model]);
                })
                .subscribed((e) => {
                    this.talkIsOpen = true;
                    this.displayLastPrivMessages(5);
                });
        },
        displayLastPrivMessages(privMessagesNum) {
            axios
                .post(this.getPrivMessagesUrl, { toUserId: this.meetup.id, privMessagesNum: privMessagesNum })
                .then((response) => {
                    var privMessages = response.data.privMessages;
                    if (!privMessages) {
                        return;
                    }
                    this.addPrivMessages(privMessages);
                }).catch((error) => {
                    console.log(error);
                });
        },
        disConnectPrivTalk() {
            Echo.leave('App.Models.PrivTalk.' + this.privTalkId);
            this.talkIsOpen = false;
        },
        addPrivMessages(privMessages) {
            for (const privMessage of privMessages) {
                this.privMessages[privMessage.id] = {
                    priv_message: privMessage.priv_message,
                };
            }
        },
        ucfirst(str) {
            if (str) {
                return str[0].toUpperCase() + str.slice(1);
            }
        }
    }
}
</script>
