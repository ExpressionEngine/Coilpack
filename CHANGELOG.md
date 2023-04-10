# Changelog

## [Unreleased]

### Added

- Default values of Tag parameters are automatically passed as argument values when appropriate
- New AddonTag class to easily extend a native Tag and decorate with GraphQL attributes
- An implementation of 'exp:comment:entries' tag using new AddonTag class
- Support for Laravel 10
- Better handling of ExpressionEngine filter arguments
- The ability to use orderby and sort parameters on the channel entries tag
- Support searching by custom field values on channel entries tag
- Pagination support for the `exp_channel_entries` and `exp_channel_categories` GraphQL queries
- Full tag replacement for channel categories including GraphQL query for `exp_channel_categories`
- The ability to parse GraphQL types and queries from an Add-on's setup file
- A tag replacement for Structure Nav to better support new template languages and GraphQL
- A method for embedding native ExpressionEngine templates within Twig and Blade
- Field content implements countable for better support with Twig's length filter
- Page variables to Channel Entries Tag results
- Global Variables for logged_in and logged_out

### Fixed

- Parsing the 'site' parameter when isolating the template library
- Error when applying the File Fieldtype on empty data
- Missing FieldContent attributes when a ChannelEntry does not contain data for a requested field
- ChannelEntry model to remove future and expired results by default
- Issue where GraphQL evaluates a fieldtype as null but then continues to apply modifier
- Error on Option Fieldtypes when querying empty `options` through GraphQL
- Bug accessing a File field's attributes through a Grid field
- Syntax error in Relationship fieldtype causing issue within Grid
- Gracefully handle when a session is not set on the Laravel request in FormTag
- Issue with registering a fluid field that has an empty string in it's list of fields
- Getting custom field data on members and categories through GraphQL
- Bug with Fieldtypes providing certain GraphQL types
- Bug checking if a field stored data on the legacy data table
- Email Contact Form attribute access in Twig templates
- Retrieving the current request's page value for paginating ModelTag results

### Changed

- Tag argument mutation now happens on 'get' instead of 'set'
- Standardize GraphQL type handling through Coilpack's GraphQL Facade
- Removed the `channel_entries` and `channel_entry` GraphQL query in favor of `exp_channel_entries`
- Removed the `categories` and `category` GraphQL query in favor of `exp_channel_categories`
- Allow `exp.path()` to generate a url from multiple parameters i.e. `exp.path('group/template', entry.url_title)`
- Refactor FormTag and `exp.email.contact_form`, add support for `form_attributes`.

## [0.1.0] - 2023-02-13

### Added

- Option for basic token authentication in GraphQL
- New artisan command for generating tokens `coilpack:graphql --generate-token`
- The ability for third parties to define GraphQL queries in the coilpack schema
- Extra options for configuring Coilpack's GraphQL behavior
- Support for chaining multiple modifiers
- Typed parameter definitions for Fieldtypes and Tags to support GraphQL
- Automatic GraphQL query support for Tags that provide a GraphQL representation

### Fixed

- Compatibility issue with FieldContent and latest Laravel 9
- Handling of Grid field data when inside a Fluid field
- Bootstrap process when Laravel's config is cached with `php artisan config:cache`

### Changed

- GraphQL schema configuration. Coilpack now creates a separate schema named 'coilpack'
- Modifier registration moved to new function, makes use of new Typed parameters
- Add-ons registering tags with Coilpack should now use a key without the Add-on prefix
- Renamed Tag 'parameters' to more appropriately be 'arguments' since they hold runtime values

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

[Unreleased]: https://github.com/ExpressionEngine/Coilpack/compare/0.1.0...HEAD

[0.1.0]: https://github.com/ExpressionEngine/Coilpack/compare/0.0.3...0.1.0

[0.0.3]: https://github.com/ExpressionEngine/Coilpack/compare/0.0.2...0.0.3

[0.0.2]: https://github.com/ExpressionEngine/Coilpack/compare/0.0.1...0.0.2

[0.0.1]: https://github.com/ExpressionEngine/Coilpack/releases/tag/0.0.1
