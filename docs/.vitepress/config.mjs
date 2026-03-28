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
        ['link', { rel: 'icon', type: 'image/svg+xml', href: '/favicon.svg' }],
        ['meta', { property: 'og:image', content: '/thingstelemetry-laravel-traccar.webp' }],
        ['meta', { property: 'og:image:type', content: 'image/webp' }],
        ['meta', { property: 'og:image:width', content: '1200' }],
        ['meta', { property: 'og:image:height', content: '630' }],
        ['meta', { name: 'twitter:card', content: 'summary_large_image' }],
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
            {text: 'Changelog', link: '/introduction/changelog'},
        ],

        sidebar: [
            {
                text: 'Introduction',
                items: [
                    {text: 'About Traccar', link: '/introduction/about-traccar'},
                    {text: 'Generate Token', link: '/introduction/generate-bearer-token'},
                    {text: 'Getting Started', link: '/introduction/getting-started'},
                    {text: 'Making Requests', link: '/introduction/making-request'},
                    {text: 'Handling Responses', link: '/introduction/handling-response'},
                    {text: 'Error Handling', link: '/introduction/error-handling'},
                    {text: 'Changelog', link: '/introduction/changelog'},
                ]
            },
            {
                text: 'Traccar API',
                collapsed: false,
                items: [
                    {
                        text: 'Server',
                        collapsed: true,
                        items: [
                            {text: 'Get', link: '/server/get'},
                            {text: 'Update', link: '/server/update'},
                            {text: 'Reboot', link: '/server/reboot'},
                            {text: 'Cache', link: '/server/cache'},
                            {text: 'Run Garbage Collector', link: '/server/run-garbage-collector'},
                            {text: 'Upload File', link: '/server/upload-file'},
                            {text: 'Timezones', link: '/server/timezones'},
                            {text: 'Reverse Geocode', link: '/server/geocode'},
                            {text: 'Statistics', link: '/server/statistics'},
                        ]
                    },
                    {
                        text: 'Session',
                        collapsed: true,
                        items: [
                            {text: 'Current', link: '/session/current'},
                            {text: 'For User', link: '/session/for-user'},
                            {text: 'Create Session (Login)', link: '/session/create'},
                            {text: 'Delete Session (Logout)', link: '/session/delete'},
                            {text: 'Generate Token', link: '/session/generate-token'},
                            {text: 'Revoke Token', link: '/session/revoke-token'},
                            {text: 'OpenID Auth', link: '/session/openid-auth'},
                            {text: 'OpenID Callback', link: '/session/openid-callback'},
                        ]
                    },
                    {
                        text: 'Password',
                        collapsed: true,
                        items: [
                            {text: 'Reset Password', link: '/password/reset'},
                            {text: 'Update Password', link: '/password/update'},
                        ]
                    },
                    {
                        text: 'Devices',
                        collapsed: true,
                        items: [
                            {text: 'Get', link: '/devices/get'},
                            {text: 'All', link: '/devices/all'},
                            {text: 'Create Device', link: '/devices/create'},
                            {text: 'Update Device', link: '/devices/update'},
                            {text: 'Upload/Update Device Image', link: '/devices/update-image'},
                            {text: 'Update Totals (Distance & Hours)', link: '/devices/accumulators'},
                            {text: 'Delete Device', link: '/devices/delete'},
                        ]
                    },
                    {
                        text: 'Groups',
                        collapsed: true,
                        items: [
                            {text: 'Get', link: '/groups/get'},
                            {text: 'All', link: '/groups/all'},
                            {text: 'Create Group', link: '/groups/create'},
                            {text: 'Update Group', link: '/groups/update'},
                            {text: 'Delete Group', link: '/groups/delete'},
                        ]
                    },
                    {
                        text: 'Share',
                        collapsed: true,
                        items: [
                            {text: 'Share Device', link: '/share/device'},
                            {text: 'Share Group', link: '/share/group'},
                        ]
                    },
                    {
                        text: 'Users',
                        collapsed: true,
                        items: [
                            {text: 'Get', link: '/users/get'},
                            {text: 'All', link: '/users/all'},
                            {text: 'Create User', link: '/users/create'},
                            {text: 'Update User', link: '/users/update'},
                            {text: 'Delete User', link: '/users/delete'},
                            {text: 'Generate TOTP Secret', link: '/users/generate-totp'},
                        ]
                    },
                    {
                        text: 'Permissions',
                        collapsed: true,
                        items: [
                            {text: 'Link Permission', link: '/permissions/link'},
                            {text: 'Unlink Permission', link: '/permissions/unlink'},
                            {text: 'Link Permissions (Bulk)', link: '/permissions/link-bulk'},
                            {text: 'Unlink Permissions (Bulk)', link: '/permissions/unlink-bulk'},
                        ]
                    },
                    {
                        text: 'Calendars',
                        collapsed: true,
                        items: [
                            {text: 'All', link: '/calendars/all'},
                            {text: 'Create Calendar', link: '/calendars/create'},
                            {text: 'Update Calendar', link: '/calendars/update'},
                            {text: 'Delete Calendar', link: '/calendars/delete'},
                        ]
                    },
                    {
                        text: 'Attributes',
                        collapsed: true,
                        items: [
                            {text: 'All', link: '/attributes/all'},
                            {text: 'Create Attribute', link: '/attributes/create'},
                            {text: 'Update Attribute', link: '/attributes/update'},
                            {text: 'Test Attribute', link: '/attributes/test'},
                            {text: 'Delete Attribute', link: '/attributes/delete'},
                        ]
                    },
                    {
                        text: 'Drivers',
                        collapsed: true,
                        items: [
                            {text: 'All', link: '/drivers/all'},
                            {text: 'Create Driver', link: '/drivers/create'},
                            {text: 'Update Driver', link: '/drivers/update'},
                            {text: 'Delete Driver', link: '/drivers/delete'},
                        ]
                    },
                    {
                        text: 'Maintenance',
                        collapsed: true,
                        items: [
                            {text: 'All', link: '/maintenance/all'},
                            {text: 'Create Maintenance', link: '/maintenance/create'},
                            {text: 'Update Maintenance', link: '/maintenance/update'},
                            {text: 'Delete Maintenance', link: '/maintenance/delete'},
                        ]
                    },
                    {
                        text: 'Orders',
                        collapsed: true,
                        items: [
                            {text: 'All', link: '/orders/all'},
                            {text: 'Create Order', link: '/orders/create'},
                            {text: 'Update Order', link: '/orders/update'},
                            {text: 'Delete Order', link: '/orders/delete'},
                        ]
                    },
                    {
                        text: 'Geofences',
                        collapsed: true,
                        items: [
                            {text: 'All', link: '/geofences/all'},
                            {text: 'Create Geofence', link: '/geofences/create'},
                            {text: 'Update Geofence', link: '/geofences/update'},
                            {text: 'Delete Geofence', link: '/geofences/delete'},
                        ]
                    },
                    {
                        text: 'Events',
                        collapsed: true,
                        items: [
                            {text: 'Get', link: '/events/get'},
                        ]
                    },
                    {
                        text: 'Audit',
                        collapsed: true,
                        items: [
                            {text: 'Get', link: '/audit/get'},
                        ]
                    },
                    {
                        text: 'OIDC',
                        collapsed: true,
                        items: [
                            {text: 'Authorize', link: '/oidc/authorize'},
                            {text: 'Get Token', link: '/oidc/token'},
                            {text: 'Get User Info', link: '/oidc/userinfo'},
                            {text: 'Get JWKS', link: '/oidc/jwks'},
                        ]
                    },
                    {
                        text: 'Commands',
                        collapsed: true,
                        items: [
                            {text: 'All', link: '/commands/all'},
                            {text: 'Create Command', link: '/commands/create'},
                            {text: 'Update Command', link: '/commands/update'},
                            {text: 'Delete Command', link: '/commands/delete'},
                            {text: 'Get Sendable For Device', link: '/commands/get-sendable-for-device'},
                            {text: 'Send Command', link: '/commands/send'},
                            {text: 'Get Command Types', link: '/commands/types'},
                        ]
                    },
                    {
                        text: 'Notifications',
                        collapsed: true,
                        items: [
                            {text: 'All', link: '/notifications/all'},
                            {text: 'Create Notification', link: '/notifications/create'},
                            {text: 'Update Notification', link: '/notifications/update'},
                            {text: 'Delete Notification', link: '/notifications/delete'},
                            {text: 'Get Notification Types', link: '/notifications/types'},
                            {text: 'Send Test Notification', link: '/notifications/send-test'},
                            {text: 'Send Notification', link: '/notifications/send'},
                            {text: 'Get Notificators', link: '/notifications/notificators'},
                        ]
                    },
                    {
                        text: 'Positions',
                        collapsed: true,
                        items: [
                            {text: 'All', link: '/positions/all'},
                            {text: 'Export KML', link: '/positions/export-kml'},
                            {text: 'Export CSV', link: '/positions/export-csv'},
                            {text: 'Export GPX', link: '/positions/export-gpx'},
                            {text: 'Delete Position', link: '/positions/delete'},
                            {text: 'Delete Positions Range', link: '/positions/delete-by-range'},
                        ]
                    },
                    {
                        text: 'Reports',
                        collapsed: true,
                        items: [
                            {text: 'Combined Report', link: '/reports/combined'},
                            {text: 'Route Report', link: '/reports/route'},
                            {text: 'Events Report', link: '/reports/events'},
                            {text: 'Geofences Report', link: '/reports/geofences'},
                            {text: 'Summary Report', link: '/reports/summary'},
                            {text: 'Trips Report', link: '/reports/trips'},
                            {text: 'Stops Report', link: '/reports/stops'},
                        ]
                    },
                    {
                        text: 'Health',
                        collapsed: true,
                        items: [
                            {text: 'Check Health', link: '/health/check'},
                        ]
                    },
                ]
            },
            {
                text: 'Batteries',
                collapsed: false,
                items: [
                    {
                        text: 'Commands',
                        collapsed: true,
                        items: [
                            {text: 'RunGarbageCollectorCommand', link: '/batteries/commands/run-garbage-collector'},
                        ]
                    },
                ]
            },
            {
                text: 'References',
                collapsed: false,
                items: [
                    {
                        text: 'DTO',
                        collapsed: true,
                        items: [
                            {text: 'ServerData', link: '/reference/dto/server-data'},
                            {text: 'ServerAttributesData', link: '/reference/dto/server-attributes-data'},
                            {text: 'DeviceData', link: '/reference/dto/device-data'},
                            {text: 'DeviceAttributesData', link: '/reference/dto/device-attributes-data'},
                            {text: 'DeviceShareData', link: '/reference/dto/device-share-data'},
                            {text: 'EventData', link: '/reference/dto/event-data'},
                            {text: 'GroupData', link: '/reference/dto/group-data'},
                            {text: 'PermissionData', link: '/reference/dto/permission-data'},
                            {text: 'UserData', link: '/reference/dto/user-data'},
                            {text: 'UserAttributesData', link: '/reference/dto/user-attributes-data'},
                            {text: 'ServerStatisticsData', link: '/reference/dto/server-statistics-data'},
                            {text: 'PositionData', link: '/reference/dto/position-data'},
                            {text: 'SessionTokenData', link: '/reference/dto/session-token-data'},
                            {text: 'GroupShareData', link: '/reference/dto/group-share-data'},
                            {text: 'CombinedReportData', link: '/reference/dto/combined-report-data'},
                            {text: 'AuditData', link: '/reference/dto/audit-data'},
                            {text: 'OidcTokenData', link: '/reference/dto/oidc-token-data'},
                            {text: 'OidcUserInfoData', link: '/reference/dto/oidc-user-info-data'},
                        ]
                    },
                    {
                        text: 'Enums',
                        collapsed: true,
                        items: [
                            {text: 'Map', link: '/reference/enums/map'},
                            {text: 'CoordinateFormat', link: '/reference/enums/coordinate-format'},
                            {text: 'DistanceUnit', link: '/reference/enums/distance-unit'},
                            {text: 'AltitudeUnit', link: '/reference/enums/altitude-unit'},
                            {text: 'SpeedUnit', link: '/reference/enums/speed-unit'},
                            {text: 'VolumeUnit', link: '/reference/enums/volume-unit'},
                            {text: 'DeviceStatus', link: '/reference/enums/device-status'},
                            {text: 'DeviceCategory', link: '/reference/enums/device-category'},
                            {text: 'Status', link: '/reference/enums/status'},
                        ]
                    },
                ]
            },

        ],

        socialLinks: [
            {icon: 'github', link: 'https://github.com/thingstelemetry/laravel-traccar'}
        ],

        footer: {
            message: 'Released under the MIT License.',
            copyright: 'Copyright © 2025-present Things Telemetry'
        }
    }
})
