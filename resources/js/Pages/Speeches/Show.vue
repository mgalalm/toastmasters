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
            <p><strong>Pathway:</strong> {{ speech.pathway }}</p>
        </Container>
    </AppLayout>
</template>
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Container from '@/Components/Container.vue';
import PageHeading from '@/Components/PageHeading.vue';
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/20/solid';
import { router, usePage } from '@inertiajs/vue3';
import {
    BriefcaseIcon,
    CalendarIcon,
    CheckIcon,
    ChevronDownIcon,
    CurrencyDollarIcon,
    LinkIcon,
    MapPinIcon,
    PencilIcon,
    TrashIcon,
    ShoppingBagIcon,
    CheckBadgeIcon,
} from '@heroicons/vue/20/solid';

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
