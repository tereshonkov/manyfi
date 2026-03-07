// https://nuxt.com/docs/api/configuration/nuxt-config
export default defineNuxtConfig({
  devtools: { enabled: true },
  modules: ['@nuxt/ui'],
  runtimeConfig: {
    apiUrl: process.env.NUXT_API_URL,
    public: {
      apiBase: process.env.NUXT_PUBLIC_API_BASE || 'http://localhost:8001/api'
    }
  },
  compatibilityDate: '2024-04-03'
})