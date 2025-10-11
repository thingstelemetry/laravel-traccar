import {defineConfig} from 'vitepress'

// https://vitepress.dev/reference/site-config
export default defineConfig({
    title: "Laravel Traccar",
    description: "A Laravel package for Traccar payment integration",
    lastUpdated: false,
    head: [
        [
            'script',
            { defer: '', 'data-domain': 'traccar.tracktelemetry.com', src: 'https://stats.tracktelemetry.com/js/script.js' }
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
                items: [
                    {text: 'About Traccar', link: '/introduction/about-traccar'},
                    {text: 'Getting Started', link: '/introduction/getting-started'},
                ]
            },
            {
                text: 'Server',
                items: [
                    {text: 'Get Information', link: '/server/get-information'},
                    {text: 'Update Information', link: '/server/update-information'},
                ]
            },
            {
                text: 'DTO Reference',
                items: [
                    {text: 'ServerData', link: '/reference/dto/server-data'},
                ]
            },
            {
                text: 'Enums Reference',
                items: [
                    {text: 'Map', link: '/reference/enums/map'},
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
