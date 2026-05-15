# 🚀 COMPLETE GITHUB & RENDER DEPLOYMENT GUIDE

## Phase 1: Install Git (Required First)

### Download & Install Git
1. **Go to:** https://git-scm.com/download/win
2. **Click** the large download button (Windows Standalone Installer)
3. **Run** the installer executable
4. **Follow the installation wizard** (accept all default settings)
5. **IMPORTANT:** After installation, **completely close** and **restart** PowerShell/Terminal
6. **Verify installation:**
   ```powershell
   git --version
   ```
   You should see: `git version 2.x.x...`

**⚠️ If git command still not found after restart, try:**
   ```powershell
   $env:Path += ";C:\Program Files\Git\cmd"
   git --version
   ```

---

## Phase 2: Initialize Git Repository Locally

### Run These Commands in PowerShell (In Order)

```powershell
# Navigate to your project
cd "c:\Users\linko\OneDrive\Desktop\Portfolio-main\Portfolio-main"

# Verify you're in the right directory (should show your Laravel files)
ls

# Configure Git (one-time setup)
git config --global user.name "Your Name"
git config --global user.email "your.email@gmail.com"

# Initialize git repository
git init

# Add all files to git
git add .

# Create first commit
git commit -m "Initial commit: Portfolio Laravel application"

# Verify files are staged
git log
```

---

## Phase 3: Connect to GitHub Repository

### Option A: Using HTTPS (Recommended for Beginners)

```powershell
# Add your GitHub repository as remote
git remote add origin https://github.com/Pk3023/Portfolio.git

# Set main branch
git branch -M main

# Push to GitHub
git push -u origin main
```

**If authentication popup appears:**
- Log in with your GitHub credentials
- Click "Authorize"

### Option B: Using Personal Access Token (If HTTPS fails)

1. **Generate GitHub Token:**
   - Go to: https://github.com/settings/tokens
   - Click "Generate new token"
   - Select scopes: `repo` (full control of private repositories)
   - Click "Generate token"
   - **Copy the token** (save it somewhere)

2. **Use the token:**
   ```powershell
   git remote set-url origin https://YOUR_TOKEN@github.com/Pk3023/Portfolio.git
   git push -u origin main
   ```

---

## Phase 4: Verify Files on GitHub

1. **Go to:** https://github.com/Pk3023/Portfolio
2. **Check** that all files appear:
   - ✅ `Procfile`
   - ✅ `render.yaml`
   - ✅ `.env.production`
   - ✅ `GITHUB_RENDER_DEPLOYMENT.md`
   - ✅ `laravel/` folders
   - ✅ `public/`, `resources/`, `routes/`, `app/` etc.

3. **If files are missing:** Run `git push origin main` again

---

## Phase 5: Create Render Account & Deploy

### Step 1: Create Render Account
1. **Go to:** https://dashboard.render.com
2. **Click** "Sign up"
3. **Choose** "Sign up with GitHub"
4. **Click** "Authorize render-oss"
5. **Verify email** (check your email inbox)

### Step 2: Create Web Service in Render

1. **Dashboard → Click** "New +" (top right)
2. **Select** "Web Service"
3. **Under "Public Git Repository"**, connect your GitHub:
   - Click "Connect account" next to GitHub
   - Grant permissions (click "Authorize Render")
   - Search for: `Portfolio`
   - **Click on** `Pk3023/Portfolio`
   - **Click** "Connect"

### Step 3: Configure Web Service Settings

**Fill in these exact values:**

```
Service Name:     portfolio
Environment:      PHP
Region:           (choose closest to you, e.g., "US East (Ohio)")
Branch:           main
Build Command:    composer install && php artisan config:cache && php artisan route:cache && php artisan view:cache
Start Command:    vendor/bin/heroku-php-nginx public/
Plan:             Free
```

### Step 4: Add Environment Variables

**Click "Add Environment Variable" for EACH of these:**

| Key | Value |
|-----|-------|
| APP_NAME | Portfolio |
| APP_ENV | production |
| APP_KEY | base64:dUVI4Ka1z9MqUzyy+UGB5t3+KtlnbU0QXUgFlm/VQjA= |
| APP_DEBUG | false |
| LOG_CHANNEL | single |
| CACHE_DRIVER | file |
| SESSION_DRIVER | file |
| QUEUE_CONNECTION | sync |
| DB_CONNECTION | sqlite |

### Step 5: Deploy

1. **Click** "Create Web Service" (blue button at bottom)
2. **Wait** for deployment (1-3 minutes)
3. **Status should show** "Live"
4. **Your public URL appears at top** like: `https://portfolio-xxxxx.onrender.com`

---

## Phase 6: Run Database Migrations

### Method 1: Using Render Shell (Recommended)

1. **Go to your Render service dashboard**
2. **Click** "Shell" tab (top right)
3. **Run these commands:**
   ```bash
   php artisan migrate --force
   php artisan db:seed --force
   ```
4. **If successful**, you'll see migration output

### Method 2: Add to Build Command (Auto-migration)

1. **Go back to service settings**
2. **Edit Build Command** to include:
   ```
   composer install && php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan migrate --force
   ```
3. **Click** "Save"
4. **Click** "Manual Deploy" → "Deploy latest commit"

---

## Phase 7: Test Your Live Website

1. **Copy your Render URL** (from dashboard):
   ```
   https://portfolio-xxxxx.onrender.com
   ```

2. **Open in browser** and test:
   - ✅ Homepage loads
   - ✅ Projects display
   - ✅ Contact form works
   - ✅ All navigation links work
   - ✅ Images load correctly

3. **Share this link** with anyone - they can access your portfolio!

---

## Phase 8: Fix Common Deployment Issues

### Issue 1: "Application error - error code H13"
**Solution:**
```bash
# In Render Shell:
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

### Issue 2: "SQLSTATE[HY000] [2002]" (Database connection error)
**This is NORMAL for SQLite** - it auto-creates. Just access the site once.

### Issue 3: "Composer install failed"
**Solution:**
1. Delete `composer.lock` locally
2. Run: `composer install`
3. Push to GitHub: `git add . && git commit -m "Update composer" && git push`
4. In Render: Click "Manual Deploy"

### Issue 4: "Storage path not writable"
**Solution:** Add this to Build Command:
```
chmod -R 755 storage bootstrap/cache
```

### Issue 5: "502 Bad Gateway"
**Check Render logs:**
1. Click service → "Logs" tab
2. Read error messages
3. Run: `php artisan optimize`
4. Redeploy

---

## Phase 9: Make Future Updates

### Updating Your Website

After making changes locally:

```powershell
# In your project directory
cd "c:\Users\linko\OneDrive\Desktop\Portfolio-main\Portfolio-main"

# Check changes
git status

# Stage changes
git add .

# Create commit with description
git commit -m "Description of changes"

# Push to GitHub
git push origin main
```

**That's it!** Render automatically redeploys within 1-2 minutes.

---

## Phase 10: Share Your Portfolio

**Your public website link is:**
```
https://portfolio-xxxxx.onrender.com
```

### Share with:
- 📧 Email to friends
- 💼 LinkedIn profile
- 📱 Social media
- 🔗 Resume/CV
- 💬 Job applications

**Anyone with the link can view your portfolio 24/7!**

---

## Complete Command Reference

### Full Git & Deployment Commands (Copy-Paste Ready)

```powershell
# === SETUP (Run once) ===
cd "c:\Users\linko\OneDrive\Desktop\Portfolio-main\Portfolio-main"
git config --global user.name "Your Name"
git config --global user.email "your.email@gmail.com"
git init
git add .
git commit -m "Initial commit: Portfolio Laravel application"
git remote add origin https://github.com/Pk3023/Portfolio.git
git branch -M main
git push -u origin main

# === UPDATE WEBSITE (Run whenever you make changes) ===
git add .
git commit -m "Your update description"
git push origin main
```

---

## Final Deployment Checklist

- [ ] Git installed and working (`git --version` shows version)
- [ ] Git repository initialized locally
- [ ] All files added and committed
- [ ] Remote added: `git remote -v` shows origin
- [ ] Code pushed to GitHub: Repository shows all files
- [ ] Render account created
- [ ] Web Service created and connected to GitHub
- [ ] Build Command set: `composer install && php artisan config:cache && php artisan route:cache && php artisan view:cache`
- [ ] Start Command set: `vendor/bin/heroku-php-nginx public/`
- [ ] All environment variables added
- [ ] Deployment successful (status shows "Live")
- [ ] Migrations ran successfully (checked with Shell)
- [ ] Public URL works in browser
- [ ] All website features tested (home, projects, contact)
- [ ] URL shared and ready for use

---

## Your Live Website Details

| Item | Value |
|------|-------|
| **Public URL** | `https://portfolio-xxxxx.onrender.com` |
| **Accessible by** | Anyone worldwide |
| **Available 24/7** | Yes (unless Render free tier sleeps) |
| **Update method** | `git push origin main` |
| **Deployment time** | 1-3 minutes per push |

---

## Still Having Issues?

1. **Check Render Logs:**
   - Service Dashboard → "Logs" tab
   - Read error messages

2. **Retest Locally First:**
   - Ensure `http://127.0.0.1:8000` works
   - Run: `php artisan serve`

3. **Manual Redeploy:**
   - Service Dashboard → "Manual Deploy" → "Deploy latest commit"

4. **Full Reset (if needed):**
   ```powershell
   git reset --hard HEAD
   git clean -fd
   ```

---

**🎉 Your portfolio is now LIVE and PUBLIC!**

Share your URL: `https://portfolio-xxxxx.onrender.com`

