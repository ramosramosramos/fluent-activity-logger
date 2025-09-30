# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2025-09-20
### Added
- Initial release of **Laravel Activity Logger**
- Automatic logging for model events (`created`, `updated`, `deleted`) via `HasAuthActivityLogger` trait
- `CreateActivityLog` action to create logs with:
  - `human_message` and `human_extra_message`
  - `developer_message` and `developer_extra_message`
  - `application_message` (IP, user agent, URL, method, session ID, referer, status code, request payload, old/new changes)
  - `application_extra_message` for custom app context
- Config file (`config/activitylogger.php`) with options for:
  - Table name override
  - Which model events are logged
  - Excluding sensitive request fields
- Config publishing (`php artisan vendor:publish --tag=activity-logger-config`)
- Migration publishing (`php artisan vendor:publish --tag=activity-logger-migrations`)
- Helper functions:
  - `activityLog()` → access the ActivityLog model
  - `createActivityLog()` → quickly create activity logs
- Fallback to `auth()->user()` if no model is passed
