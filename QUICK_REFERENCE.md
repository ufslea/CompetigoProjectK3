# Quick Reference Guide - Two-Step Registration & Submission

## 🎯 Feature Overview

Competigo K3 now has a **two-step participant flow** that separates registration from work submission:

- **Step 1: Pendaftaran (Registration)** → Register for sub-lomba with proof
- **Step 2: Submit Karya (Submission)** → Upload actual work after registration

---

## 📍 URL Paths

### Step 1: Registration Form
```
GET /participant/competitions/{event_id}/sublomba/{sublomba_id}/register
```
**Displays**: Registration form with conditional proof fields based on jenis_sublomba

### Step 2: Submission Form
```
GET /participant/competitions/{sublomba_id}/create
```
**Displays**: Submission form for uploading work (file or URL)

### Event Detail (Status Dashboard)
```
GET /participant/competitions/{event_id}
```
**Displays**: Sub-lomba cards with user registration/submission status

---

## 🔧 Form Fields

### Registration Form (Step 1)

#### Always Present:
- Nama (auto-filled)
- Email (auto-filled)
- Institusi (editable)
- Kontak (editable phone)

#### For Berbayar Sub-Lomba:
- Nominal Bayar (number, min 1000)
- Bukti Transfer (image file, max 5MB)

#### For Gratis Sub-Lomba:
- Handle Sosmed (text, max 100 chars)
- Bukti Follow (image file, max 5MB)

### Submission Form (Step 2)

- Sub-Lomba Selection (dropdown)
- Karya Upload Toggle:
  - **File**: Upload document/archive/image (max 10MB)
  - **Link**: URL to Google Drive, GitHub, Dropbox, etc.
- Deskripsi Karya (textarea, max 500 chars)

---

## 📊 Status Badges on Event Page

### User Status per Sub-Lomba

| Badge | Meaning | Action Button |
|-------|---------|---|
| (No badge) | Not registered | "📝 Daftar" |
| ⚠️ Yellow | Registered, not submitted | "📤 Submit Karya" |
| ✅ Green | Submitted | "✓ Sudah Disubmit" (disabled) |

---

## 🗄️ Database Records

### Current Seed Data:
- **Users**: 36 (3 default + 30 participants)
- **SubLomba**: 7 (with jenis_sublomba: berbayar/gratis)
- **Partisipan**: 66

### Test Credentials:
- Email: `participant1@example.com` through `participant30@example.com`
- Password: `test123456`
- Role: participant

---

## 🗂️ File Storage Locations

| Type | Path | Max Size |
|------|------|----------|
| Payment Proof (Bukti Transfer) | `storage/app/public/bukti-pembayaran/` | 5 MB |
| Follow Proof (Bukti Follow) | `storage/app/public/bukti-follow/` | 5 MB |
| Work Submission | `storage/app/public/submissions/` | 10 MB |

**Access**: Files accessible via `/storage/{filename}`

---

## ✅ Validation Summary

### Registration (Step 1)
```
Berbayar:
- nominal_bayar: integer, >= 1000
- bukti_transfer: image, <= 5MB

Gratis:
- handle_sosmed: string, <= 100 chars
- bukti_follow: image, <= 5MB
```

### Submission (Step 2)
```
- karya_type: file OR link (required)
- file_karya: file, <= 10MB (if file type)
- karya_url: valid URL (if link type)
- deskripsi_karya: string, <= 500 chars
```

---

## 🔄 User Journey

```
1. Login as Participant
   ↓
2. Navigate to Event Detail Page
   ↓
3. Browse Sub-Lomba Cards (see status badges + type)
   ↓
4. Click "📝 Daftar" Button
   ↓
5. Fill Registration Form (Step 1)
   - Different fields based on berbayar/gratis
   - Upload proof file
   ↓
6. Submit Registration
   ↓
7. Click "📤 Submit Karya" Button (appears after Step 1)
   ↓
8. Fill Submission Form (Step 2)
   - Choose file upload or URL link
   - Add description
   ↓
9. Submit Karya
   ↓
10. See "✓ Sudah Disubmit" Status on Event Page
```

---

## 🧪 Testing Checklist

### Quick Test Flow

1. **Registration Test (Berbayar)**
   - [ ] Go to event → see "Daftar" button
   - [ ] Click "Daftar" on Frontend (berbayar)
   - [ ] Form shows: Nominal + Bukti Transfer fields
   - [ ] Upload image file (< 5MB)
   - [ ] Submit successfully
   - [ ] File appears in `storage/app/public/bukti-pembayaran/`

2. **Registration Test (Gratis)**
   - [ ] Click "Daftar" on Backend (gratis)
   - [ ] Form shows: Handle Sosmed + Bukti Follow fields
   - [ ] Fill handle (e.g., @username)
   - [ ] Upload image file (< 5MB)
   - [ ] Submit successfully
   - [ ] File appears in `storage/app/public/bukti-follow/`

3. **Submission Test**
   - [ ] After registration, see "Submit Karya" button
   - [ ] Click "Submit Karya"
   - [ ] See step indicator "Step 1 ✓ → Step 2"
   - [ ] Test file upload: drag-drop works, preview shows
   - [ ] Test URL link: switch to link tab, enter URL
   - [ ] Add description
   - [ ] Submit successfully
   - [ ] File/URL saved to `storage/app/public/submissions/`

4. **Status Verification**
   - [ ] After submission, badge changes to "✓ Sudah Disubmit"
   - [ ] Button becomes disabled/grayed out

---

## 🔧 Admin/Organizer

### Sub-Lomba Creation (Admin)

When creating/editing a sub-lomba, select:
```
Jenis Sub-Lomba:
○ Gratis (Perlu bukti follow sosmed)
○ Berbayar (Perlu bukti pembayaran)
```

This determines what proof participants must provide.

---

## 🚀 Setup Commands

### First Time Setup
```bash
# Migrate new jenis_sublomba column
php artisan migrate

# Seed test data
php artisan db:seed --class=SubLombaSeeder
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=PartisipanSeeder

# Create storage symlink for file access
php artisan storage:link
```

### Running Tests
```bash
# Check PHP syntax
php -l app/Http/Controllers/PartisipanController.php
php -l app/Http/Controllers/SubLombaController.php

# Verify database
php artisan tinker
> \App\Models\SubLomba::pluck('jenis_sublomba')->unique()
```

---

## 📝 Important Notes

1. **File Limits**:
   - Proof files (bukti): max 5MB, must be image
   - Karya files: max 10MB, any file type
   - Configure in `config/filesystems.php` if needed

2. **Storage Symlink**:
   - Run `php artisan storage:link` after deployment
   - Files won't be accessible without symlink

3. **Email Notifications** (optional):
   - Currently manual verification
   - Can add email notifications in registerStore/store methods
   - Future: Add approved/rejected status notification

4. **Payment Processing** (future):
   - Currently manual proof upload
   - Can integrate payment gateway (Midtrans, etc.)
   - Would replace nominal_bayar input with payment form

5. **Social Media Verification** (future):
   - Currently manual screenshot
   - Can integrate API for auto-verification
   - Would replace bukti_follow upload with API check

---

## 🐛 Troubleshooting

### Issue: "Form shows all fields, not conditional"
**Solution**: Clear browser cache, ensure jenis_sublomba column exists in DB
```bash
php artisan migrate
php artisan db:seed --class=SubLombaSeeder
```

### Issue: "File uploads not working"
**Solution**: 
```bash
php artisan storage:link
chmod -R 777 storage/app/public
```

### Issue: "Can't submit after registration"
**Solution**: Verify Partisipan record created with correct user_id and sublomba_id
```bash
php artisan tinker
> \App\Models\Partisipan::where('user_id', 1)->first()
```

### Issue: "Redirect loop on register"
**Solution**: Check if user already registered for same sub-lomba
```bash
php artisan tinker
> \App\Models\Partisipan::where('user_id', 1)->where('sublomba_id', 1)->first()
```

---

## 📞 Support

For issues or questions:
1. Check IMPLEMENTATION_SUMMARY.md for detailed documentation
2. Review this quick reference guide
3. Check application logs: `storage/logs/laravel.log`
4. Run validation checks mentioned in Troubleshooting section

---

**Version**: 1.0 (Two-Step Flow Implementation)
**Status**: ✅ Production Ready
**Last Updated**: Session Complete
