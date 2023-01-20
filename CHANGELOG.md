# Changelog

## [Unreleased]

### Added

- GraphQL support for Fluid fieldtype
- Ability to enabled/disable GraphQL integration
- Full GraphQL support for default modifiers and parameters
- Ability to retrieve options from OptionFieldtypes (select, checkbox, etc...)
- Method on Coilpack facade for adding a Twig Extension

### Fixed

- GraphQL validation issues

### Changed

- GraphQL integration is disabled by default
- GraphQL return type for OptionFieldtypes

## [0.0.2] - 2023-01-06

### Added

- Changelog with automated release process

### Fixed

- Filesystem errors on some Windows environments when running coilpack install command
- GraphQL fieldtype modifier registration bug
- GraphQL support for relationship fieldtype

### Changed

- Use Laravel coding standard
- Improved typehints

## [0.0.1] - 2022-12-29

### Added

- Initial Beta Release

[0.0.2]: https://github.com/ExpressionEngine/Coilpack/compare/0.0.1...0.0.2

[0.0.1]: https://github.com/ExpressionEngine/Coilpack/releases/tag/0.0.1
