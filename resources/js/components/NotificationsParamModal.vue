<template>
    <modal v-if="selectedNotification">

        <div class="bg-white rounded-lg shadow-lg overflow-hidden" style="width: 600px;">
            <div class="p-8">

                <heading :level="1" class="mt-6 mb-6">{{ selectedNotification.name}}</heading>

                <!-- START Notifiable Select -->
                <heading :level="2" class="mt-6 mb-6">Send Notification To</heading>
                <div class="md:flex md:items-center mb-6" v-if="formObj.notifiable">
                    <div class="md:w-1/3">
                        <label class="block text-grey font-bold md:text-right mb-1 md:mb-0 pr-4"
                               for="notifiable-item">
                            Notifiable
                        </label>
                    </div>

                    <div class="md:w-2/3">
                        <div class="relative">

                            <select id="notifiable-item" v-model="formObj.notifiable.name"
                                    class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-grey">
                                <option v-for="option in notifiables.filter.options" :value="option.name">
                                    {{ option.name }}
                                </option>
                            </select>
                            <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Notifiable Selects -->

                <!-- START Notifiable Item Select -->
                <div class="md:flex md:items-center mb-6" v-if="formObj.notifiable.name">
                    <div class="md:w-1/3">
                        <label class="block text-grey font-bold md:text-right mb-1 md:mb-0 pr-4"
                               for="notifiable">
                            Notifiable Item
                        </label>
                    </div>

                    <div class="md:w-2/3">
                        <div class="relative">

                            <select id="notifiable" v-model="formObj.notifiable.value"
                                    class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-grey">
                                <option v-for="option in getNotifiableItems(formObj.notifiable.name)"
                                        :value="option.id">
                                    {{ option.name }} (id:{{ option.id }})
                                </option>
                            </select>
                            <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Notifiable Item Select -->


                <!-- START Notification Parameters -->
                <heading :level="2" class="mt-6 mb-6" v-if="selectedNotification.parameters.length">
                    Define Notification Parameters
                </heading>
                <div class="md:flex md:items-center mb-6" v-if="selectedNotification.parameters.length"
                     v-for="(param, index) in selectedNotification.parameters">
                    <div class="md:w-1/3">
                        <label class="block text-grey font-bold md:text-right mb-1 md:mb-0 pr-4"
                               for="notifiable-item">
                            {{ param.name }}
                        </label>
                    </div>

                    <div class="md:w-2/3">
                        <div class="relative" v-if="param.options">
                            <select v-model="param.value"
                                    class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-grey">
                                <option v-for="option in param.options" :value="option.id">
                                    {{ option.name }}
                                </option>
                            </select>
                            <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                     viewBox="0 0 20 20">
                                    <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                                </svg>
                            </div>
                        </div>
                        <input
                                v-else v-model="param.value"
                                :id="'value-' + index" type="text"
                                class="w-full h-full form-control form-input form-input-bordered py-3"
                                :placeholder="param.type" autofocus required>
                    </div>
                </div>
                <!-- END Notification Parameters -->


            </div>

            <notification-modal-footer
                    :selectedNotification="selectedNotification"
                    :formObj="formObj"/>
        </div>
    </modal>
</template>

<script>
    import NotificationParamForm from "./NotificationParamForm";
    import NotificationModalFooter from "./NotificationModalFooter";

    export default {
        components: {
            NotificationParamForm,
            NotificationModalFooter
        },
        props: {
            selectedNotification: null,
            selectedNotifiable: null,
            notifiables: null,
            value: Object,
        },
        data: () => ({
            formObj: {
                notifiable: {
                    name: '',
                    value: ''
                },
                notification: null,
                notificationParameters: [],

            },
        }),

        methods: {
            getNotifiableItems(name) {
                return _.find(this.notifiables.data, {name: name}).options;
            }
        }
    }
</script>

<style>
    /* Scoped Styles */
</style>
