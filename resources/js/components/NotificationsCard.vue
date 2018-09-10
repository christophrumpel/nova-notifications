<template>
    <div class="w-1/2">
        <p class="text-sm uppercase mb-2 text-80">{{ header }}</p>

        <div>
            <p class="text-2xl">
                {{value}}
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            value: '',
            header: ''
        },
        data: () => ({
            initialLoading: false,
            notifications: null
        }),
        mounted() {
        },
        methods: {}
    }
</script>

<style>
    /* Scoped Styles */
</style>
