import { createRouter, createWebHistory } from "vue-router";

const routes = [
  {
    path: "/",
    redirect: "/home",
  },
  {
    path: "/home",
    name: "home",
    component: () => import("../views/Home.vue"),
    meta: { guest: true },
  },
  {
   path: "/sign-in",
   name: "sign-in",
   component: () => import("../views/SignIn.vue"),
   meta: { guest: true },
  },
  {
      path: "/sign-up",
      name: "sign-up",
      component: () => import("../views/SignUp.vue"),
      meta: { guest: true },
  },
  {
    path: "/storefront",
    name: "storefront",
    component: () => import("../views/Storefront.vue"),
  },
  {
    path: "/request",
    name: "request",
    component: () => import("../views/Request.vue"),
  },
  {
    path: "/order/:id",
    name: "order",
    component: () => import("../views/Order.vue"),
  }
];

const router = createRouter({
  history: createWebHistory(import.meta.env.APP_URL),
  routes,
});

export default router;
