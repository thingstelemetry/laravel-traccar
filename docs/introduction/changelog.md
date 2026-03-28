# Changelog

All notable changes to this project will be documented in this file.

## [v1.0.0] - 2026-03-28

### Changed
- **API Method Rename**: Deprecated `find(int $id)` in favor of `get(int $id)` across multiple endpoints (including `Device`, `Event`, `Group`, and `User`). The deprecated `find(int $id)` methods remain for backward compatibility with no immediate removal scheduled, but users are encouraged to upgrade to `get(int $id)`.

### Added
- **Initial Stable Release** - Full API client support for Traccar GPS Tracking Platform.
- **Implemented Endpoints**:
  - `Attribute`, `Audit`, `Calendar`, `Command`, `Device`, `Driver`, `Event`, `Geofence`, `Group`, `Health`, `Maintenance`, `Notification`, `Oidc`, `Order`, `Password`, `Permission`, `Position`, `Report`, `Server`, `Session`, `Share`, `User`.
