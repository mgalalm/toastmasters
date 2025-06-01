<template>
    <AppLayout>
        <Container>
            <div class="mx-auto max-w-2xl p-4">
                <form @submit.prevent="addSpeech">
                    <div>
                        <!-- <label for="title" class="block text-sm font-medium text-gray-700">Title</label> -->
                        <InputLabel for="title">Title</InputLabel>
                        <TextInput
                            type="text"
                            id="title"
                            name="title"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            placeholder="How to save a life"
                            v-model="speechForm.title"
                        />
                        <InputError :message="speechForm.errors.title" class="mt-1" />
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-4">
                        <div>
                            <InputLabel for="type">Pathway</InputLabel>
                            <SelectInput
                                :options="pathways"
                                label-prop="name"
                                class="!mt-1"
                                v-model="speechForm.pathway"
                            ></SelectInput>
                            <InputError :message="speechForm.errors.pathway" class="mt-1" />
                        </div>
                        <div>
                            <InputLabel for="length">Length (mins)</InputLabel>
                            <TextInput
                                type="text"
                                id="length"
                                name="length"
                                v-model="speechForm.length"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            />
                            <InputError :message="speechForm.errors.length" class="mt-1" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <InputLabel for="abstract">Objectives</InputLabel>
                        <TextArea rows="4" class="mt-1" v-model="speechForm.objectives"></TextArea>
                        <p class="mt-1 text-sm text-gray-500">
                            Describe the objectives of your talk. What will the audience learn?
                        </p>
                        <InputError :message="speechForm.errors.objectives" class="mt-1" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="organizer_notes">Evaluator Notes</InputLabel>
                        <TextArea rows="4" class="mt-1" v-model="speechForm.evaluator_notes"></TextArea>
                        <p class="mt-1 text-sm text-gray-500">
                            Write any notes you may want to pass to the evaluator about this talk.
                        </p>
                    </div>

                    <div class="flex justify-end">
                        <button
                            type="button"
                            class="mr-2 rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </Container>
    </AppLayout>
</template>

<script setup>
import Container from '@/Components/Container.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextArea from '@/Components/TextArea.vue';
import { useForm } from '@inertiajs/vue3';
import SelectInput from '@/Components/SelectInput.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    pathways: {
        type: Array,
        required: true,
    },
    errors: {
        type: Object,
        default: () => ({}),
    },
});

// console.log('pathways:', props.pathways);

const speechForm = useForm({
    title: '',
    pathway: '',
    length: '',
    objectives: '',
    evaluator_notes: '',
});

const addSpeech = () => {
    speechForm.post(route('speeches.store'), {
        onSuccess: () => {
            // console.log('Speech created successfully');
            // dump the form data to console
            console.log('Form Data:', {
                title: speechForm.title,
                pathway: speechForm.pathway,
                length: speechForm.length,
                objectives: speechForm.objectives,
                evaluator_notes: speechForm.evaluator_notes,
            });

            // speechForm.reset();
        },
        onError: (errors) => {
            console.error(errors);
        },
    });
};
</script>
