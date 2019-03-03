<template>
    <span @click="onClick()" :class="getClass()">{{ tag.label }}</span>
</template>

<script>
    export default {
        props: {
            tag: {
                type: Object,
                required: true,
            },
        },
        methods: {
            getClass() {
                return 'btn tag ' + (this.tag.checked ? 'on' : 'off') + ' ' + this.tag.color + (this.tag.is_custom ? ' italic' : '');
            },
            onClick() {
                this.$emit('tagToggled');
            },
        },
    }
</script>

<style>
    .tag {
        margin-right: 10px;
        margin-bottom: 10px;
        padding-left: 20px;
        padding-right: 20px;
    }

    .tag.on {
        background-color: #3490dc;
        color: #FFF;
        box-shadow: inset -0.5em 0 #EAF3F9;
    }

    .tag.off {
        box-shadow: inset 0.5em 0 #FFF;
    }
    .tag.blue.off {
        background-color: #EAF3F9;
    }
    .tag.gray.off {
        background-color: #EEE;
    }

    .italic {
        font-style: italic;
    }

    @media (hover: hover) {
        .tag.on:hover {
            background-color: #2B76B5;
            color: #FFF;
        }

        .tag.off:hover {
            background-color: #6BAEE5;
            color: #FFF;
        }
    }
</style>