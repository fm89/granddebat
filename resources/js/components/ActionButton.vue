<template>
    <button :class="'btn mybtn ' + btnClass" @click="onClick()" :disabled="disabled || loading">
        <i :class="loading ? 'fa fa-spinner fa-spin' : 'fa ' + iconClass"></i>
        <span class="d-none d-sm-inline">{{ text }}</span>
    </button>
</template>

<script>
    export default {
        data() {
            return {
                loading: false,
            }
        },
        props: {
            disabled: {
                type: Boolean,
                required: true,
            },
            btnClass: {
                type: String,
                required: true,
            },
            iconClass: {
                type: String,
                required: true,
            },
            text: {
                type: String,
                required: true,
            },
        },
        methods: {
            onClick() {
                this.loading = true;
                let self = this;
                this.$emit('clicked', function () {
                    self.loading = false;
                });
            },
        },
    }
</script>

<style>
    .mybtn {
        padding: 8px 14px;
    }

    @media only screen
    and (max-width: 576px) {
        .mybtn {
            padding: 12px 18px;
        }
    }

    .mybtn > .fa {
        font-size: 1.33em;
        vertical-align: -10%;
    }
</style>
