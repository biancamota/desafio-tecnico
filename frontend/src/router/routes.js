
const routes = [
  {
    path: '/',
    component: () => import('layouts/LoginLayout.vue'),
    children: [
      { path: '', name: 'loginDefault', component: () => import('pages/Login.vue') },
      { path: 'login', name: 'login', component: () => import('pages/Login.vue') },
      { path: 'register', name: 'register', component: () => import('pages/Register.vue') }
    ]
  },
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: 'pdv', name: 'home', component: () => import('pages/IndexPage.vue') },
      { path: 'products', name: 'productsList', component: () => import('pages/product/List.vue') },
      { path: 'products/form/:id?', name: 'productsForm', component: () => import('pages/product/Form.vue') },
      { path: 'categories', name: 'categoriesList', component: () => import('pages/category/List.vue') },
      { path: 'categories/form/:id?', name: 'categoriesForm', component: () => import('pages/category/Form.vue') },
      { path: 'sales', name: 'salesList', component: () => import('pages/sale/List.vue') },
      { path: 'users', name: 'usersList', component: () => import('pages/user/List.vue') },
      { path: 'users/form/:id?', name: 'usersForm', component: () => import('pages/user/Form.vue') },
    ],
    // meta: {
    //   requiresAuth: true
    // }
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue')
  }
]

export default routes
