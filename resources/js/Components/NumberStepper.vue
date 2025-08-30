<template>
    <div class="flex w-max items-center rounded border">
        <button type="button" @click="decrement" class="bg-gray-200 px-3 py-1 hover:bg-gray-300">-</button>

        <input type="number" v-model.number="value" class="w-16 border-l border-r text-center focus:outline-none" />

        <button type="button" @click="increment" class="bg-gray-200 px-3 py-1 hover:bg-gray-300">+</button>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const value = ref(1);
const min = 1;
const max = 10;

function increment() {
    if (value.value < max) value.value++;
}

function decrement() {
    if (value.value > min) value.value--;
}
</script>
