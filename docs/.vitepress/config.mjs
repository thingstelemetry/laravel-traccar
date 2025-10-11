import {defineConfig} from 'vitepress'

// https://vitepress.dev/reference/site-config
export default defineConfig({
    title: "Laravel Traccar",
    description: "A Laravel package for Traccar payment integration",
    lastUpdated: false,
    sitemap: {
        hostname: 'https://traccar.tracktelemetry.com'
    },
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
                collapsed: true,
                items: [
                    {text: 'Server Data', link: '/reference/dto/server-data'},
                    {text: 'Server Attribute Data', link: '/reference/dto/server-attributes-data'},
                    {text: 'Device Data', link: '/reference/dto/device-data'},
                    {text: 'Device Attribute Data', link: '/reference/dto/device-attributes-data'},
                ]
            },
            {
                text: 'Enums Reference',
                collapsed: true,
                items: [
                    {text: 'Map', link: '/reference/enums/map'},
                    {text: 'Coordinate Format', link: '/reference/enums/coordinate-format'},
                    {text: 'Distance Unit', link: '/reference/enums/distance-unit'},
                    {text: 'Altitude Unit', link: '/reference/enums/altitude-unit'},
                    {text: 'Speed Unit', link: '/reference/enums/speed-unit'},
                    {text: 'Volume Unit', link: '/reference/enums/volume-unit'},
                    {text: 'Device Status', link: '/reference/enums/device-status'},
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
