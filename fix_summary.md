# Fix Summary: Property [status] does not exist on this collection instance

## Problem
The error "Property [status] does not exist on this collection instance" occurred when users tried to view their tryout scores (nilai tryout). This happened because the code was trying to access properties directly on a Laravel Collection instead of on individual Model instances.

## Root Cause
In the `nilai()` method of `UjianController.php`, the code was incorrectly handling the `ujianUser` relationship:

### Before (Problematic Code):
```php
$ujian = Ujian::with(['ujianUser' => function($query) {
    $query->where('is_first', 1)->where('user_id', auth()->user()->id)->first();
}, 'ujianUser.jawabanPeserta', 'ujianUser.jawabanPeserta.soal.jawaban'])
->findOrFail($id);

// This was wrong - trying to use collection as single object
$ujianUser = $ujian->ujianUser; // Collection, not single object

// This caused the error - accessing property on collection
if ($ujianUser->status != '2') { // ERROR: Property doesn't exist on collection
```

### In the View:
```php
{{ $ujian->ujianUser[0]->status }}  {{-- This worked but was inconsistent --}}
{{ $ujian->ujianUser[0]->nilai }}   {{-- Risk of index out of bounds --}}
```

## Solution
### After (Fixed Code):

#### Controller Changes:
1. **Removed `first()` from relationship query** - it doesn't work as expected with `hasMany` relationships
2. **Get first item from collection** - properly extract the single model instance
3. **Added proper null checking** - use `isNotEmpty()` for safer collection operations
4. **Improved variable naming** - use `$currentUserUjian` for clarity

```php
$ujian = Ujian::with(['ujianUser' => function($query) {
    $query->where('is_first', 1)->where('user_id', auth()->user()->id);
}, 'ujianUser.jawabanPeserta', 'ujianUser.jawabanPeserta.soal.jawaban'])
->findOrFail($id);

// Properly get the first item from the collection
$currentUserUjian = $ujian->ujianUser->first();

if (!$currentUserUjian) {
    abort(403, 'ERROR');
}

if ($currentUserUjian->status != '2') {
    abort(403, 'ERROR');
}
```

#### View Changes:
1. **Updated variable references** - use `$currentUserUjian` instead of `$ujian->ujianUser[0]`
2. **Consistent property access** - now accessing properties on single model instance

```php
{{ $currentUserUjian->status }}     {{-- Safe property access --}}
{{ $currentUserUjian->nilai }}      {{-- No array indexing needed --}}
```

#### Ranking Logic Fix:
```php
// Before (problematic):
$rank = $rankUser->keys()->first() + 1; // Could fail if empty

// After (safe):
$rank = $rankUser->isNotEmpty() ? $rankUser->keys()->first() + 1 : 0;
```

## Key Changes Made

### Files Modified:
1. **`app/Http/Controllers/UjianController.php`**
   - Fixed `nilai()` method logic
   - Removed incorrect `first()` from relationship query
   - Added proper collection handling
   - Improved error handling

2. **`resources/views/views_user/nilai/index.blade.php`**
   - Updated all `$ujian->ujianUser[0]` references to `$currentUserUjian`
   - Consistent property access throughout the view

### Technical Details:
- **Relationship Type**: `ujianUser()` is a `hasMany` relationship that returns a Collection
- **Solution**: Extract first item from collection using `->first()`
- **Safety**: Added null checking with `isNotEmpty()` before accessing collection items
- **Clarity**: Renamed variables for better understanding (`$currentUserUjian` vs `$ujianUser`)

## Expected Result
✅ Users can now successfully view their tryout scores without the collection property error  
✅ Proper error handling when no exam record is found  
✅ Safe ranking calculations with fallback values  
✅ Consistent code behavior across the application  

## Testing
The fix has been applied and tested. Users should now be able to:
- View their tryout scores (nilai tryout)
- See their rankings among other participants
- Access the complete exam results page without errors

This resolves the specific error mentioned: "Property [status] does not exist on this collection instance."