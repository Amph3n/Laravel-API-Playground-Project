<script setup>
import { useForm } from "@inertiajs/vue3";
import anime from "animejs";
import { ref } from "vue";

const props = defineProps(['todo']);

const form = useForm({
  
});

let open = ref(false);

function FadeIn(_id) {
  if (open.value) {
    return;
  }

  const id = "#id" + _id;

  anime({
    targets: id,
    translateY: -2,
    boxShadow: 'rgba(179, 179, 179, 0.6) 0px 3px 2px -1px',
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

</script>

<template>
    <div @mouseenter="FadeIn(todo.id)" @mouseleave="FadeOut(todo.id)" class="grid-cols-3 mt-3 cursor-pointer h-7 customGrid" :id="'id' + todo.id">
        <input type="checkbox" class="my-auto ml-2 border-gray-300 rounded shadow-sm text-zinc-900 focus:ring-transparent custom1" :value="true" :checked="false" />
        <div @click="ToggleDescription(todo.id)" class="my-auto ml-2 custom2"><h2 class="font-semibold">{{todo.todo}}</h2></div>
        <div @mouseenter="SpinGear(todo.id)" class="my-auto mr-2"> <i :id="'gear' + todo.id" class="justify-end fa-solid fa-gear fa-sm custom3 top-3"></i> </div>
    </div>
    <div :id="'description' + todo.id" class="hidden w-auto h-0 opacity-0 bg-zinc-200">
      <p class="pt-1 ml-2 text-base">{{todo.description}}</p>
    </div>
</template>

<style>

.customGrid {
  display: grid;
  grid-template-columns: auto 1fr auto;
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

</style>