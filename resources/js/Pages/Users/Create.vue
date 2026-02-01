<template>
    <AppLayout>
        <Container>
            <div class="mx-auto max-w-2xl p-4">
                <div class="mb-6 flex items-center justify-between">
                    <h1 class="text-2xl font-bold">{{ isEdit ? 'Edit User' : 'Create User' }}</h1>
                </div>

                <form @submit.prevent="submit">
                    <div>
                        <InputLabel for="name" value="Name" />
                        <TextInput
                            id="name"
                            v-model="userForm.name"
                            type="text"
                            class="mt-1 block w-full"
                            autocomplete="name"
                        />
                        <InputError :message="userForm.errors.name" class="mt-1" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="email" value="Email" />
                        <TextInput
                            id="email"
                            v-model="userForm.email"
                            type="email"
                            class="mt-1 block w-full"
                            autocomplete="email"
                        />
                        <InputError :message="userForm.errors.email" class="mt-1" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="role" value="Role" />
                        <SelectInput
                            id="role"
                            :options="roleOptions"
                            label="label"
                            value-prop="value"
                            class="!mt-1"
                            v-model="userForm.role"
                        />
                        <InputError :message="userForm.errors.role" class="mt-1" />
                    </div>

                    <div class="mt-4">
                        <InputLabel :value="isEdit ? 'Password (leave blank to keep)' : 'Password'" for="password" />
                        <TextInput
                            id="password"
                            v-model="userForm.password"
                            type="password"
                            class="mt-1 block w-full"
                            :autocomplete="isEdit ? 'current-password' : 'new-password'"
                        />
                        <InputError :message="userForm.errors.password" class="mt-1" />
                    </div>

                    <div class="mt-4">
                        <InputLabel for="profile_photo_path" value="Profile Photo URL" />
                        <TextInput
                            id="profile_photo_path"
                            v-model="userForm.profile_photo_path"
                            type="text"
                            class="mt-1 block w-full"
                            autocomplete="off"
                        />
                        <InputError :message="userForm.errors.profile_photo_path" class="mt-1" />
                    </div>

                    <div class="mt-4">
                        <label class="flex items-center">
                            <Checkbox v-model:checked="userForm.active" name="active" />
                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Active</span>
                        </label>
                        <InputError :message="userForm.errors.active" class="mt-1" />
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button
                            type="button"
                            class="mr-2 rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            @click="cancel"
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
import Checkbox from '@/Components/Checkbox.vue';
import Container from '@/Components/Container.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import SelectInput from '@/Components/SelectInput.vue';
import TextInput from '@/Components/TextInput.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

const roleOptions = [
    { label: 'Member', value: 'member' },
    { label: 'Admin', value: 'admin' },
];

const props = defineProps({
    user: {
        type: Object,
        default: () => ({}),
    },
    isEdit: {
        type: Boolean,
        default: false,
    },
});

const userForm = useForm({
    name: props.user.name || '',
    email: props.user.email || '',
    role: props.user.role || 'member',
    password: '',
    profile_photo_path: props.user.profile_photo_path || '',
    active: props.user.active ?? true,
});

const submit = () => {
    if (props.isEdit) {
        userForm.put(route('users.update', props.user.id));
        return;
    }

    userForm.post(route('users.store'));
};

const cancel = () => {
    window.history.back();
};
</script>
