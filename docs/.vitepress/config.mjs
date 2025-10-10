import {defineConfig} from 'vitepress'

// https://vitepress.dev/reference/site-config
export default defineConfig({
    title: "Laravel Traccar",
    description: "A Laravel package for Traccar payment integration",
    lastUpdated: false,
    head: [
        [
            'script',
            { defer: '', 'data-domain': 'traccar.tracktelemetry.com', src: 'https://st.artisanelevated.com/js/script.js' }
        ],
    ],
    themeConfig: {
        search: {
            provider: 'local'
        },

        nav: [
            {text: 'Home', link: '/'},
            {text: 'Guide', link: '/introduction/getting-started'},
        ],

        sidebar: [
            {
                text: 'Introduction',
                collapsed: false,
                items: [
                    {text: 'Getting Started', link: '/introduction/getting-started'},
                ]
            },
            {
                text: 'Server',
                collapsed: true,
                items: [
                    {text: 'Get Information', link: '/server/get-information'},
                    {text: 'Update Information', link: '/server/update-information'},
                ]
            },
        ],

        socialLinks: [
            {icon: 'github', link: 'https://github.com/tracktelemetry/laravel-traccar'}
        ],

        footer: {
            message: 'Released under the MIT License.',
            copyright: 'Copyright © 2025-present Njogu Amos'
        }
    }
})
