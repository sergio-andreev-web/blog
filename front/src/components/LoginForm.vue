<template>
  <div class="login-form">
    <h2>Вход</h2>
    <form @submit.prevent="handleSubmit">
      <div class="form-group">
        <label for="email">Имя пользователя:</label>
        <input
            type="text"
            id="email"
            v-model="email"
            placeholder="Введите почту пользователя"
            required
        />
      </div>
      <div class="form-group">
        <label for="password">Пароль:</label>
        <input
            type="password"
            id="password"
            v-model="password"
            placeholder="Введите пароль"
            required
        />
      </div>
      <button type="submit">Войти</button>
    </form>
  </div>
</template>

<script>
import axios from '../axios';
import { mapMutations } from 'vuex';
import Cookies from 'js-cookie';

export default {
  data() {
    return {
      email: '',
      password: ''
    };
  },
  methods: {
    ...mapMutations(['setUserId']),

    async handleSubmit() {
      try {
        const response = await axios.post('login', {
          email: this.email,
          password: this.password
        });
        const { token, user_id } = response.data;
        localStorage.setItem('token', token);
        Cookies.set('user_id', user_id);
        this.setUserId(user_id);
        this.$emit('close');
      } catch (error) {
        console.error('Login failed:', error);
        alert('login error');
      }
    }
  }
};
</script>

<style scoped>
.login-form {
  max-width: 400px;
  margin: 0 auto;
  padding: 1em;
  border: 1px solid #ddd;
  border-radius: 4px;
}

.form-group {
  margin-bottom: 1em;
}

label {
  margin-bottom: .5em;
  color: #333333;
  display: block;
}

input {
  border: 1px solid #CCCCCC;
  padding: .5em;
  font-size: 1em;
  width: 100%;
  box-sizing: border-box;
}

button {
  padding: 0.7em;
  color: #fff;
  background-color: #007BFF;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 1em;
  width: 100%;
}

button:hover {
  background-color: #0056b3;
}
</style>
