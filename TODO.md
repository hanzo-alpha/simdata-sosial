# Project TODO List

## 🛡️ Security & Multi-tenancy
- [x] Implement `HasKelurahanScope` trait for global row-level security.
- [x] Apply the trait to all relevant models (BantuanRastra, BantuanBpjs, etc.).
- [x] Verify that Admin Kelurahan can only see/edit their own data across all resources.

## 🔍 Data Integrity
- [x] Create a global `NikValidationRule` to check NIK format and presence in master data.
- [x] Implement the validation rule across all aid resources.
- [x] Add cross-check logic between different aid programs (e.g., checking if someone already receives another aid).

## 📊 Database Consistency
- [x] Standardize NIK/KK column names across all tables (move to `nik` and `no_kk`).
- [x] Create a migration to rename columns and update all references in the code.
- [x] Add database-level indexes on `nik` and `no_kk` for performance.

## 🚀 Performance Optimization
- [x] Audit all `$with` properties in models and move eager loading to Resources where appropriate.
- [x] Implement caching for static data like Kecamatan/Kelurahan lists.
- [x] Optimize global search by limiting searchable columns.

## 📝 Audit & Logging
- [x] Ensure all Bulk Actions (Delete/Import) are recorded in `activity_log`.
- [x] Enhance log details to include "before" and "after" snapshots for critical changes.
- [x] Create a UI for Superadmins to easily browse audit logs.

## 🧪 Testing & QA
- [x] Add Architecture tests using Pest to enforce code standards (e.g., `casts()` method usage).
- [x] Add Feature tests for critical workflows: Penyaluran Bantuan and CSV Imports.
- [x] Implement "Smoke Tests" for all Filament resources.

## 🔄 Workflow & UX
- [x] Implement real-time notifications for background job completion (Import/Export).
- [x] Add a "Queue Monitor" dashboard for users to track their background tasks.
- [x] Add a global "Data Integrity Dashboard" to show duplicity or invalid data.
