<template>
    <blockquote>
        <p class="quotation">
            <span v-for="line in formattedText()">{{ line }}<br/></span>
        </p>
        <footer>
            &ndash;
            <a target="_blank" :href="'/proposals/' + response.proposal_id">{{ response.published_at }}</a>,
            <a target="_blank"
               :href="'https://www.openstreetmap.org/search?query=' + encodeURI(response.city + ', France')">
                {{ response.city }}&nbsp;<i class="fa fa-map-marker-alt"></i>
            </a>
        </footer>
    </blockquote>
</template>

<script>
    export default {
        props: {
            response: {
                type: Object,
                required: true,
            },
        },
        methods: {
            formattedText() {
                return this.response.value.split("\n");
            },
        }
    }
</script>

<style>
    .quotation {
        margin: 5px;
    }
</style>