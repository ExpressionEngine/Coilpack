# Changelog

## [Unreleased]

## [1.3.0] - 2024-03-18

### Added

- Ability to pass a 'tagdata' parameter to the ExpressionEngine Template library
- Support for the Member fieldtype introduced in ExpressionEngine 7.4
- A custom user provider to enable the `coilpack` guard to be used for logging in ExpressionEngine members through Laravel's authentication manager.

### Fixed

- Bug retrieving dynamic Structure entry from Structure Entries tag
- GraphQL response error when site has no content populated
- Improve handling of LegacyTag to preserve a tag's string output when structured data exists
- Setting proper visibility when setting protected values through reflection

## [1.2.2] - 2023-12-05

### Fixed

- Bug in transforming headers for Laravel response

## [1.2.1] - 2023-11-28

### Fixed

- Bug in converting ExpressionEngine response headers

## [1.2.0] - 2023-11-20

### Added

- The ability for ExpressionEngine to utilize Laravel cache adapters
- Artisan command to proxy ExpressionEngine's `eecli` commands in the context of Laravel and Coilpack after they have fully booted.  This command is available through `php artisan eecli`.
- Parameter to Channel Entries Tag for eager loading relationships.  This allows for easier inclusion of custom field data with `exp.channel.entries({with: 'data'})`

### Fixed

- Behavior of File Modifier to return original data when manipulation fails silently
- Generic fieldtype passes `content_id` along to core fieldtype handler and triggers `pre_process` hook.
- Error checking and handling for GraphQL compatible fieldtypes
- Trigger `core_boot` hook during GraphQL requests
- Handling of blank headers in HTTP responses
- Custom field orderby clauses when it uses legacy field data storage

## [1.1.2] - 2023-07-27

### Fixed

- Enabled direct access to fields inside a FieldGroupContent model using a field name
- Behavior of replacement tags for Comments module - `exp.comment.form` and `exp.comment.preview`
- Bug due to order of operations in casting database port to integer

## [1.1.1] - 2023-06-15

### Fixed

- Handle a scenario where Fluid fields save an empty string in their list of associated fields
- Displaying Fluid field when one of the content fields has been deleted but not unassociated

## [1.1.0] - 2023-06-14

### Added

- Support for Fluid Field Groups and chainable modifiers introduced in ExpressionEngine 7.3
- Configuration flag to signal preference for using GraphQL Union Types

### Fixed

- Behavior of `exp.redirect()` tag
- Support for Laravel csrf tokens in ExpressionEngine templates
- Using Channel Entries `entry_id` parameter in conjunction with `search` parameter
- When using the `php artisan coilpack` command with a `--dev` or `--source` flag allow a version choice
- Cloning functionality by making ExpressionEngine Request available during Core bootstrap
- GraphQL behavior so that order of modifier arguments is respected

## [1.0.1] - 2023-05-09

### Fixed

- Logic for determining behavior of `redirect()` function used within ExpressionEngine
- Only generate GraphQL queries from Tags during a GraphQL request
- Support for caching Twig and Blade templates parsed through the template library
- Improve performance by lazily instantiating replacement Tag classes
- An issue where Relationship queries could return incorrect records
- Handling of GraphQL list types when Fieldtypes are nested

## [1.0.0] - 2023-04-27

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
- Global Variables for logged\_in and logged\_out
- Better error handling for incomplete installations
- Support for Grid parameters on LivePreview data

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
- Structure Nav tag behavior now respects hidden nodes
- Support for Captcha in Email Contact Form
- Live Preview display with Channel Entries Tag replacement
- Error where GraphQL Tag queries accumulated arguments
- Fluid field database connection issue when default Laravel db connection is not configured
- Better handling of FieldContent methods when value is null
- Error in Fluid Field when settings reference a field that has been deleted

### Changed

- Tag argument mutation now happens on 'get' instead of 'set'
- Standardize GraphQL type handling through Coilpack's GraphQL Facade
- Removed the `channel_entries` and `channel_entry` GraphQL query in favor of `exp_channel_entries`
- Removed the `categories` and `category` GraphQL query in favor of `exp_channel_categories`
- Allow `exp.path()` to generate a url from multiple parameters i.e. `exp.path('group/template', entry.url_title)`
- Refactor FormTag and `exp.email.contact_form`, add support for `form_attributes`.
- Cleanup and simplify Template library for rendering Twig and Blade templates
- No longer overriding ExpressionEngine's `base_url` with Laravel's `APP_URL` unless `base_url` is not set.
- Channel Entries Tag now has a default ordering to match native Tag.  Sticky entries are first followed by those with the latest entry\_date.
- Fieldtype `parameters()` has been renamed to `parametersForField()`
- Simplify install command to use the latest version of ExpressionEngine 7

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

[Unreleased]: https://github.com/ExpressionEngine/Coilpack/compare/1.3.0...HEAD

[1.3.0]: https://github.com/ExpressionEngine/Coilpack/compare/1.2.2...1.3.0

[1.2.2]: https://github.com/ExpressionEngine/Coilpack/compare/1.2.1...1.2.2

[1.2.1]: https://github.com/ExpressionEngine/Coilpack/compare/1.2.0...1.2.1

[1.2.0]: https://github.com/ExpressionEngine/Coilpack/compare/1.1.2...1.2.0

[1.1.2]: https://github.com/ExpressionEngine/Coilpack/compare/1.1.1...1.1.2

[1.1.1]: https://github.com/ExpressionEngine/Coilpack/compare/1.1.0...1.1.1

[1.1.0]: https://github.com/ExpressionEngine/Coilpack/compare/1.0.1...1.1.0

[1.0.1]: https://github.com/ExpressionEngine/Coilpack/compare/1.0.0...1.0.1

[1.0.0]: https://github.com/ExpressionEngine/Coilpack/compare/0.1.0...1.0.0

[0.1.0]: https://github.com/ExpressionEngine/Coilpack/compare/0.0.3...0.1.0

[0.0.3]: https://github.com/ExpressionEngine/Coilpack/compare/0.0.2...0.0.3

[0.0.2]: https://github.com/ExpressionEngine/Coilpack/compare/0.0.1...0.0.2

[0.0.1]: https://github.com/ExpressionEngine/Coilpack/releases/tag/0.0.1
