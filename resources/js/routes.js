import viewUser from './vue/userpage.vue';
import manageUser from './vue/manageUser.vue';

export const routes = [
    {
        name: 'manageUser',
        path: '/manageUser',
        component: manageUser
    },
    {
        name: 'viewuser',
        path: '/manageUser/:id',
        component: viewUser,
        props: true
    },
    //  {
    //      name: 'fullpost',
    //      path: '/post/:id',
    //      props: true
    //  }
];