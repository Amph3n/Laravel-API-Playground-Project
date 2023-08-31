<script setup>
import { Link, useForm } from "@inertiajs/vue3";
import anime from "animejs";
import Checkbox from "@/Components/Checkbox.vue";
import { onMounted, ref } from "vue";
import Dropdown from "@/Components/Dropdown.vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputError from "@/Components/InputError.vue";
import DangerButton from "@/Components/DangerButton.vue";

const props = defineProps(['todo']);

const form = useForm({
    id: props.todo.id,
    user_id: props.user_id,
    done: props.todo.done,
    todo: props.todo.todo,
    description: props.todo.description,
});

let open = ref(false);
let checkmark = ref(true);
let updateModalOpen = ref(false);
let deleting = ref(false);

function FadeIn(_id) {
  if (open.value) {
    return;
  }

  const id = "#id" + _id;

  anime({
    targets: id,
    translateY: -2,
    boxShadow: 'rgba(179, 179, 179, 0.2) 0px 3px 2px -1px',
  })
}

function FadeOut(_id) {
  if (open.value) {
    return;
  }

  const id = "#id" + _id;

  anime({
    targets: id,
    translateY: 0,
    boxShadow: 'rgba(179, 179, 179, 0.0) 1px 0px 1px -1px',
  })
}

function SpinGear(_id) {
  const id = "#gear" + _id;

  anime({
    targets: id,
    rotate: [0, 180],
    duration: 2000
  })
}

function ToggleDescription(_id) { 
  const id = "#description" + _id;

  if (open.value) {
    FadeOut(_id);
    open.value = false;

    anime({
      targets: id,        
      opacity: 0,
      height: 0,
      duration: 250,
      easing: 'easeInOutQuad',
      complete: function() {
        document.querySelector(id).style.display = 'none';
      },
    });
    
  } else {
    FadeIn(_id);
    open.value = true;

    anime({
      targets: id,        
      opacity: 1,
      height: 200,
      duration: 600,
      easing: 'easeOutElastic(1, .8)',
      begin: function() {
        document.querySelector(id).style.display = 'block';
      },
    });
  }
}

function CheckMarkClicked(_id) {
  const mark = (form.done > 0) ? 0 : 1;
  form.done = mark;
  form.put(route('checkmark', _id), { onSuccess: () => console.log("Record updated") });
}

function ToggleUpdateModal() {
  updateModalOpen.value = !updateModalOpen.value;
}

function ToggleDeleting() {
  deleting.value = !deleting.value;
}

onMounted(() => {
  checkmark.value = (form.done > 0) ? true : false;
})

</script>

<template>
    <div @mouseenter="FadeIn(todo.id)" @mouseleave="FadeOut(todo.id)" class="grid-cols-3 mt-3 cursor-pointer h-9 customGrid" :id="'id' + todo.id">
        <!-- <input @click="CheckMarkClicked(todo.id)" type="checkbox" class="my-auto ml-2 border-gray-300 rounded shadow-sm text-zinc-900 focus:ring-transparent custom1" :value="checkmark" /> -->
        <Checkbox @click="CheckMarkClicked(todo.id)" type="checkbox" class="z-10 my-auto ml-2 border-gray-300 rounded shadow-sm text-zinc-900 focus:ring-transparent custom1" :value="checkmark" :checked="checkmark"/>
        <div @click="ToggleDescription(todo.id)" class="z-10 my-auto ml-2 custom2"><h2 class="font-semibold">{{todo.todo}}</h2></div>
        <div v-if="!deleting" @click="ToggleUpdateModal()" class="z-0 my-auto mr-2"> <i :id="'gear' + todo.id" class="justify-end px-1 fa-solid fa-pen fa-sm custom3 top-3"></i> </div>
        <div v-if="!deleting" @click="ToggleDeleting()" class="z-0 my-auto mr-2"> <i :id="'delete' + todo.id" class="justify-end px-1 fa-solid fa-trash-can fa-sm custom4 top-3"></i> </div>

        <div v-if="deleting" class="px-2 custom3">
          <Link :href="route('todo.destroy', todo.id)" method="delete">
            <DangerButton>Delete</DangerButton>
          </Link>
        </div>

        <div v-if="deleting" class="custom4">
          <SecondaryButton @click="ToggleDeleting()">Cancel</SecondaryButton>
        </div>
    </div>
    <div :id="'description' + todo.id" class="hidden w-auto h-0 opacity-0 bg-zinc-200">
      <p class="pt-1 ml-2 text-base">{{todo.description}}</p>
    </div>

    <Modal :show="updateModalOpen">
      <div class="grid w-full mt-5 place-items-center h-14">
            <h1 class="text-lg font-bold">Editing Todo</h1>
      </div>

      <div class="w-full h-auto pb-10">
            <form @submit.prevent="form.put(route('todo.update', todo.id), {onSuccess: () => ToggleUpdateModal() })" class="mx-32">
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
                    <SecondaryButton @click="ToggleUpdateModal()">Cancel</SecondaryButton>
                </div>
            </form>
        </div>
    </Modal>
</template>

<style>

.customGrid {
  display: grid;
  grid-template-columns: auto 1fr auto auto;
}

.custom1 {
  grid-column: 1;
}

.custom2 {
  grid-column: 2;
}

.custom3 {
  grid-column: 3;
}

.custom4 {
  grid-column: 4;
}

</style>