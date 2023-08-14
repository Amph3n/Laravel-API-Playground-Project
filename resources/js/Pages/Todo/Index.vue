<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import Todo from '@/Components/Todo.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm, Head } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import { onMounted, ref } from 'vue';
import anime from 'animejs';

const modalOpen = ref(false);

defineProps(['todos']);

const form = useForm({
    todo: '',
    description: ''
});

function CancelButton(e) {
    e.preventDefault();
    modalOpen.value = false;
}

</script>

<template>

<Head title="Todos"  />

<AuthenticatedLayout>
    <div class="flex justify-between px-4 mx-auto mt-10 max-w-7xl sm:px-6 lg:px-8">
        <h1 class="pt-1 pl-3 text-2xl font-black">Todos</h1>
        <div></div>
        <PrimaryButton @click="modalOpen = true">New Todo</PrimaryButton>
    </div>

    <Modal :show="modalOpen">
        <div class="grid w-full mt-5 place-items-center h-14">
            <h1 class="text-lg font-bold">Creating new Todo</h1>
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
                    <div class="w-3"></div>
                    <SecondaryButton @click="CancelButton">Cancel</SecondaryButton>
                </div>
            </form>
        </div>
    </Modal>

    <div class="px-4 pt-2 pb-5 mx-auto mt-6 shadow max-w-7xl sm:px-6 lg:px-8">
        <Todo
        v-for="todo in todos"
        :key="todo.id"
        :todo="todo"
        ></Todo>
    </div>

</AuthenticatedLayout>

</template>

<style>

</style>