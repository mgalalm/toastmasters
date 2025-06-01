<script setup>
import Multiselect from '@vueform/multiselect';
import '@vueform/multiselect/themes/default.css';
</script>

<template>
    <Multiselect
        v-model="selected"
        :items="options"
        label="label"
        placeholder="Select an option"
        :native="true"
        search="true"
        track-by="label"
        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
    />
</template>
