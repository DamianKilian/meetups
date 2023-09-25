<template>
    <label class="col-md-4 col-form-label text-md-end">{{ __('Profile photo') }}</label>
    <div class="fileUploadWrapper col-md-6">
        <div class="area">
            <input type="file" name="profilePhoto" @change="change" ref="file" />
        </div>
        <img v-if="file" class="preview-img" :src="fileSrc" />
        <div v-if="file" class="info">
            {{ file.name }} ({{ Math.round(file.size / 1000) + "kb" }})
        </div>
        <i class="fa-regular fa-circle-xmark removePhoto" v-if="file" @click="removePhoto"></i>
    </div>
</template>
  
<script>
export default {
    data() {
        return {
            file: null,
            fileSrc: '',
        };
    },
    methods: {
        removePhoto() {
            this.$refs.file.value = null;
            this.file = null;
            console.debug('removePhoto');//mmmyyy
        },
        change() {
            this.file = this.$refs.file.files[0];
            this.generateURL();
        },
        generateURL() {
            var fileSrc = URL.createObjectURL(this.file);
            setTimeout(() => {
                URL.revokeObjectURL(fileSrc);
            }, 1000);
            this.fileSrc = fileSrc;
        },
    },
};
</script>
  