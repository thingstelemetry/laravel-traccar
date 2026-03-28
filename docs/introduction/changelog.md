# Changelog

All notable changes to this project will be documented in this file.

## [v1.0.0] - 2026-03-28

### Changed
- **API Method Rename**: Deprecated `find(int $id)` in favor of `get(int $id)` across multiple endpoints (including `Device`, `Event`, `Group`, and `User`). The deprecated `find(int $id)` methods remain for backward compatibility with no immediate removal scheduled, but users are encouraged to upgrade to `get(int $id)`.

### Added
- **Initial Stable Release** - Full API client support for Traccar GPS Tracking Platform.
- **Implemented Endpoints**:
  - `Attribute`, `Audit`, `Calendar`, `Command`, `Device`, `Driver`, `Event`, `Geofence`, `Group`, `Health`, `Maintenance`, `Notification`, `Oidc`, `Order`, `Password`, `Permission`, `Position`, `Report`, `Server`, `Session`, `Share`, `User`.

## [v1.0.0-beta.4] - 2026-03-28

### Breaking Changes
- Renamed `find(int $id)` method to `get(int $id)` in `Device`, `Event`, and `Group` endpoint classes and facades for better API consistency.

### Added
- `UpdateServerInformation` endpoint integration and related features.
- Enum references for `Altitude`, `Distance`, `Speed`, `Volume`, and `CoordinateFormat`.
- `Device` endpoint implementation.

### Changed
- Migrated documentation from Astro/Starlight to VitePress.
- Improved error handling and response processing.

## [v1.0.0-beta.3] - 2026-02-21

### Changed
- Updated Saloon PHP dependencies.
- Refactored internal request handling for better performance.

## [v1.0.0-beta.2] - 2026-02-18

### Fixed
- Issue with DTO hydration for nested attributes.
- Corrected base URL resolution in `TraccarConnector`.

## [v1.0.0-beta.1] - 2026-02-17

### Added
- Initial beta release with core Traccar API support.
- Support for Devices, Groups, Users, and Server information.
- Laravel facades for all major endpoints.

## [v0.7.6-alpha] and earlier

- Iterative alpha releases focused on building out the base library and Saloon integration.
- Implementation of initial DTOs and Enums.
- Basic test coverage for core features.
