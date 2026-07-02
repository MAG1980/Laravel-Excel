export const dashboardRoutes = [
    {
        path: 'main',
        name: 'user.dashboard.main',
        component: () => import('@spa/pages/dashboard/Main.vue'),
        meta: { title: 'Main' },
    },
    {
        path: 'create-post',
        name: 'user.dashboard.create-post',
        component: () => import('@spa/pages/dashboard/CreatePost.vue'),
        meta: { title: 'Create Post' },
    },
    {
        path: 'upload-image',
        name: 'user.dashboard.upload-image',
        component: () => import('@spa/pages/dashboard/UploadImage.vue'),
        meta: { title: 'Upload Image' },
    },
];
