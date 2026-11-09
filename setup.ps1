$ErrorActionPreference = "Stop"
Set-Location $PSScriptRoot
function Check-Exit { if ($LASTEXITCODE -ne 0) { throw "Command failed. Check the error above." } }
if (!(Get-Command php -ErrorAction SilentlyContinue)) { throw "Install PHP 8.2 or newer and reopen VS Code." }
if (!(Get-Command composer -ErrorAction SilentlyContinue)) { throw "Install Composer and reopen VS Code." }
$modules = php -m
foreach ($module in @('gd', 'pdo_sqlite', 'mbstring', 'fileinfo', 'openssl', 'dom')) {
    if ($modules -notcontains $module) { throw "PHP extension $module is missing. Enable it in the php.ini shown by php --ini, then rerun setup." }
}
composer install --prefer-dist --no-interaction
Check-Exit
if (!(Test-Path .env)) { Copy-Item .env.example .env }
if (!(Test-Path database/database.sqlite)) { New-Item database/database.sqlite -ItemType File | Out-Null }
if (!(Select-String -Path .env -Pattern '^APP_KEY=base64:' -Quiet)) { php artisan key:generate; Check-Exit }
php artisan migrate --seed
Check-Exit
if (!(Test-Path public/storage)) { php artisan storage:link; Check-Exit }
Write-Host "Ready. Run: php artisan serve"
