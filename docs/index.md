---
# https://vitepress.dev/reference/default-theme-home-page
layout: home

hero:
  name: "Laravel Traccar"
  text: "A Laravel package for Traccar integration"
  tagline: Seamless manage a traccar instance from a Laravel application
  actions:
    - theme: brand
      text: Get Started
      link: /introduction/getting-started
    - theme: alt
      text: Source Code
      link: https://github.com/tracktelemetry/laravel-traccar

features:
  - icon: 🔄
    title: Real-Time Sync
    details: Effortlessly fetch and synchronize devices, positions, and events with Traccar in real time.

  - icon: 🔐
    title: Secure Authentication
    details: Handles Traccar API authentication with tokens or credentials, keeping your integration safe and simple.

  - icon: ⚙️
    title: Configurable Endpoints
    details: Easily customize base URLs, API keys, and connection options via environment variables.

  - icon: 🧩
    title: Extendable Architecture
    details: Designed with Laravel service container bindings, allowing you to override or extend functionality as needed.

  - icon: 🕵🏾‍♂️
    title: Detailed Logging
    details: Built-in logging helps you trace requests, responses, and errors for easy debugging.

  - icon: 🧱
    title: Fluent API Design
    details: Interact with Traccar resources using expressive methods aligned with Laravel’s syntax.

  - icon: 🧰
    title: Helper Commands
    details: Artisan commands for testing connections, listing devices, and syncing data out of the box.

  - icon: 📦
    title: Ready for Production
    details: Built with maintainability and scalability in mind, ideal for enterprise and fleet solutions.
---