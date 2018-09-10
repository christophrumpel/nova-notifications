<template>
    <div class="bg-30 px-6 py-3 flex">
        <div class="ml-auto">
            <button type="button" data-testid="cancel-button" @click="handleCancel"
                    class="btn text-80 font-normal h-9 px-3 mr-3 btn-link">Cancel
            </button>
            <button class="btn btn-default btn-primary" @click="handleSubmit">
                <span>Send</span>
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            formObj: null,
            selectedNotification: null
        },
        data: () => ({
        }),
        methods: {
            handleSubmit: function() {
                console.log(this.selectedNotification);
                this.$root.$emit('submitModal', this.selectedNotification.parameters, this.formObj)
            },
            handleCancel: function() {
                this.$root.$emit('cancelModal')
            }
        }
    }
</script>
