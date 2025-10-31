import { defineConfig } from 'vite';

export default defineConfig({
    server: {
        allowedHosts: [
            'traccar.tracktelemetry.local'
        ],
    },
});