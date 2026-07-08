import { defineStore } from "pinia";


export const MenuPages = {
    GLOBAL: "Global",
    COMMISSION: "Commission",
    TOS: "Terms of Service",
    IMAGE: "Image"
};

export const useStorefrontStore = defineStore('storefront', {
    state: () => ({
        page: MenuPages.GLOBAL
    }),
    getters: {
        getPage: (state) => state.page,
    },
    actions: {
        setPage(page) {
            this.page = page
        },
    }
}
)