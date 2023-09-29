<template>
    <div class="dropdown customSelect">
        <button @click="getRegions" class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
            aria-expanded="false">
            {{ region.name }}
        </button>
        <ul class="dropdown-menu" @click="selectRegion">
            <li><a data-region-id="" :data-region-name="__('Select region')" class="dropdown-item"
                    style="cursor: pointer;">{{ __('None') }}</a></li>
            <li v-for="(region, index) in regions"><a :data-region-id="region.id" :data-region-name="region.name"
                    class="dropdown-item" style="cursor: pointer;">{{ region.name }}</a></li>
            <li v-if="0 === regions.length"><a class="dropdown-item" href="#"><i
                        class="fa-solid fa-spinner fa-pulse"></i></a></li>
        </ul>
    </div>
    <input type="hidden" name="region" :value="region.id" />
</template>

<script>
export default {
    props: {
        getRegionsUrl: String,
        oldRegionId: String,
        regionProp: Object,
    },
    data() {
        return {
            region: { name: __('Select region'), id: '' },
            regions: [],
            gettingRegions: false,
        }
    },
    methods: {
        setRegion() {
            if (this.oldRegionId) {
                this.region.id = this.oldRegionId;
                if (typeof (Storage) !== "undefined") {
                    if (sessionStorage.oldRegionName) {
                        this.region.name = sessionStorage.oldRegionName;
                    } else {
                        this.region.name = '';
                    }
                } else {
                    this.region.name = '';
                }
            } else if(this.regionProp){
                this.region = this.regionProp;
            }
        },
        selectRegion(e) {
            var regionId = e.target.dataset.regionId;
            var regionName = e.target.dataset.regionName;
            if ('undefined' === typeof regionId) {
                return;
            }
            this.region = { name: regionName, id: regionId };
            if (!this.regionProp && typeof (Storage) !== "undefined") {
                sessionStorage.oldRegionName = regionName;
            }
        },
        getRegions() {
            if (this.gettingRegions) {
                return;
            }
            this.gettingRegions = true;
            axios
                .post(this.getRegionsUrl)
                .then((response) => {
                    this.regions = response.data;
                }).catch((error) => {
                    this.gettingRegions = false;
                    console.log(error);
                });
        }
    },
    mounted() {
        this.setRegion();
    }
}
</script>
