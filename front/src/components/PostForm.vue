<template>
  <div>
    <h1>{{ isEditing ? 'Edit' : 'Create' }} Post</h1>
    <el-form :model="post" @submit.native.prevent="savePost">
      <el-form-item label="Title:">
        <el-input v-model="post.title" placeholder="Enter title" />
      </el-form-item>

      <el-form-item label="Description:">
        <el-input
            v-model="post.description"
            type="textarea"
            rows="4"
            placeholder="Enter description"
        />
      </el-form-item>

      <el-form-item label="Tags:">
        <div v-for="(tag, index) in post.tags" :key="tag.id" class="tag-container">
          <el-input
              v-model="post.tags[index].name"
              placeholder="Tag name"
              style="margin-bottom: 10px;"
          />
          <el-button type="danger" @click="removeTag(index)" size="mini">Remove Tag</el-button>
        </div>
        <el-button type="primary" @click="addTag">Add Tag</el-button>
      </el-form-item>

      <el-form-item>
        <el-button type="primary" @click="savePost">{{ isEditing ? 'Save Changes' : 'Create Post' }}</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import axios from '../axios';

export default {
  data() {
    return {
      post: {
        title: '',
        description: '',
        tags: []
      },
      isEditing: false
    };
  },
  methods: {
    async savePost() {
      try {
        const tags = this.post.tags.map(tag => tag.name);

        if (this.isEditing) {
          await axios.put(`posts/${this.$route.params.id}`, {
            ...this.post,
            tags
          });
        } else {
          await axios.post('posts', {
            ...this.post,
            tags
          });
        }
        this.$router.push('/');
      } catch (error) {
        console.error(error);
      }
    },
    addTag() {
      this.post.tags.push({ name: '' });
    },
    removeTag(index) {
      this.post.tags.splice(index, 1);
    }
  },
  async mounted() {
    if (this.$route.params.id) {
      this.isEditing = true;
      try {
        const response = await axios.get(`posts/${this.$route.params.id}`);
        this.post = response.data;
      } catch (error) {
        console.error(error);
      }
    }
  }
};
</script>

<style scoped>
.tag-container {
  margin-bottom: 10px;
}
</style>
