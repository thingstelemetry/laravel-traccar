# Changelog

All notable changes to this project will be documented in this file.

## [v1.0.0] - 2026-03-28

### Changed
- **API Method Rename**: Deprecated `find(int $id)` in favor of `get(int $id)` across multiple endpoints (including `Device`, `Event`, `Group`, and `User`). The deprecated `find(int $id)` methods remain for backward compatibility with no immediate removal scheduled, but users are encouraged to upgrade to `get(int $id)`.

### Added
- **Initial Stable Release** - Full API client support for Traccar GPS Tracking Platform.
- **Implemented Endpoints**:
  - `Attribute`, `Audit`, `Calendar`, `Command`, `Device`, `Driver`, `Event`, `Geofence`, `Group`, `Health`, `Maintenance`, `Notification`, `Oidc`, `Order`, `Password`, `Permission`, `Position`, `Report`, `Server`, `Session`, `Share`, `User`.

## [v1.0.0-beta.x] - Beta Releases

- Initial beta releases (beta.1 to beta.4) focused on core API implementation.
- Implemented core endpoints: `Device`, `Event`, `Group`, `User`, and `Server`.
- Added Laravel facades for streamlined API access.
- Integrated Saloon PHP for HTTP client foundation.
- Established DTO and Enum patterns for type safety.
- Migrated documentation to VitePress.

## [v0.7.6-alpha] and earlier

- Iterative alpha releases focused on building out the base library and Saloon integration.
- Implementation of initial DTOs and Enums.
- Basic test coverage for core features.
