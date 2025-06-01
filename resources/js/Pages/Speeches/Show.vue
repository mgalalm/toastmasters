<template>
    <AppLayout>
        <Container>
            <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="border-b border-gray-200 bg-white p-6">
                        <h1 class="mb-4 text-2xl font-bold">Speech Details</h1>
                        <p><strong>Title:</strong> {{ speech.title }}</p>
                        <p><strong>Pathway:</strong> {{ speech.pathway }}</p>
                        <!-- <p><strong>Content:</strong> {{ speech.content }}</p> -->
                        <!-- <p><strong>Date:</strong> {{ speech.date }}</p> -->
                    </div>
                </div>
            </div>
        </Container>
    </AppLayout>
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Container from '@/Components/Container.vue';

defineProps({
    speech: {
        type: Object,
        required: true,
    },
});
</script>
