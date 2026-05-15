# Portfolio Laravel - Complete GitHub & Render Deployment Guide

## STEP 1: INSTALL GIT ON YOUR WINDOWS MACHINE

### Option A: Download and Install Git Bash (Recommended)
1. Go to: https://git-scm.com/download/win
2. Download the latest Git installer
3. Run the installer and accept defaults
4. Restart your terminal/PowerShell after installation

### Option B: Use Windows Package Manager (if available)
```powershell
winget install Git.Git
```

---

## STEP 2: CONNECT YOUR LOCAL PROJECT TO GITHUB

### 2.1 Initialize Git Repository Locally
```powershell
cd "c:\Users\linko\OneDrive\Desktop\Portfolio-main\Portfolio-main"
git config --global user.name "Your Name"
git config --global user.email "your.email@example.com"
git init
git add .
git commit -m "Initial commit: Portfolio Laravel application"
```

### 2.2 Connect to GitHub Remote
```powershell
# Replace YOUR_USERNAME and REPO_NAME with your actual GitHub details
git remote add origin https://github.com/Pk3023/Portfolio.git
git branch -M main
git push -u origin main
```

**If you get authentication error:**
- Use GitHub Personal Access Token instead:
  1. Go to GitHub Settings → Developer settings → Personal access tokens
  2. Create a new token with `repo` scope
  3. Use this command:
  ```powershell
  git remote set-url origin https://YOUR_TOKEN@github.com/Pk3023/Portfolio.git
  git push -u origin main
  ```

---

## STEP 3: PREPARE LARAVEL FOR PRODUCTION

### 3.1 Update .env for Production
Your `.env.production` file is already created. When deploying, make sure:
- `APP_DEBUG=false`
- `APP_ENV=production`
- `APP_KEY` is set (already done)

### 3.2 Create necessary Laravel cache/storage directories
```powershell
mkdir storage/app/public -ErrorAction SilentlyContinue
mkdir bootstrap/cache -ErrorAction SilentlyContinue
attrib -R bootstrap/cache
```

---

## STEP 4: PUSH ALL CHANGES TO GITHUB

After creating new files (Procfile, render.yaml, .env.production):
```powershell
git add .
git commit -m "Add deployment configuration for Render"
git push origin main
```

---

## STEP 5: SET UP RENDER DEPLOYMENT

### 5.1 Go to Render Dashboard
1. Visit: https://dashboard.render.com
2. Sign up or log in with GitHub
3. Click "New +" → "Web Service"

### 5.2 Connect GitHub Repository
1. Select "Build and deploy from a Git repository"
2. Click "Connect account" under GitHub
3. Authorize Render to access your GitHub
4. Search for and select: `Pk3023/Portfolio`
5. Click "Connect"

### 5.3 Configure Web Service Settings
```
Name: portfolio
Environment: PHP
Region: Choose closest to you (e.g., US East)
Plan: Free
Build Command: composer install && php artisan cache:clear && php artisan config:cache
Start Command: php artisan serve --host=0.0.0.0 --port=$PORT
```

### 5.4 Add Environment Variables in Render Dashboard
Click "Add Environment Variable" and add these:

```
APP_NAME = Portfolio
APP_ENV = production
APP_DEBUG = false
APP_KEY = base64:dUVI4Ka1z9MqUzyy+UGB5t3+KtlnbU0QXUgFlm/VQjA=
LOG_CHANNEL = single
DB_CONNECTION = mysql
DB_HOST = (leave empty, will configure MySQL service)
DB_PORT = 3306
DB_DATABASE = portfolio_prod
DB_USERNAME = portfolio_user
DB_PASSWORD = (set a strong password)
SESSION_DRIVER = file
QUEUE_CONNECTION = sync
CACHE_DRIVER = file
FILESYSTEM_DISK = local
```

### 5.5 Create MySQL Database Service (FREE TIER)
Unfortunately, Render free tier requires external MySQL. Use:
- **Option A:** Render's managed PostgreSQL (easier)
- **Option B:** External MySQL like:
  - ClearDB MySQL
  - AWS RDS Free Tier
  - Planetscale (MySQL compatible)

**For ClearDB (Recommended for free tier):**
1. Get MySQL URL from ClearDB
2. Add to Render environment variables:
   ```
   DATABASE_URL = mysql://user:password@host/database
   ```

### 5.6 Click "Deploy" Button
- Render will automatically:
  - Download your code from GitHub
  - Install Composer packages
  - Run cache:clear, config:cache, route:cache
  - Start the Laravel app
  - Assign a public URL

---

## STEP 6: RUN MIGRATIONS ON RENDER

Once deployment is successful:

### Option 1: Using Render Shell
1. Go to your Render service dashboard
2. Click "Shell" tab
3. Run:
   ```bash
   php artisan migrate --force
   php artisan db:seed --force
   ```

### Option 2: Add to Build Command
Modify your `render.yaml` or build command to include migrations automatically:
```
php artisan migrate --force
```

---

## STEP 7: TROUBLESHOOTING COMMON RENDER DEPLOYMENT ISSUES

### Issue 1: "No application encryption key has been specified"
**Fix:** Ensure `APP_KEY` is set in environment variables

### Issue 2: "SQLSTATE database connection error"
**Fix:** 
- Verify MySQL credentials in environment variables
- Check DB_HOST, DB_USERNAME, DB_PASSWORD are correct
- Ensure migrations ran successfully

### Issue 3: "Permission denied storage directory"
**Fix:** Add to render.yaml startCommand:
```bash
chmod -R 755 storage bootstrap/cache
php artisan serve --host=0.0.0.0 --port=$PORT
```

### Issue 4: "Route caching issues"
**Solution:** Clear all caches on deploy:
```bash
php artisan route:clear && php artisan config:clear && php artisan cache:clear
```

---

## STEP 8: DEPLOY UPDATES LATER

After making changes locally:
```powershell
git add .
git commit -m "Your commit message"
git push origin main
```

Render will automatically redeploy your application!

---

## FINAL CHECKLIST BEFORE DEPLOYMENT

- [ ] Git initialized locally
- [ ] Remote added: `git remote -v` shows origin
- [ ] All files pushed to GitHub: `git log` shows commits
- [ ] Render account created and GitHub connected
- [ ] Web service created in Render
- [ ] All environment variables added
- [ ] MySQL database configured (internal or external)
- [ ] Build command includes migrations
- [ ] Start command is set correctly
- [ ] Deploy successful (check Render logs)
- [ ] Database migrations completed
- [ ] Access your public URL and test

---

## YOUR FINAL PUBLIC URL WILL BE:
```
https://portfolio-xxxxx.onrender.com
```

All users can access your portfolio website from this link!

---

## QUICK COMMAND REFERENCE

```powershell
# After Git is installed, run these commands in order:

# 1. Configure Git
git config --global user.name "Your Name"
git config --global user.email "your@email.com"

# 2. Initialize repo
cd "c:\Users\linko\OneDrive\Desktop\Portfolio-main\Portfolio-main"
git init

# 3. Add files
git add .

# 4. Create commit
git commit -m "Initial commit: Portfolio Laravel application"

# 5. Add GitHub remote
git remote add origin https://github.com/Pk3023/Portfolio.git

# 6. Push to GitHub
git branch -M main
git push -u origin main

# 7. For future updates
git add .
git commit -m "Update message"
git push origin main
```

---

**Need Help?**
- Laravel Docs: https://laravel.com/docs
- Render Docs: https://render.com/docs
- GitHub Docs: https://docs.github.com
