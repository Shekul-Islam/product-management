
  <script setup>
  import { ref } from 'vue';

  const name = ref('');

  const createCategory = async () => {
    const response = await fetch('/api/categories', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ name: name.value })
    });
    const data = await response.json();
    console.log(data);
  };
  </script>

<template>
    <form @submit.prevent="createCategory">
        <input
    v-model="name"
    type="text"
    placeholder="Category Name"
    required
    class="border rounded p-2 w-full"
/>
<button
    type="submit"
    class="bg-blue-500 text-white px-4 py-2 rounded mt-2"
>
    Create Category
</button>

    </form>
  </template>
