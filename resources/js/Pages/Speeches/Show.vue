<template>
    <AppLayout>
        <Container>
            <PageHeading :title="speech.title">
                <template #actions>
                    <span class="hidden sm:block">
                        <form @submit.prevent="deleteSpeech">
                            <button
                                type="submit"
                                class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                            >
                                <TrashIcon class="-ml-0.5 mr-1.5 size-5 text-gray-400" aria-hidden="true" />
                                Delete
                            </button>
                        </form>
                    </span>

                    <span class="ml-3 hidden sm:block">
                        <button
                            type="button"
                            class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50"
                            @click="router.visit(route('speeches.edit', speech.id))"
                        >
                            <PencilIcon class="-ml-0.5 mr-1.5 size-5 text-gray-400" aria-hidden="true" />
                            Edit
                        </button>
                    </span>

                    <span class="sm:ml-3">
                        <button
                            type="button"
                            class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                        >
                            <CheckIcon class="-ml-0.5 mr-1.5 size-5" aria-hidden="true" />
                            Publish
                        </button>
                    </span>
                </template>
            </PageHeading>

            <h1 class="mb-4 text-2xl font-bold"></h1>
            <p>
                <strong>By:</strong>
                <Link
                    :href="route('users.show', { id: speech.speaker_id })"
                    class="font-medium text-gray-900 dark:text-white"
                    >{{ speech.speaker }}</Link
                >
            </p>
            <p><strong>Pathway:</strong> {{ speech.pathway }}</p>
            <p><strong>Level:</strong> {{ speech.level }}</p>
            <p><strong>Project:</strong> {{ speech.project }}</p>
            <p class="mt-4"><strong>Objectives:</strong></p>
            <p>{{ speech.objectives }}</p>
            <p class="mt-4"><strong>Evaluator Notes:</strong></p>
            <p>{{ speech.evaluator_notes }}</p>
        </Container>
    </AppLayout>
</template>
<script setup>
import Container from '@/Components/Container.vue';
import PageHeading from '@/Components/PageHeading.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { CheckIcon, PencilIcon, TrashIcon } from '@heroicons/vue/20/solid';
import { Link, router } from '@inertiajs/vue3';

// import { useRouter } from '@inertiajs/vue3';

import { useConfirm } from '@/Utilities/Composables/useConfirm';

const { confirmation } = useConfirm();

const props = defineProps({
    speech: {
        type: Object,
        required: true,
    },
});

const deleteSpeech = async () => {
    console.log('Deleting speech:', props.speech.id);
    if (
        !(await confirmation(
            'Are you sure you want to delete this speech?',
            'This action cannot be undone.',
            'Delete Speech',
        ))
    )
        return;

    router.delete(route('speeches.destroy', props.speech.id), {
        onSuccess: () => {
            console.log('Speech deleted successfully');
        },
        onError: (error) => {
            console.error('Error deleting speech:', error);
        },
    });
};
</script>
