# Changelog

All notable changes to the DPD Connect PHP SDK are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [2.1.0] - 2026-10-07

Restores PHP 7.4 as the supported floor, so that SDK 2.x can be adopted by the DPD
PrestaShop module. This partially reverses the decision recorded under 2.0.0 below.

The PrestaShop module supports PrestaShop 1.7 through 8.x and declares its own PHP floor
of `>=7.4`, with a runtime guard that returns early below 70400. While the SDK required
`>=8.1`, that module could not move to 2.x at all. It currently pins the SDK at `^1.1`,
so nothing is broken today: the pin is what keeps 2.0.0 out. Lowering the floor makes the
move possible; whether and when the module takes it is a separate decision.

### Changed
- **PHP requirement lowered from `>=8.1` to `>=7.4`.** No source change was needed:
  all 91 files in `src/` already parse cleanly on PHP 7.4.33. The SDK uses no 8.x-only
  syntax, and its only runtime requirements are `ext-json` and `ext-curl`. The `>=8.1`
  in 2.0.0 was a policy choice, and its stated justification (matching the DPD Magento
  and PrestaShop plugins) was wrong about PrestaShop: that module's floor is 7.4.
  Verified on a real PrestaShop 1.7.8.11 install running on PHP 7.4.33, with the module
  built the way its `prestashop17` CI job builds it but against this release: the SDK
  autoloads, all eight API resources construct, and the cURL path returns a normal
  `HttpException` rather than a fatal. PrestaShop 1.7 ships Symfony 3.4.49 and the
  module sets `prepend-autoloader: false`, so the two vendor trees were the main risk;
  the shop's Symfony version is unchanged after the module's autoloader is registered.
  Storefront and back office both serve HTTP 200 with no fatals.
- **What CI guarantees on 7.4 is narrower than on 8.1 and 8.5.** A new `lint-php74` job
  runs `php -l` over `src/` on every commit, so a syntax error that would break a
  PrestaShop install is caught. Behaviour is not covered: the test suite never runs on
  7.4, because PHPUnit 10.5, overtrue/phplint 9.6 and symfony/yaml 6.4 all require 8.1
  or higher and no release of them supports both ends. Runtime differences that are not
  parse errors, string-to-number comparison semantics being the classic example, are
  therefore not caught by CI on 7.4.
- `Client::CLIENT_VERSION` bumped to `2.1.0`, matching the tag. This value is sent to
  DPD as the `x-sdk-version` header, and `sync-to-github` refuses to publish when the
  constant and the tag disagree.
- `docs/ci-php-version-matrix.md` corrected and extended with the new job.

### Note on PHP 7.4
PHP 7.4 has been end of life since November 2022 and receives no security updates. It
is supported here to keep the PrestaShop 1.7 module installable, not because it is a
recommended runtime. New code in this SDK should still be reviewed against the 7.4
floor until the PrestaShop module moves to a supported PHP version.

## [2.0.0] - 2026-09-07

Annual maintenance release. The SDK now runs on current, supported PHP versions
and an up-to-date development/test toolchain.

### Added
- `tests/Unit/HttpClientRequestTest.php` — real HTTP round-trips through
  `HttpClient::sendRequest()` against `donatj/mock-webserver`, covering the cURL code
  path (GET and POST) for the first time.
- `docs/ci-php-version-matrix.md` — records which CI checks run on which PHP versions
  and the measurements behind that choice.
- Automated GitLab → GitHub release sync (`sync-to-github` in `.gitlab-ci.yml`).
  Creating a release tag on GitLab now mirrors the tree to `dpdconnect/php-sdk` on
  GitHub, tags it there and publishes the Release with this file's matching section as
  its notes, after which Packagist picks the version up. GitHub is the source Packagist
  resolves, so this closes the gap that left GitLab tagged `1.0.2` while GitHub was on
  `1.1.14` with a `CLIENT_VERSION` of `1.0.5`. The job refuses to publish when
  `CLIENT_VERSION` and the tag disagree.

### Changed
- **PHP requirement set to `>=8.1`**, matching the DPD Magento and PrestaShop
  shipping plugins. Both ends of that range are exercised by CI: the test suite and
  `phplint` run on PHP 8.1.34 and 8.5.8 (no implicit-nullable or dynamic-property
  deprecations; `phplint` clean across 99 files).
- Development/test toolchain modernised:
  - PHPUnit `^8.5` → `^10.5`
  - symfony/yaml `^4.2` → `^6.4 || ^7.0`
  - overtrue/phplint `^1.1` → `~9.6.0`
  - squizlabs/php_codesniffer `^3.0@dev` → `^3.13.6`
  - donatj/mock-webserver `^2.0` → `^2.7`

  PHPUnit and phplint are pinned one release line back on purpose: PHPUnit 11 requires
  PHP `>=8.2` and phplint 9.7 requires `^8.2`, so neither can run on the declared 8.1
  floor. Both pinned lines are actively maintained — PHPUnit 10.5.64 and 11.5.56 were
  released on the same day. If the floor is ever raised to 8.2, both pins can be
  lifted. `symfony/yaml` resolves to 6.4.45 for the same reason.
- PHPUnit configuration migrated to the 10.x schema (`<source>` coverage config,
  `cacheDirectory`, `<testsuite>` wrapped in `<testsuites>`); test dependency metadata
  migrated from `@depends` doc-comments to `#[Depends(...)]` attributes.
- PHPUnit now fails on deprecations, notices and warnings (`failOnDeprecation`,
  `failOnNotice`, `failOnWarning`). Without this the PHP version matrix reported
  deprecations but still exited 0.
- CI runs on every commit, including merge request pipelines. Jobs previously relied
  on the legacy default `only: [branches, tags]`, which silently skipped the analyse
  and test stages on every merge request.
- CI runs `phpunit` and `phplint` on both ends of the declared range (8.1 and 8.5).
  The intermediate versions were measured to add no signal; see
  `docs/ci-php-version-matrix.md`.
- CI cache keys are now per PHP version. A single shared key handed matrix jobs a
  `vendor/` tree installed on a different PHP version.
- CI base image bumped to PHP 8.5 for the version-independent jobs
  (`composer validate`, `composer audit`, `phpcs`).
- `phpcs` is now a blocking job. The PSR-2 violations it had been reporting under
  `allow_failure: true` are fixed: four `Expected 1 space after IF keyword` errors in
  `src/Objects/BaseObject.php`, and four lines over 120 characters in
  `src/Model/Request/RequestMapper.php` and `src/ClientBuilder.php` (reformatted only,
  no behaviour change).
- `.phplint.yml` now lists `src`, `tests` and `test.php` explicitly instead of
  `path: ./` with `exclude: vendor` — phplint 9.6 does not apply that exclude to its
  own vendor fixtures, which ship a deliberate syntax error.

### Fixed
- `curl_close()` removed from `HttpClient::sendRequest()`. The function has been a
  no-op since PHP 8.0 and is deprecated as of PHP 8.5, where it emitted
  `Function curl_close() is deprecated since 8.5, as it has no effect since PHP 8.0`
  on every API call.
- `Client::CLIENT_VERSION` corrected from `1.0.5` to `2.0.0`. This constant is sent to
  DPD as the `x-sdk-version` header on every request, so their metrics were attributed
  to a version that was never released.
- `tests/ApiTestCase.php` repaired and moved to the location its namespace maps to.
  It was unreachable dead code: no test class extended it, its filename did not match
  `*Test.php` so PHPUnit never loaded it, its `setUp()`/`tearDown()` signatures were
  incompatible with PHPUnit 10/11, it referenced `DpdConnect\Sdk\Api\AuthenticationApi`
  (which does not exist in the SDK), and its stub auth response was invalid JSON.
- The `phpunit` CI job declared a JUnit report at `build/logs/clover-unit.xml` but never
  generated it, so GitLab never showed test results. The suite now writes
  `build/logs/junit.xml`.

### Security
- `squizlabs/php_codesniffer` raised to `^3.13.6`, resolving CVE-2026-67434 (OS command
  injection, high severity; affects `< 3.13.6`). Development dependency only — it is not
  installed by consumers of the SDK.
- `sync-to-github` refuses to publish when the tree still references internal
  infrastructure — the build registry, an internal host:port, or the internal
  development domain. The patterns live in the job itself, deliberately not repeated
  here: this file is published too. `docs/` is generated and picks up CI details on
  every regeneration, so excluding today's offenders by name would not hold;
  `docs/ci-php-version-matrix.md` is excluded outright as an internal decision record.
- The `security-checker` CI job was replaced by `composer audit`. The `security-checker`
  binary is not present in the CI images and the job's `|| true` made it pass
  unconditionally, which is why the advisory above went unnoticed.

### Removed
- Support for **PHP 5.5, 7.x and 8.0** (all end-of-life).
- The `phpmd` and `phpcpd` CI jobs. Neither binary is present in the CI images, so both
  jobs produced no signal; `phpcpd` is additionally abandoned upstream. `phpmd.xml` is
  kept in the repository should the check be reinstated as a proper dependency.

### Notes
- **API contract:** no DPD Connect API contract changes were supplied for this
  update cycle; the SDK's endpoint and request/response model coverage is unchanged.
- `docs/` is generated by `/create-documentation`. The parts that would have been
  published to the public GitHub mirror while wrong — the PHP requirement tables and the
  CI description in `docs/CONTRIBUTING.md` — were corrected by hand. A full regeneration
  is still worth doing and is tracked separately.

### Migration from 1.x
- **PHP runtime (breaking):** the last published release, 1.1.14, requires
  `^5.5 || ^7.0 || ^8.0`, so an installation upgrading from it may be several major PHP
  versions behind. Upgrade your application to **PHP 8.1 or newer** before updating
  this SDK. Projects that must stay where they are should pin
  `"dpdconnect/php-sdk": "^1.1"` — that is the range the DPD shipping plugins
  currently constrain the SDK to.
- **Public SDK API:** unchanged — no changes to classes, methods, or request/response
  models. Application code that consumes the SDK needs no changes beyond the PHP bump.
- **Contributors only:** the test suite now runs on PHPUnit 10.5 (migrated config and
  attribute-based metadata) and fails on deprecations, notices and warnings; no change
  is required to consume the SDK.

## [1.1.14] and earlier

Releases up to and including 1.1.14 were published to GitHub and Packagist without a
corresponding GitLab tag — GitLab's tag history stops at `1.0.2`. Their notes live with
the [GitHub releases](https://github.com/dpdconnect/php-sdk/releases); this file starts
at 2.0.0, the first release cut through the automated sync.
