<template>
  <div>
    <el-row class="toolbar">
      <el-col :span="6">
        <el-button @click="fetchPosts" type="primary">Refresh Posts</el-button>
      </el-col>
      <el-col :span="6">
        <el-checkbox v-model="showOwnPosts">Show only my posts</el-checkbox>
      </el-col>
      <el-col :span="6">
        <el-button @click="createPost" type="success">Create New Post</el-button>
      </el-col>
      <el-col :span="6">
        <el-button @click="showLoginForm = true" type="warning">Login</el-button>
      </el-col>
    </el-row>

    <!-- Форма логина -->
    <el-dialog :visible.sync="showLoginForm" title="Login" @close="showLoginForm = false">
      <LoginForm @close="showLoginForm = false" />
    </el-dialog>

    <el-card v-for="post in filteredPosts" :key="post.id" class="post-card" shadow="hover">
      <h2>{{ post.title }}</h2>
      <p>{{ post.description }}</p>
      <div>
        <el-tag
            v-for="tag in post.tags"
            :key="tag.id"
        >
          {{ tag.name }}
        </el-tag>
      </div>
      <template v-if="isOwner(post)">
        <el-button @click="editPost(post.id)" type="info">Edit</el-button>
        <el-button @click="deletePost(post.id)" type="danger">Delete</el-button>
      </template>
    </el-card>
  </div>
</template>

<script>
import axios from '../axios';
import LoginForm from './LoginForm.vue';
import { mapState } from 'vuex';

export default {
  components: {
    LoginForm
  },
  data() {
    return {
      posts: [],
      showOwnPosts: false,
      showLoginForm: false
    };
  },
  computed: {
    ...mapState(['userId']),
    filteredPosts() {
      return this.posts.filter(post => !this.showOwnPosts || post.user_id === this.userId);
    }
  },
  methods: {
    async fetchPosts() {
      try {
        const response = await axios.get('posts');
        this.posts = response.data;
      } catch (error) {
        console.error(error);
      }
    },
    async deletePost(postId) {
      try {
        await axios.delete(`posts/${postId}`);
        this.fetchPosts();
      } catch (error) {
        console.error(error);
      }
    },
    editPost(postId) {
      this.$router.push(`/edit-post/${postId}`);
    },
    createPost() {
      this.$router.push('/create-post');
    },
    isOwner(post) {
      return post.user_id === this.userId;
    }
  },
  async mounted() {
    this.fetchPosts();
  }
};
</script>

<style>
.post-card {
  margin-bottom: 20px;
}
.toolbar {
  margin-bottom: 20px;
}
</style>
