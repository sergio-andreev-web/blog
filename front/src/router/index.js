import Vue from 'vue';
import Router from 'vue-router';
import PostList from '../components/PostList.vue';
import PostForm from '../components/PostForm.vue';

Vue.use(Router);

export default new Router({
    mode: 'history',
    routes: [
        {
            path: '/',
            name: 'PostList',
            component: PostList
        },
        {
            path: '/create-post',
            name: 'CreatePost',
            component: PostForm
        },
        {
            path: '/edit-post/:id',
            name: 'EditPost',
            component: PostForm
        }
    ]
});
