<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, Head } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import { onMounted, ref } from 'vue';

const modalOpen = ref(false);

const form = useForm({
    todo: '',
    description: ''
});

</script>

<template>

<Head title="Todos"  />

<AuthenticatedLayout>
    <div class="flex justify-end max-w-2xl p-4 mx-auto sm:p-6 lg:p-8">
        <PrimaryButton @click="modalOpen = true">New Todo</PrimaryButton>
    </div>

    <Modal :show="modalOpen">
        <div class="relative w-full h-14">
            <button @click="modalOpen = false" class="absolute w-8 h-8 bg-gray-800 rounded right-4 top-3">
                <i class="fa-solid fa-xmark" style="color: #ffffff;"></i>
            </button>
        </div>

        <div class="grid w-full place-items-center h-14">
            <h1 class="text-lg">Creating new Todo</h1>
        </div>

        <div class="w-full h-auto pb-10">
            <form @submit.prevent="form.post(route('todo.store'), {onSuccess: () => form.reset(), onSuccess: () => modalOpen = false })" class="mx-32">
                <input 
                v-model="form.todo"
                placeholder="What to do?"
                class="block w-full max-w-lg m-auto border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                
                <InputError :message="form.errors.todo" class="mt-2" />

                <textarea
                v-model="form.description"
                placeholder="Description..."
                class="block w-full max-w-lg m-auto mt-4 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                ></textarea>

                <InputError :message="form.errors.description" class="mt-2" />

                <div class="flex justify-end mt-4">
                    <PrimaryButton>Create</PrimaryButton>
                </div>
            </form>
        </div>
    </Modal>

</AuthenticatedLayout>

</template>

<style>

</style>