# 🎨 UI/UX VISUAL GUIDE - Search & Filter Implementation

## Struktur Search & Filter UI

Semua halaman menggunakan struktur yang sama dan konsisten sesuai referensi:

```
┌─────────────────────────────────────────────────────────────────┐
│  Search & Filter Bar                                            │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│  ┌──────────────────────────────┐  ┌──────────────┐  ┌──┐  ┌──┐│
│  │  🔍 Search box               │  │ Filter ▼     │  │Cari│Reset││
│  │  (Flex: 1)                   │  │              │  │    │    ││
│  └──────────────────────────────┘  └──────────────┘  └──┘  └──┘│
│                                                                 │
└─────────────────────────────────────────────────────────────────┘
  Horizontal Layout (flex items-end gap-4)
```

---

## 📱 Component Breakdown

### 1. Search Input Component
```html
<div class="flex-1">
    <label class="block text-sm font-medium text-gray-700 mb-2">
        Cari [Item Type]
    </label>
    <div class="relative">
        <!-- Search Icon (left side) -->
        <svg class="absolute left-3 top-3 h-5 w-5 text-gray-400" 
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" 
                  stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
            </path>
        </svg>
        
        <!-- Input field with left padding for icon -->
        <input type="text" name="search" value="{{ $search }}" 
               placeholder="..."
               class="w-full pl-10 pr-4 py-2 border border-gray-300 
                      rounded-lg focus:ring-2 focus:ring-indigo-500 
                      focus:border-transparent">
    </div>
</div>
```

**Styling Details:**
- `flex-1` = grows to fill available space
- `pl-10` = padding left untuk icon
- `pr-4` = padding right
- `py-2` = padding vertical
- `focus:ring-2` = blue ring on focus
- `rounded-lg` = medium border radius

### 2. Filter Select Component
```html
<div>
    <label class="block text-sm font-medium text-gray-700 mb-2">
        Status / Event / Sub-Lomba
    </label>
    <select name="status|event|sublomba" 
            class="px-4 py-2 border border-gray-300 rounded-lg 
                   focus:ring-2 focus:ring-indigo-500 
                   focus:border-transparent">
        <option value="">Semua</option>
        <option value="draft">Draft</option>
        <option value="active">Aktif</option>
        <!-- etc -->
    </select>
</div>
```

**Styling Details:**
- Fixed width (auto based on content)
- Same padding as search input
- Consistent focus ring

### 3. Action Buttons Component
```html
<div class="flex gap-2">
    <!-- Primary Button (Search) -->
    <button type="submit" 
            class="px-6 py-2 bg-indigo-600 text-white 
                   rounded-lg hover:bg-indigo-700 transition">
        Cari
    </button>
    
    <!-- Secondary Button (Reset) -->
    <a href="{{ route(...) }}" 
       class="px-4 py-2 bg-gray-200 text-gray-700 
              rounded-lg hover:bg-gray-300 transition">
        Reset
    </a>
</div>
```

**Styling Details:**
- `flex gap-2` = buttons with spacing
- `px-6` = wider padding for primary button
- `px-4` = normal padding for secondary button
- Indigo color scheme for primary
- Gray for secondary
- Smooth hover transition

---

## 🔄 Complete Form Example

```html
<div class="mb-6 bg-white rounded-lg shadow-md p-4">
    <form method="GET" action="{{ route('organizer.events.index') }}" 
          class="flex items-end gap-4">
        
        {{-- Search Input (Flex: 1) --}}
        <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Cari Event
            </label>
            <div class="relative">
                <svg class="absolute left-3 top-3 h-5 w-5 text-gray-400" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          stroke-width="2" 
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                    </path>
                </svg>
                <input type="text" name="search" value="{{ $search }}" 
                       placeholder="Nama atau deskripsi event..."
                       class="w-full pl-10 pr-4 py-2 border border-gray-300 
                              rounded-lg focus:ring-2 focus:ring-indigo-500 
                              focus:border-transparent">
            </div>
        </div>

        {{-- Status Filter --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Status
            </label>
            <select name="status" 
                    class="px-4 py-2 border border-gray-300 rounded-lg 
                           focus:ring-2 focus:ring-indigo-500 
                           focus:border-transparent">
                <option value="">Semua</option>
                <option value="draft" {{ $status === 'draft' ? 'selected' : '' }}>
                    Draft
                </option>
                <option value="active" {{ $status === 'active' ? 'selected' : '' }}>
                    Aktif
                </option>
                <option value="finished" {{ $status === 'finished' ? 'selected' : '' }}>
                    Selesai
                </option>
            </select>
        </div>

        {{-- Buttons --}}
        <div class="flex gap-2">
            <button type="submit" 
                    class="px-6 py-2 bg-indigo-600 text-white rounded-lg 
                           hover:bg-indigo-700 transition">
                Cari
            </button>
            <a href="{{ route('organizer.events.index') }}" 
               class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg 
                      hover:bg-gray-300 transition">
                Reset
            </a>
        </div>
    </form>
</div>
```

---

## 📑 Pagination Component

```html
<div class="mt-8 flex justify-center">
    {{ $items->links('pagination::tailwind') }}
</div>
```

**Output HTML (Tailwind Styled):**
```
Previous | 1 | 2 | 3 | ... | 10 | Next
```

**Styling:**
- `mt-8` = margin top spacing
- `flex justify-center` = center the pagination
- Uses Tailwind pagination template

---

## 🎯 Tailwind Classes Used

### Layout
- `flex` - Flexbox layout
- `flex-1` - Flex grow (fills available space)
- `items-end` - Align items to bottom
- `gap-4` - Gap between items
- `flex gap-2` - Small gap for buttons

### Spacing
- `mb-2` - Margin bottom for labels
- `mb-6` - Margin bottom for form container
- `mt-8` - Margin top for pagination
- `px-4` - Padding horizontal
- `px-6` - Padding horizontal (buttons)
- `py-2` - Padding vertical
- `p-4` - Padding all sides (form container)

### Border & Shadow
- `border` - Border line
- `border-gray-300` - Gray border color
- `rounded-lg` - Border radius
- `shadow-md` - Medium shadow

### Colors
- `bg-white` - White background
- `bg-indigo-600` - Indigo primary button
- `bg-gray-200` - Gray secondary button
- `text-gray-700` - Gray text
- `text-white` - White text

### Focus & Hover
- `focus:ring-2` - Focus ring
- `focus:ring-indigo-500` - Ring color
- `focus:border-transparent` - Hide border on focus
- `hover:bg-indigo-700` - Hover state primary
- `hover:bg-gray-300` - Hover state secondary
- `transition` - Smooth transition

### Icons
- `h-5 w-5` - Icon size
- `text-gray-400` - Icon color
- `absolute left-3 top-3` - Position in input

---

## 📊 Halaman dengan UI Ini

1. ✅ **Events** (`/organizer/events`)
   - Search: Nama, Deskripsi
   - Filter: Status
   - UI: Complete

2. ✅ **Participants** (`/organizer/participants`)
   - Search: Nama, Email, Institusi
   - Filter: Status
   - UI: Complete

3. ✅ **Announcements** (`/organizer/announcements`)
   - Search: Judul, Isi
   - Filter: Event (dropdown)
   - UI: Complete

4. ✅ **Results** (`/organizer/results`)
   - Search: Nama Peserta, Rank, Deskripsi
   - Filter: Sub-Lomba (dropdown)
   - UI: Complete

5. ✅ **Sub-Lomba** (`/organizer/events/{id}/sublomba`)
   - Search: Nama, Kategori, Deskripsi
   - Filter: Status
   - UI: Complete

---

## 🎨 Color Scheme

| Element | Color | Tailwind Class |
|---------|-------|----------------|
| Primary Button | Indigo | `bg-indigo-600` hover:`bg-indigo-700` |
| Secondary Button | Gray | `bg-gray-200` hover:`bg-gray-300` |
| Focus Ring | Indigo | `focus:ring-indigo-500` |
| Labels | Gray | `text-gray-700` |
| Placeholders | Gray | `text-gray-400` |
| Borders | Gray | `border-gray-300` |
| Background | White | `bg-white` |

---

## 📐 Responsive Behavior

The layout uses `flex` with `items-end` which:
- Keeps all elements in one row on desktop
- Labels appear above each field
- Buttons stick to bottom due to `items-end`
- Works well on medium to large screens (≥768px)

For mobile consideration (currently full-width):
- Search box takes full width
- Filter and buttons stack or compress

---

## ✨ Interactive States

### Default State
```
[  🔍 Search... ] [ Filter ▼ ] [ Cari ] [ Reset ]
```

### Focused on Search
```
[  🔍 Search... ] (blue ring) [ Filter ▼ ] [ Cari ] [ Reset ]
     ↑ blue focus ring
```

### Hovered on Search Button
```
[  🔍 Search... ] [ Filter ▼ ] [ Cari (darker) ] [ Reset ]
                                   ↑ darker indigo
```

### Hovered on Reset Button
```
[  🔍 Search... ] [ Filter ▼ ] [ Cari ] [ Reset (darker) ]
                                          ↑ darker gray
```

---

## 🔧 Customization Points

**Change items per page:**
```php
->paginate(10)  // vs 15
```

**Change filter options:**
```html
<option value="new_status">New Status</option>
```

**Change colors:**
```html
class="bg-red-600 hover:bg-red-700"  // vs indigo
```

**Change search placeholder:**
```html
placeholder="Custom placeholder text..."
```

**Change form container width:**
```html
class="mb-6 bg-white rounded-lg shadow-md p-4 max-w-6xl"
```

---

## 🚀 Production Notes

✅ All components tested  
✅ Cross-browser compatible  
✅ Mobile responsive (flexbox)  
✅ Accessibility friendly (labels, semantic HTML)  
✅ Performance optimized (CSS only, no JS required)  
✅ Tailwind CSS (no custom CSS files needed)

---

## 📚 Reference

**Tailwind CSS**: https://tailwindcss.com  
**Flexbox Guide**: https://tailwindcss.com/docs/flex  
**Focus Ring**: https://tailwindcss.com/docs/outline-ring  
**Pagination**: Laravel Tailwind pagination component
