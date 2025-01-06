  <script setup>
  import { ref } from 'vue';

  const products = ref([]);

  const fetchProducts = async () => {
    const response = await fetch('/api/products');
    products.value = await response.json();
  };

  const deleteProduct = async (id) => {
    const response = await fetch(`/api/products/${id}`, {
      method: 'DELETE',
    });
    const data = await response.json();
    console.log(data);
    fetchProducts(); // Refresh the list after deletion
  };

  fetchProducts();
  </script>

<template>
    <div v-for="product in products" :key="product.id" class="product-card">
      <h3>{{ product.name }}</h3>
      <p>{{ product.price }}</p>
      <p>{{ product.categories.map(c => c.name).join(', ') }}</p>
      <button @click="deleteProduct(product.id)">Delete</button>
    </div>
  </template>
