# Extended Call History Module for Dzvin PBX

[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)

**[Українською](README.uk.md)** | **[Русская версия](README.ru.md)** | **English**

Extended call detail records (CDR) module for Dzvin PBX: a detailed call history with advanced filters, reports, recording downloads and export.

> This is a Dzvin PBX fork of the MikoPBX **ModuleExtendedCDRs** module, based on
> mikopbx/ModuleExtendedCDRs v1.43 - see [Attribution](#attribution) below.

## Features

- **Call history** with filters by employee, department, queue, provider, call state and period
- **Reports** in PDF, XLSX and JSON, including outgoing calls per employee and incoming calls per queue
- **Scheduled reports** delivered by e-mail
- **Export** of call records to an arbitrary HTTP endpoint (webhooks)
- **Recordings** - download a single recording or an archive of recordings matching the filters
- **Background synchronisation** of Asterisk CDR into the module's own database
- **Multi-language** - Ukrainian, English, Russian and many more languages

The module has no licence checks: it is free software and works without any licence key.

## Requirements

- Dzvin PBX 2024.1.114 or higher

## Installation

1. Go to **Modules** -> **Marketplace** in the Dzvin PBX admin panel
2. Find **Extended call history**
3. Click **Install**

Or install from a GitHub release: download the `.zip`, then **Modules** -> **Module Installation** and upload the archive.

## Building a release

```bash
composer install --no-dev
# pack the tree (with vendor/, without .git) into a zip with module.json at its root
```

Dependencies are installed from `composer.json`; `vendor/` is not stored in the repository.

## Attribution

This is a Dzvin PBX fork of [`mikopbx/ModuleExtendedCDRs`](https://github.com/mikopbx/ModuleExtendedCDRs)
(forked from tag `v1.43`, commit `9a4a7e9`), (c) 2017-2024 Alexey Portnov and Nikolay Beketov,
licensed GPL-3.0-or-later. The fork renames the PBX core namespace the module loads against
(`MikoPBX\` -> `DzvinPBX\`) so it runs on Dzvin PBX, removes the MIKO licensing metadata
(`lic_product_id`, `lic_feature_id`), replaces MIKO-branded artwork, completes the Ukrainian
interface translation and adjusts links and the release process for this repository.
The original copyright and licence headers are kept in the source files; see
[MikoPBX Core](https://github.com/mikopbx/Core) for the upstream PBX this module was built for.
