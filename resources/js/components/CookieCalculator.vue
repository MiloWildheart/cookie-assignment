<!-- resources/js/components/CookieCalculator.vue -->

<template>
    <div>
      <div v-for="(ingredient, index) in ingredients" :key="index">
        <label>{{ ingredient.name }}:</label>
        <div>
          <input type="number" v-model="ingredient.properties.capacity" placeholder="Capacity" />
          <input type="number" v-model="ingredient.properties.durability" placeholder="Durability" />
          <input type="number" v-model="ingredient.properties.flavor" placeholder="Flavor" />
          <input type="number" v-model="ingredient.properties.texture" placeholder="Texture" />
          <input type="number" v-model="ingredient.properties.calories" placeholder="Calories" />
        </div>
      </div>
  
      <button @click="calculateScore">Calculate Score</button>
      <p v-if="result">Best Score: {{ result }}</p>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        ingredients: [
          { name: 'Sprinkles', properties: { capacity: 2, durability: 0, flavor: -2, texture: 0, calories: 3 } },
          { name: 'Butterscotch', properties: { capacity: 0, durability: 5, flavor: -3, texture: 0, calories: 3 } },
          { name: 'Chocolate', properties: { capacity: 0, durability: 0, flavor: 5, texture: -1, calories: 8 } },
          { name: 'Candy', properties: { capacity: 0, durability: -1, flavor: 0, texture: 5, calories: 8 } },
        ],
        result: null,
      };
    },
    methods: {
      calculateScore() {
        const ingredientsData = this.ingredients.map((ingredient) => ({
          name: ingredient.name,
          properties: {
            capacity: parseInt(ingredient.properties.capacity),
            durability: parseInt(ingredient.properties.durability),
            flavor: parseInt(ingredient.properties.flavor),
            texture: parseInt(ingredient.properties.texture),
            calories: parseInt(ingredient.properties.calories),
          },
        }));
  
        axios.post('/calculate-cookie', { ingredients: ingredientsData }).then((response) => {
          this.result = response.data.score;
        });
      },
    },
  };
  </script>
  