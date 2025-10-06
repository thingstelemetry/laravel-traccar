// @ts-check
import { defineConfig } from 'astro/config';
import starlight from '@astrojs/starlight';

import tailwindcss from '@tailwindcss/vite';

// https://astro.build/config
export default defineConfig({
  integrations: [
      starlight({
          title: 'Traccar API Docs',
          social: [{ icon: 'github', label: 'GitHub', href: 'https://github.com/tracktelemetry/traccar-api' }],
          sidebar: [
              {
                  label: 'Guides',
                  items: [
                      { label: 'Example Guide', slug: 'guides/getting-started' },
                  ],
              },
              {
                  label: 'Server',
                  autogenerate: { directory: 'server' },
              },
          ],
          customCss: [
              './src/styles/global.css',
          ],
      }),
	],

  vite: {
    plugins: [tailwindcss()],
  },
});