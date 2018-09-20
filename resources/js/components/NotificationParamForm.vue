<template>
    <div>

        <heading :level="2" class="mt-6 mb-6">{{__('Send Notification To')}}</heading>

        <notification-param-input
                v-model="formObj"
                :item="notifiables.filter"
                :index="'notifiable'"
                :key="notifiables.filter.name"
                :valueKey="'name'"
                :bindToModel="selectedNotifiable.name"
        ></notification-param-input>


        <notification-param-input
                v-if="showNotifiables"
                :values="notifiables.notifiables"
        ></notification-param-input>

        <div v-if="selectedNotification.parameters.length">
            <heading :level="2" class="mb-6">Define Notification Parameters</heading>

            <notification-param-input
                    v-for="(item, index) in selectedNotification.parameters"
                    :item="item"
                    :index="index"
                    :key="item.id"
                    :valueKey="'id'"
                    :bindToModel="item.value"
            ></notification-param-input>

        </div>
    </div>
</template>

<script>

    import NotificationParamInput from "./NotificationParamInput";

    export default {
        components: {NotificationParamInput},
        props: {
            selectedNotification: null,
            selectedNotifiable: null,
            notifiables: null,
            formObj: null
        },
        data: () => ({
            showNotifiables: false,
        })
    }
</script>

