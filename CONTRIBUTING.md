# Contributing

## Source file headers

Every PHP source file under `src/` begins with this header:

```php
<?php
// SPDX-License-Identifier: Apache-2.0
// Copyright (c) 2026 Randy Braunm
declare(strict_types=1);
```

`declare(strict_types=1)` is mandatory: type juggling is a silent-failure source,
and this library fails loud.

## Branch workflow

Work happens on the `claude` branch; changes reach `main` by pull request. Never
push directly to `main`.

## Clean-room rule (v2)

The legacy `class_dicom.php` is not opened, read, or referenced while writing v2
code. Implement only from the DICOM standard (NEMA PS3), the DCMTK
documentation, and the published v1 surface (README and `examples/`). The
standard is the source of truth. See `docs/v2-rewrite-plan.md`.
