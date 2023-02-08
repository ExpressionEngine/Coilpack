# Changelog

## [Unreleased]

### Added

- Option for basic token authentication in GraphQL
- New artisan command for generating tokens `coilpack:graphql --generate-token`
- The ability for third parties to define GraphQL queries in the coilpack schema
- Extra options for configuring Coilpack's GraphQL behavior
- Support for chaining multiple modifiers
- Typed parameter definitions for fieldtypes to support GraphQL

### Changed

- GraphQL schema configuration. Coilpack now creates a separate schema named 'coilpack'
- Modifier registration moved to new function, makes use of new Typed parameters
- Add-ons registering tags with Coilpack should now use a key without the Add-on prefix

## [0.0.3] - 2023-01-25

### Added

- GraphQL support for Fluid fieldtype
- Ability to enabled/disable GraphQL integration
- Full GraphQL support for default modifiers and parameters
- Ability to retrieve options from OptionFieldtypes (select, checkbox, etc...)
- Method on Coilpack facade for adding a Twig Extension
- Single category query to GraphQL schema

### Fixed

- GraphQL validation issues
- Remove conditionally hidden fields from Channel Entry data

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

[Unreleased]: https://github.com/ExpressionEngine/Coilpack/compare/0.0.3...HEAD

[0.0.3]: https://github.com/ExpressionEngine/Coilpack/compare/0.0.2...0.0.3

[0.0.2]: https://github.com/ExpressionEngine/Coilpack/compare/0.0.1...0.0.2

[0.0.1]: https://github.com/ExpressionEngine/Coilpack/releases/tag/0.0.1
