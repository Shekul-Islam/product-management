
  <script setup>
  import { ref, onMounted } from 'vue';
  import axios from 'axios';

  const categories = ref([]);
  const products = ref([]);
  const productName = ref('');
  const productPrice = ref('');
  const selectedCategories = ref([]);
  const productImage = ref(null);

  // Fetch Categories
  const fetchCategories = async () => {
    const { data } = await axios.get('/api/categories');
    categories.value = data;
  };

  // Fetch Products
  const fetchProducts = async () => {
    const { data } = await axios.get('/api/products');
    products.value = data;
  };

  // Handle Image Upload
  const handleImageUpload = (event) => {
    productImage.value = event.target.files[0];
  };

  // Create Product
  const createProduct = async () => {
    const formData = new FormData();
    formData.append('name', productName.value);
    formData.append('price', productPrice.value);
    formData.append('image', productImage.value);
    formData.append('categories', selectedCategories.value);

    await axios.post('/api/products', formData);
    fetchProducts();  // Refresh the product list
    productName.value = '';
    productPrice.value = '';
    selectedCategories.value = [];
    productImage.value = null;
  };

  // Delete Product
  const deleteProduct = async (id) => {
    await axios.delete(`/api/products/${id}`);
    fetchProducts();  // Refresh the product list
  };

  // Fetch categories and products on component mount
  onMounted(() => {
    fetchCategories();
    fetchProducts();
  });
  </script>

<template>
    <div>
      <h1>Product Management</h1>

      <!-- Create Product Form -->
      <form @submit.prevent="createProduct">
        <input
          v-model="productName"
          type="text"
          placeholder="Product Name"
          required
          class="border rounded p-2 w-full mb-2"
        />
        <input
          v-model="productPrice"
          type="number"
          placeholder="Product Price"
          required
          class="border rounded p-2 w-full mb-2"
        />
        <input
          type="file"
          @change="handleImageUpload"
          class="border rounded p-2 w-full mb-2"
        />
        <select
          v-model="selectedCategories"
          multiple
          class="border rounded p-2 w-full mb-2"
        >
          <option v-for="category in categories" :key="category.id" :value="category.id">
            {{ category.name }}
          </option>
        </select>
        <button
          type="submit"
          class="bg-blue-500 text-white px-4 py-2 rounded mt-2"
        >
          Add Product
        </button>
      </form>

      <!-- Product List -->
      <div class="mt-4">
        <div v-for="product in products" :key="product.id" class="border p-4 mb-2">
          <h2>{{ product.name }}</h2>
          <p>Price: ${{ product.price }}</p>
          <div v-if="product.image">
            <img :src="'/storage/' + product.image" alt="Product Image" class="w-24 h-24 object-cover" />
          </div>
          <button @click="deleteProduct(product.id)" class="bg-red-500 text-white px-4 py-2 rounded mt-2">Delete</button>
        </div>
      </div>
    </div>
  </template>
