
  <script setup>
  import { ref } from 'vue';

  const name = ref('');
  const price = ref('');
  const image = ref(null);
  const categories = ref([]);
  const categoriesList = ref([]);

  const fetchCategories = async () => {
    const response = await fetch('/api/categories');
    categoriesList.value = await response.json();
  };

  const handleImageUpload = (event) => {
    image.value = event.target.files[0];
  };

  const createProduct = async () => {
    const formData = new FormData();
    formData.append('name', name.value);
    formData.append('price', price.value);
    formData.append('image', image.value);
    formData.append('categories', categories.value);

    const response = await fetch('/api/products', {
      method: 'POST',
      body: formData
    });
    const data = await response.json();
    console.log(data);
  };

  fetchCategories();
  </script>

<template>
    <form @submit.prevent="createProduct">
      <input v-model="name" type="text" placeholder="Product Name" required />
      <input v-model="price" type="number" placeholder="Price" required />
      <input type="file" @change="handleImageUpload" />
      <select v-model="categories" multiple>
        <option v-for="category in categoriesList" :value="category.id">{{ category.name }}</option>
      </select>
      <button type="submit">Create Product</button>
    </form>
  </template>
