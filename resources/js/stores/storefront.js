import { defineStore } from "pinia";


export const MenuPages = {
    GLOBAL: "Global",
    COMMISSION: "Commission",
    TOS: "Terms of Service",
    IMAGE: "Image"
};

export const useStorefrontStore = defineStore('storefront', {
    state: () => ({
        page: MenuPages.GLOBAL,
        sidebarActive: false,
        totalComponents: 0,
        data: null,}),
    getters: {
        getPage: (state) => state.page,
        getSidebarActive: (state) => state.sidebarActive,
        getData: (state) => state.data,
        getTotalComponents: (state) => state.totalComponents,
    },
    actions: {
        setPage(page) {
            this.page = page
        },
        setSidebarActive(active, page = null, data = null) {
            this.sidebarActive = active
            if (page) this.page = page
            if (data) this.data = data
        },
        clearData() {
            this.data = null
        },
        setTotalComponents(total) {
            this.totalComponents = total
        }
    }
}
)
