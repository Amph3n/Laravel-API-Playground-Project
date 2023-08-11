<script setup>
import anime from "animejs";
import Checkbox from "./Checkbox.vue"

defineProps(['todo']);

function FadeIn(_id) {
  const id = "#id" + _id;

  anime({
    targets: id,
    translateY: -2,
    boxShadow: 'rgba(179, 179, 179, 0.6) 1px 2px 3px -1px',
  })
}

function FadeOut(_id) {
  const id = "#id" + _id;

  anime({
    targets: id,
    translateY: 0,
    boxShadow: 'rgba(179, 179, 179, 0.0) 1px 0px 3px -1px',
  })
}

</script>

<template>
    <div @mouseenter="FadeIn(todo.id)" @mouseleave="FadeOut(todo.id)" class="flex mt-3 cursor-pointer todo" :id="'id' + todo.id">
        <Checkbox class="my-auto ml-2" :value="todo.done" />
        <div class="ml-2">{{todo.todo}}</div>
    </div>
</template>

<style>

</style>