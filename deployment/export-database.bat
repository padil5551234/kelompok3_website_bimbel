@echo off
REM ============================================
REM Export Database untuk Upload ke InfinityFree
REM ============================================

echo.
echo ========================================
echo Export Database untuk InfinityFree
echo ========================================
echo.

REM Baca konfigurasi dari .env
for /f "tokens=1,2 delims==" %%a in ('type .env ^| findstr /i "DB_"') do (
    if "%%a"=="DB_DATABASE" set DB_NAME=%%b
    if "%%a"=="DB_USERNAME" set DB_USER=%%b
    if "%%a"=="DB_PASSWORD" set DB_PASS=%%b
)

REM Bersihkan spasi
set DB_NAME=%DB_NAME: =%
set DB_USER=%DB_USER: =%
set DB_PASS=%DB_PASS: =%

echo Database: %DB_NAME%
echo Username: %DB_USER%
echo.

REM Buat nama file dengan timestamp
for /f "tokens=2 delims==" %%I in ('wmic os get localdatetime /value') do set datetime=%%I
set TIMESTAMP=%datetime:~0,8%_%datetime:~8,6%
set FILENAME=database_backup_%TIMESTAMP%.sql

echo Exporting database...
echo Output file: %FILENAME%
echo.

REM Export database
mysqldump -u %DB_USER% -p%DB_PASS% %DB_NAME% > deployment\%FILENAME%

if %ERRORLEVEL% EQU 0 (
    echo.
    echo ========================================
    echo SUCCESS! Database exported
    echo ========================================
    echo File: deployment\%FILENAME%
    echo.
    echo Next steps:
    echo 1. Login ke phpMyAdmin di InfinityFree cPanel
    echo 2. Select your database
    echo 3. Click Import tab
    echo 4. Choose file: deployment\%FILENAME%
    echo 5. Click Go
    echo.
) else (
    echo.
    echo ========================================
    echo ERROR! Failed to export database
    echo ========================================
    echo.
    echo Possible issues:
    echo - MySQL not in PATH
    echo - Wrong database credentials
    echo - Database not running
    echo.
    echo Try manual export:
    echo mysqldump -u %DB_USER% -p %DB_NAME% ^> deployment\%FILENAME%
    echo.
)

pause