<template>
    <loading-card :loading="initialLoading" class="flex flex-wrap py-8 mb-8 text-center">

        <table cellpadding="0" cellspacing="0" class="table w-full">
            <thead>
            <tr>
                <th class="">
                    ID
                </th>
                <th class="">
                    Notification
                </th>
                <th class="">
                    Notifiable Type
                </th>
                <th class="">
                    Notifiable ID
                </th>
                <th class="">
                    Channel
                </th>
                <th class="">
                    Sent
                </th>
                <th class="">
                    Date
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="notification in notifications">
                <td>{{notification.id}}</td>
                <td>{{notification.notification}}</td>
                <td>{{notification.notifiable_type}}</td>
                <td>{{notification.notifiable_id}}</td>
                <td>{{notification.channel}}</td>
                <td>
                    <svg :is="notification.failed ? 'icon-failed' : 'icon-success'" height="24px"/>
                </td>
                <td>{{notification.created_at}}</td>
            </tr>
            </tbody>
        </table>
    </loading-card>

</template>

<script>
    import IconSuccess from './icons/IconSuccess';
    import IconFailed from './icons/IconFailed';

    export default {
        data: () => ({
            initialLoading: true,
            notifications: null
        }),
        mounted() {
            this.loadNotifications();
        },
        methods: {
            loadNotifications() {
                Nova.request().get('/nova-vendor/nova-notifications/notifications').then(response => {
                    this.notifications = response.data;
                    this.initialLoading = false;
                })
            },
        },
        components: {
            IconSuccess,
            IconFailed,
        }
    }
</script>

<style>
    /* Scoped Styles */
</style>
