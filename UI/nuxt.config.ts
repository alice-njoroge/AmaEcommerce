// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
    srcDir: 'src/',
    devtools: {enabled: false},
    modules: [
        '@pinia/nuxt',
        "@nuxtjs/tailwindcss",
        [
            '@vee-validate/nuxt',
            {
                //enable auto imports
                autoImports: true,
                // Use different names for components
                componentNames: {
                    Form: 'VeeForm',
                    Field: 'VeeField',
                },
            },
        ],
    ],
})