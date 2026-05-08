@echo off
title NusaLumbung Dev Server

:: Set PATH
set PATH=C:\Users\Ranath RR\.config\herd\bin;C:\Program Files\nodejs;%PATH%

:: Jalankan Vite di background
start "Vite" cmd /k "cd /d "C:\Users\Ranath RR\NusaLumbung-project" && npm run dev"

:: Tunggu Vite siap
timeout /t 3 /nobreak

:: Jalankan PHP Server
start "PHP Server" cmd /k "cd /d "C:\Users\Ranath RR\NusaLumbung-project" && php -d max_execution_time=300 -S 127.0.0.1:8000 -t public"

:: Buka browser
timeout /t 2 /nobreak
start https://nusalumbung-project.test

echo.
echo Server sudah running!
echo Buka browser: https://nusalumbung-project.test
pause