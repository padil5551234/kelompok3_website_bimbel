# Chapter Deletion Issue - Root Cause & Fix

## Problem Analysis

### Issue Description
"When I delete 1 chapter, it appears again" - Chapter deletion is not working properly.

### Root Cause
**Index Mismatch Between Form and Database**

1. **Form Indices vs Chapter Numbers**: 
   - JavaScript menggunakan form indices (0, 1, 2, etc.) untuk chapter yang terlihat di form
   - Database menyimpan chapter numbers yang mungkin berbeda setelah beberapa operasi
   - Controller PHP mengasumsikan `chapter_number = form_index + 1` - ini SALAH!

2. **Scenario yang bermasalah**:
   ```
   Database state: Chapter 1, Chapter 2, Chapter 3
   User menghapus Chapter 2 dari form
   Form dikirim dengan: Chapter 0 (Chapter 1), Chapter 1 (Chapter 3)
   
   BUG: Controller mencari chapter_number = 2 (1+1) untuk index 1
   TAPI yang seharusnya dihapus adalah chapter_number = 3 (Chapter 3)
   HASIL: Chapter 2 tidak terhapus, Chapter 3 yang seharusnya stay malah terhapus!
   ```

3. **Current Logic di IntegratedCourseController.php (line 143)**:
   ```php
   $chapterMaterials = $existingMaterials->where('chapter_number', $chapterIndex + 1);
   ```
   ❌ SALAH! Tidak mempertimbangkan bahwa chapter numbers bisa berubah

## Solution

### Fix Required: Proper Chapter Number Mapping

1. **Extract actual chapter numbers from existing materials**
2. **Map form indices to actual chapter numbers**
3. **Use correct chapter numbers for deletion**

### Implementation Steps

1. **Modify JavaScript** - tambahkan chapter number info ke form
2. **Fix PHP Controller** - gunakan actual chapter numbers untuk deletion
3. **Add validation** - pastikan deletion targeting tepat

## Expected Behavior After Fix

```
User Scenario:
- Has chapters: Chapter 1 (5 materials), Chapter 2 (3 materials), Chapter 3 (2 materials)
- Deletes Chapter 2 via form
- Form sends: Chapter 0 (Chapter 1), Chapter 1 (Chapter 3 dengan chapter_number=3)

Correct Processing:
- Chapter index 0 → chapter_number 1 (keep)
- Chapter index 1 → chapter_number 3 (keep)
- Chapter index yang marked for deletion → gunakan chapter_number yang sesuai

Result: Only Chapter 2 materials yang terhapus
```

## Files to Fix

1. `resources/views/admin/integrated-course-form.blade.php` - Add chapter number to form
2. `app/Http/Controllers/Admin/IntegratedCourseController.php` - Fix deletion logic