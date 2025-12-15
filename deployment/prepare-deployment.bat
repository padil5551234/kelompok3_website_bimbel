@echo off
REM ============================================
REM Prepare Laravel Project untuk InfinityFree
REM ============================================

echo.
echo ========================================
echo Prepare Laravel untuk InfinityFree
echo ========================================
echo.

REM Step 1: Install Dependencies
echo [1/5] Installing dependencies...
call composer install --optimize-autoloader --no-dev
if %ERRORLEVEL% NEQ 0 (
    echo ERROR: Failed to install dependencies
    pause
    exit /b 1
)
echo OK - Dependencies installed
echo.

REM Step 2: Clear existing caches
echo [2/5] Clearing existing caches...
call php artisan config:clear
call php artisan route:clear
call php artisan view:clear
call php artisan cache:clear
echo OK - Caches cleared
echo.

REM Step 3: Optimize for production
echo [3/5] Optimizing for production...
call php artisan config:cache
call php artisan route:cache
call php artisan view:cache
echo OK - Application optimized
echo.

REM Step 4: Generate application key
echo [4/5] Generating application key...
echo.
echo YOUR APPLICATION KEY:
echo ========================================
call php artisan key:generate --show
echo ========================================
echo.
echo IMPORTANT: Copy this key to .env file in InfinityFree!
echo.

REM Step 5: Export database
echo [5/5] Do you want to export database? (Y/N)
set /p EXPORT_DB=
if /i "%EXPORT_DB%"=="Y" (
    echo.
    call deployment\export-database.bat
)

echo.
echo ========================================
echo Preparation Complete!
echo ========================================
echo.
echo Next steps:
echo 1. Upload files to InfinityFree (see deployment\QUICK_START.md)
echo 2. Configure .env file with database credentials
echo 3. Import database to InfinityFree
echo 4. Set folder permissions (storage, bootstrap\cache)
echo 5. Test your website
echo.
echo Full guide: PANDUAN_UPLOAD_INFINITYFREE.md
echo Quick guide: deployment\QUICK_START.md
echo.

pause