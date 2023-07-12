# 4.2.9

- Added extas php config convertation into `AppWriter`.

# 4.2.8

- Turn extas php config convertation on.

# 4.2.7

- Added converting extas php configs.

# 4.2.6

- Use cwd for searching extas packages.

# 4.2.5

- Detailed extas packages search path.

# 4.2.4

- Use app install output for extas entities installation too.

# 4.2.3

- Added installing extas-entities for applications.

# 4.2.2

- Added rights to sub-composer and sub-vendor on command app install. 

# 4.2.1

- Added default app values as values for instance on creating.

# 4.2.0

- Added `IInstanceService::updateInstanceVersion(string $instanceId): bool`.

# 4.1.0

- Added `IHaveApplicationName`, `THasApplicationName`.

# 4.0.1

- Added instance version on creating by app.

# 4.0.0

- Removed `IHasClass` from `IInstance`, cause it is duplicating `IHaveResolver` aims.

# 3.0.0

- Changed native `params`-interfaces and classes with `extas-foundation` implementation.

# 2.0.0

- Replaced events and operations entities with `IParametred`.

# 1.4.0

- Added `IHaveInstance` and `THasInstance`.

# 1.3.1

- Fixed `after one` code for inctances info.

# 1.3.0

- Added `TExtendable` to `EStates`.
- Added method `IInstanceService::updateInstance(IInstance $instance, array $data, array $options): bool`.

# 1.2.1

- Rm unused code.

# 1.2.0

- Added `IAppInfo`.

# 1.1.0

- Added `IInstanceService::getInstancesByApp(string $appId, array $insVendorNames): IInstance[]`.
- Added `IInstanceService::groupInstancesByApp(array $instances): array`.

# 1.0.0

- Renamed practically all classes namespace.
- `ApplicationPackage` renamed to `Application`.
- `ApplicationPackageService` is divided to `AppReader` and `AppWriter`.

# 0.4.0

- Added `updatePackage()` for `ApplicationPackageService`.

# 0.3.1

- Added enum `ETypes` for option types.

# 0.3.0

- Added `getResolver()` method to a `IApplicationPackage` and `IINstance`.
- Removed `getResolver()` from `IOptions`.

# 0.2.1

- Added config for instances for extas.

# 0.2.0

- Added instances support.

# 0.1.3

- Fixed command output.

# 0.1.2

- Added `extas.storage.php`.

# 0.1.1

- Added bin section to composer.

# 0.1.0

- Added basic entities.
- Added `df ia` command.