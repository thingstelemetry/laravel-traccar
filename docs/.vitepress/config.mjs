import {defineConfig} from 'vitepress'

// https://vitepress.dev/reference/site-config
export default defineConfig({
    title: "Laravel Traccar",
    description: "A Laravel package for Traccar integration",
    lastUpdated: false,
    sitemap: {
        hostname: 'https://traccar.thingstelemetry.com'
    },
    head: [
        [
            'script',
            { defer: '', 'data-domain': 'traccar.thingstelemetry.com', src: 'https://stats.thingstelemetry.com/js/script.js' }
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
                    {text: 'Generate Token', link: '/introduction/generate-bearer-token'},
                    {text: 'Getting Started', link: '/introduction/getting-started'},
                ]
            },
            {
                text: 'Server',
                collapsed: true,
                items: [
                    {text: 'Get Information', link: '/server/get-information'},
                    {text: 'Update Information', link: '/server/update-information'},
                    {text: 'Reboot', link: '/server/reboot'},
                    {text: 'Cache', link: '/server/cache'},
                    {text: 'Garbage Collector', link: '/server/gc'},
                    {text: 'Upload File', link: '/server/upload-file'},
                    {text: 'Timezones', link: '/server/timezones'},
                    {text: 'Reverse Geocode', link: '/server/geocode'},
                    {text: 'Statistics', link: '/server/statistics'},
                ]
            },
            {
                text: 'Users',
                collapsed: true,
                items: [
                    {text: 'Get Information', link: '/users/get-information'},
                    {text: 'Get All', link: '/users/get-all'},
                    {text: 'Create User', link: '/users/create'},
                    {text: 'Update User', link: '/users/update'},
                    {text: 'Delete User', link: '/users/delete'},
                ]
            },
            {
                text: 'Events',
                collapsed: true,
                items: [
                    {text: 'Get Information', link: '/events/get-information'},
                ]
            },
{
                text: 'Devices',
                collapsed: true,
                items: [
                    {text: 'Get All Devices', link: '/devices/get-all'},
                    {text: 'Get User Devices', link: '/devices/get-for-user'},
                    {text: 'Create Device', link: '/devices/create'},
                    {text: 'Update Device', link: '/devices/update'},
                    {text: 'Share Device', link: '/devices/share-location'},
                    {text: 'Upload/Update Device Image', link: '/devices/update-image'},
                    {text: 'Update Totals (Distance & Hours)', link: '/devices/accumulators'},
                    {text: 'Delete Device', link: '/devices/delete'},
                ]
            },
            {
                text: 'Positions',
                collapsed: true,
                items: [
                    {text: 'Delete Position', link: '/positions/delete'},
                    {text: 'Delete Positions Range', link: '/positions/delete-by-range'},
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
                    {text: 'Device Share Data', link: '/reference/dto/device-share-data'},
                    {text: 'Event Data', link: '/reference/dto/event-data'},
                    {text: 'User Data', link: '/reference/dto/user-data'},
                    {text: 'User Attributes Data', link: '/reference/dto/user-attributes-data'},
                    {text: 'Server Statistics Data', link: '/reference/dto/server-statistics-data'},
                    {text: 'Position Data', link: '/reference/dto/position-data'},
                    {text: 'Session Token Data', link: '/reference/dtos/session-token-data'},
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
                    {text: 'Device Category', link: '/reference/enums/device-category'},
                    {text: 'Status', link: '/reference/enums/status'},
                ]
            },
        ],

        socialLinks: [
            {icon: 'github', link: 'https://github.com/thingstelemetry/laravel-traccar'}
        ],

        footer: {
            message: 'Released under the MIT License.',
            copyright: 'Copyright © 2025-present Njogu Amos'
        }
    }
})
