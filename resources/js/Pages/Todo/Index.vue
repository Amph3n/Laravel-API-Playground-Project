<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, Head } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import { ref } from 'vue';

const modalOpen = ref(false);
</script>

<template>

<Head title="Todos"  />

<AuthenticatedLayout>
    <div class="flex justify-end max-w-2xl p-4 mx-auto sm:p-6 lg:p-8">
        <PrimaryButton @click="modalOpen = true">New Todo</PrimaryButton>
    </div>

    <Modal :show="modalOpen">
        <div class="flex justify-end w-full h-9">
            <button @click="modalOpen = false" class="w-8 h-full rounded bg-cyan-700"></button>
        </div>
        <p>Hello modal :)</p>
    </Modal>

</AuthenticatedLayout>

</template>

<style>

</style>