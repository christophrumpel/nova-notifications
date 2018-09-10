<template>
    <div class="md:flex md:items-center mb-6">
        <div class="md:w-1/3">
            <label class="block text-grey font-bold md:text-right mb-1 md:mb-0 pr-4"
                   :for="'value-' + index">
                {{ value.name }}
            </label>
        </div>

        <div class="md:w-2/3">
            <div class="relative" v-if="value.options">
                <select v-model="value.value"
                        class="block appearance-none w-full bg-grey-lighter border border-grey-lighter text-grey-darker py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-grey">
                    <option v-for="option in value.options" :value="option['']">
                        {{ option.name }} {{option.id ? '(id: ' + option.id + ')' : '' }}
                    </option>
                </select>
                <div class="pointer-events-none absolute pin-y pin-r flex items-center px-2 text-grey-darker">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/>
                    </svg>
                </div>
            </div>
            <input v-else v-model="value.value" :id="'value-' + index" type="text"
                   class="w-full h-full form-control form-input form-input-bordered py-3"
                   :placeholder="value.type" autofocus required>
        </div>
    </div>
</template>

<script>
    export default {

        props: {
            value: null,
            index: null
        },
        data: () => ({}),
        mounted() {
        },
        methods: {}
    }
</script>
