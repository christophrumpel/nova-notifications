<template>
    <div>
        <heading class="mb-6">{{__('Send Notification')}}</heading>

        <notifications-param-modal
                v-if="selectedNotification"
                :selectedNotification="selectedNotification"
                :notifiables="notifiables"
                :selectedNotifiable="selectedNotifiable"
                :formObj="formObj"
        ></notifications-param-modal>

        <loading-card :loading="initialLoading" class="flex flex-wrap py-8 mb-8 text-center">

            <table cellpadding="0" cellspacing="0" class="table w-full" v-if="notificationClasses.length">
                <thead>
                <tr>
                    <th>{{__('Name')}}</th>
                    <th>{{__('Parameters')}}</th>
                    <th></th>
                </tr>
                </thead>

                <tbody>
                <tr v-for="notificationClass in notificationClasses">
                    <td>{{ notificationClass.name }}</td>
                    <td>
                        <p v-for="param in notificationClass.parameters">
                            <span class="font-bold">{{param.name}}</span> ({{param.type}})
                        </p>
                    </td>
                    <td>
                        <button class="btn btn-default btn-primary" @click="selectNotification(notificationClass)">
                            {{__('Select')}}
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>

            <div v-else>
                <p class="m-4">{{__("You don't have any notification classes yet.")}}</p>
            </div>
        </loading-card>

    </div>
</template>

<script>

    import NotificationsParamModal from "./NotificationsParamModal";

    export default {
        components: {NotificationsParamModal},
        data: () => ({
            notificationClasses: [],
            initialLoading: true,
            error: false,
            selectedNotification: null,
            selectedNotifiable: {
                name: '',
                id: ''
            },
            notifiables: null,
            formObj: null,
        }),
        created() {
            this.getNotificationClasses();
            this.getNotifiables();
        },
        mounted() {
            this.$root.$on('submitModal', (parameters, formObj) => {
                this.formObj = formObj;
                this.formObj.notificationParameters = parameters;
                this.formObj.notification = this.selectedNotification;
                this.sendNotification();
            });

            this.$root.$on('cancelModal', () => {
                this.deselectNotification();
            });

            this.$root.$on('notifiableSelected', (event) => {
                console.log(event);
            })
        },
        methods: {
            selectNotification(notification) {
                if(!this.notifiables.data.length) {
                    return this.$toasted.show('No notifiables could be found.', {type: 'error'});
                }
                
                this.selectedNotification = notification;
            },
            deselectNotification() {
                this.selectedNotification = null;
            },
            getNotificationClasses() {
                Nova.request().get('/nova-vendor/nova-notifications/notifications/classes')
                    .then((response) => {
                        this.notificationClasses = response.data;
                        this.initialLoading = false;
                    })
            },
            getNotifiables() {
                Nova.request().get('/nova-vendor/nova-notifications/notifiables')
                    .then((response) => {
                        this.notifiables = response.data;
                    })
            },
            sendNotification() {

                if (!this.selectedNotification.name.length) {
                    return this.$toasted.show(__('Notification has not been chosen.'), {type: 'error'});
                }

                Nova.request().post('/nova-vendor/nova-notifications/notifications/send', this.formObj)
                    .then((response) => {
                        this.$toasted.show('Notification has been sent!', {type: 'success'});
                        this.selectedNotification = null;
                    }).catch(error => {
                    console.log(error);
                    this.$toasted.show('There has been an error!', {type: 'error'});
                })
            },
            setParams(params) {
                console.log(params);
            }
        }
    }
</script>

<style>
    /* Scoped Styles */
</style>
