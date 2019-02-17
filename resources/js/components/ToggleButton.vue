<template>
    <span @click="onClick()" :class="getClass()">{{ getLabel() }}</span>
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
                return 'btn tag ' + (this.tag.checked ? 'on' : 'off');
            },
            onClick() {
                this.$emit('tagToggled');
            },
            getLabel() {
                let regexp = /^[A-Z] (.*)$/g;
                let matches = regexp.exec(this.tag.name);
                if (matches != null) {
                    return matches[1];
                } else {
                    return this.tag.name;
                }
            }
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
        background-color: #EAF3F9;
        box-shadow: inset 0.5em 0 #FFF;
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