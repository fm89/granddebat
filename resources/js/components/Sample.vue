<template>
    <div style="background: #bddcfd; padding: 20px;">
        <span><img src="/favicon-16x16.png" alt="tag"/> Voici une question et une réponse extraites du corpus <b>granddebat.fr</b></span>
        <br>
        <div style="padding: 30px">
            <div class="mb-3">
                <i class="fa fa-fw fa-question"></i>
                <i>{{ sample.question }}</i>
            </div>
            <div>
                <i class="fa-fw far fa-comment-alt"></i>
                <i>{{ sample.response }}</i>
            </div>
        </div>
        <span><img src="/favicon-16x16.png" alt="tag"/> Comment résumeriez-vous ce qu'a voulu dire <b>la répondante</b> ?</span>
        <div class="mt-4">
            <toggle-button v-for="(tag, index) in sample.tags" :key="index" :tag="tag"
                           @tagToggled="onTagToggled(tag.id)"></toggle-button>
        </div>
        <div v-if="checked">
            <br>
            <span><img src="/favicon-16x16.png" alt="tag"/> {{ greeting() }} Quel est <b>le problème</b> ?</span>
            <div class="mt-4">{{ sample.explain }}</div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                sample: this.asample,
                checked: false,
            }
        },
        props: {
            asample: {
                type: Object,
                required: true,
            },
        },
        watch: {
            asample: function (newASample) {
                this.sample = newASample;
            }
        },
        methods: {
            greeting() {
                let valid = this.sample.tags.every(function (tag) {
                    return (tag.id !== 0) ^ tag.checked;
                });
                return valid ? 'Bien vu, bravo !' : 'Seriez-vous un robot ?';
            },
            onTagToggled(tagId) {
                $.each(this.sample.tags, function (index, tag) {
                    if (tag.id === tagId) {
                        tag.checked = !tag.checked;
                    }
                });
                this.checked = this.sample.tags.some(function (tag) {
                    return tag.checked;
                });
                this.$forceUpdate();
            },
            reset() {
                $.each(this.sample.tags, function (index, tag) {
                    tag.checked = false;
                });
                this.checked = false;
                this.$forceUpdate();
            }
        }
    }
</script>
