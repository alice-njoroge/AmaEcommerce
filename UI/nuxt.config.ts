// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
    srcDir: 'src/',
    devtools: {enabled: false},
    css: ['~/assets/main.pcss'],
    postcss: {
        plugins: {
            tailwindcss: {},
            autoprefixer: {},
        },
    },
    modules: [
        '@pinia/nuxt',
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