<template>
    <div>
        <h1>Category Management</h1>
        <form @submit.prevent="addCategory">
            <input v-model="categoryName" placeholder="Category Name" />
            <button type="submit">Add Category</button>
        </form>
        <ul>
            <li v-for="category in categories" :key="category.id">
                {{ category.name }}
                <button @click="deleteCategory(category.id)">Delete</button>
            </li>
        </ul>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const categories = ref([]);
const categoryName = ref('');

const fetchCategories = async () => {
    const { data } = await axios.get('/api/categories');
    categories.value = data;
};

const addCategory = async () => {
    await axios.post('/api/categories', { name: categoryName.value });
    categoryName.value = '';
    fetchCategories();
};

const deleteCategory = async (id) => {
    await axios.delete(`/api/categories/${id}`);
    fetchCategories();
};

onMounted(fetchCategories);
</script>
