<template>
    <span @click="onClick()" :class="getClass()">
        <i :class="'fas logo ' + (tag.checked ? 'fa-check-circle' : 'fa-circle')"></i>
        {{ tag.label }}
    </span>
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
        cursor: pointer;
        line-height: 20px;
        margin-right: 10px;
        margin-bottom: 10px;
        padding-right: 16px;
        padding-left: 38px;
        text-align: left;
    }

    .tag.on {
        background-color: #3490dc;
        color: #FFF;
    }

    .logo {
        font-weight: 900;
        font-size: 18px;
        color: #fff;
        margin-right: 5px;
        margin-left: -28px;
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