<template>
    <div>
        <div class="row mb-3">
            <div class="col-sm-4 limit-header mb-3">
                <span @click="onHeaderClicked(0)" :style="selected == 0 ? 'font-weight: bold' : ''">Contresens</span>
            </div>
            <div class="col-sm-4 limit-header mb-3">
                <span @click="onHeaderClicked(1)" :style="selected == 1 ? 'font-weight: bold' : ''">Confusion</span>
            </div>
            <div class="col-sm-4 limit-header mb-3">
                <span @click="onHeaderClicked(2)" :style="selected == 2 ? 'font-weight: bold' : ''">Incompréhension</span>
            </div>
        </div>
        <sample ref="sample" :asample="sample"></sample>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                sample: this.samples[0],
                selected: 0,
            }
        },
        props: {
            samples: {
                type: Array,
                required: true,
            },
        },
        methods: {
            onHeaderClicked(id) {
                this.selected = id;
                this.sample = this.samples[id];
                this.$refs.sample.reset();
            },
        }
    }
</script>

<style>
    .limit-header {
        text-align: center;
    }

    .limit-header span {
        background-image: linear-gradient(to right, transparent 50%, #BDDCFD 50%);
        background-size: 200% 10%;
        background-repeat: repeat-x;
        background-position: -100% 100%;
    }

    .limit-header span:hover {
        cursor: pointer;
    }
</style>
