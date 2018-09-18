<template>
    <div>
        <heading class="mb-6">{{__('Nova Notifications')}}</heading>
        <loading-card :loading="initialLoading" class="flex flex-wrap py-8 mb-8 text-center">
            <notification-card header="Notifications Sent" :value="notificationsCount"></notification-card>
            <notification-card header="Notifications Failed" :value="notificationsFailedCount"></notification-card>
        </loading-card>
        <notifications-table v-if="notificationsCount > 0"></notifications-table>
    </div>
</template>

<script>
    import NotificationsTable from "./NotificationsTable";
    import NotificationsCard from "./NotificationsCard";

    export default {
        components: {NotificationCard: NotificationsCard, NotificationsTable},
        data: () => ({
            initialLoading: true,
            notificationsCount: 0,
            notificationsFailedCount: 0
        }),
        created() {
            this.getNotificationStats();
        },
        methods: {
            getNotificationStats() {
                Nova.request().get('/nova-vendor/nova-notifications/notifications/stats')
                    .then((response) => {
                        this.notificationsCount = response.data.all;
                        this.notificationsFailedCount = response.data.failed;
                        this.initialLoading = false;
                    })
            },
            getNotificationsFailedCount() {
                Nova.request().get('/nova-vendor/nova-notifications/notifications-failed-count')
                    .then((response) => {
                        this.notificationsFailedCount = response.data;
                        this.initialLoading = false;
                    })
            },
        }
    }
</script>

<style>
    /* Scoped Styles */
</style>
