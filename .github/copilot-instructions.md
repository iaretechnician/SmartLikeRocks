# Copilot Instructions for SmartLikeRocks Project

## Project Overview
This is a multi-project domain hosting temporary and example projects. Each project is isolated in its own subfolder with dedicated resources.

## Project Structure Rules

### Folder Organization
```
/
├── index.php                 # Main portal landing page (DO NOT MOVE)
├── nav.php                   # Global navigation (DO NOT MOVE)
├── footer.php                # Global footer (DO NOT MOVE)
├── css/                      # Shared CSS resources
├── js/                       # Shared JavaScript resources
├── img/                      # Shared images
├── fonts/                    # Shared fonts
├── assets/                   # Shared assets
├── contactform/              # Shared contact form resources
├── pure/                     # Pure Storage project folder
│   ├── index.php            # Pure project landing page
│   ├── purekb.php           # Pure knowledge base
│   ├── examprep.php         # IE Certification exam prep
│   ├── pure*.php            # All Pure-related files
│   └── ...
├── tsp/                      # TSP project folder
│   ├── index.php            # TSP project landing page
│   ├── tspkb.php            # TSP knowledge base
│   ├── tsp*.php             # All TSP-related files
│   ├── newhire.php          # TSP new hire resources
│   ├── sendlostreceipt.php  # TSP lost receipt form
│   ├── resolution/          # TSP resolution tool
│   ├── lost-receipt/        # TSP lost receipt system
│   └── tspkb/               # TSP KB resources
└── .gitignore               # Git ignore rules
```

### File Organization Rules

#### 1. **Root-Level Files** (PROTECTED - Never Move)
- `index.php` - Main portal page
- `nav.php` - Global navigation included by all pages
- `footer.php` - Global footer included by all pages
- `.htaccess`, `.user.ini`, `php.ini` - Server config files
- `robots.txt` - SEO file
- `favicon.ico`, `favicon.png` - Site icons
- `PIE.htc` - Legacy IE compatibility

#### 2. **Shared Resources** (Keep in Root)
- `/css/` - Bootstrap, style.css, responsive.css, etc.
- `/js/` - jQuery, Bootstrap JS, shared scripts
- `/img/` - Logos, icons, shared images
- `/fonts/` - Font files
- `/assets/` - Additional shared assets
- `/contactform/` - Shared contact form logic

#### 3. **Pure Storage Project Files** (Must be in `/pure/`)
**Naming patterns:**
- Files starting with `pure*` (e.g., `purekb.php`, `purebot.php`, `purevpn.php`)
- `examprep.php` - IE Certification prep (Pure-specific)
- `ie_quiz_questions.php` - Quiz questions for Pure exam
- Pure-related navigation: `purenav.php`, `purewikinav.php`

**Path References:**
- All CSS/JS/images referenced as `../css/`, `../js/`, `../img/`
- All shared includes: `../nav.php`, `../footer.php`
- Internal includes (within pure/): `purenav.php`, `purewikinav.php`

#### 4. **TSP Project Files** (Must be in `/tsp/`)
**Naming patterns:**
- Files starting with `tsp*` (e.g., `tspkb.php`, `tspnav.php`)
- `newhire.php` - TSP new hire information
- `sendlostreceipt.php` - TSP lost receipt form
- `askyourself.php` - TSP self-assessment tool

**Subfolders:**
- `resolution/` - TSP resolution tool
- `lost-receipt/` - TSP lost receipt system
- `tspkb/` - TSP knowledge base resources (PDFs, docs)

**Path References:**
- All CSS/JS/images referenced as `../css/`, `../js/`, `../img/`
- All shared includes: `../nav.php`, `../footer.php`
- Internal includes (within tsp/): `tspnav.php`

#### 5. **Files to DELETE** (Never Keep)
- Standalone HTML files not linked anywhere (`about.html`, `contact.html`, `faq.html`, `shop.html`, `onlinesystem.html`, `puresim.html`)
- WordPress-related files (`wp-*.php`) - WP was removed
- Numeric test folders (`3543/`, `156468/`) - Already removed
- Archive files (`.zip`, `.gz`) - Already removed
- Test/debug files (`dbtest.php`, `phpinfo.php`)
- Orphaned files with no references

### Code Editing Rules

#### When Creating New Files
1. **Determine Project Ownership:**
   - Is this for Pure Storage? → Place in `/pure/`
   - Is this for TSP? → Place in `/tsp/`
   - Is it shared/global? → Place in root (rare)

2. **Use Correct Path References:**
   - From subfolders to shared resources: `../css/`, `../js/`, `../img/`
   - From subfolders to global includes: `../nav.php`, `../footer.php`
   - Within same subfolder: relative `./` or just filename

3. **Follow Naming Conventions:**
   - Pure files: prefix with `pure` or clearly name (e.g., `examprep.php`)
   - TSP files: prefix with `tsp` or clearly name (e.g., `newhire.php`)

#### When Editing Existing Files
1. **Check File Location:**
   - If a project file is in root, move it to proper subfolder
   - Update all path references after moving

2. **Update References:**
   - CSS: `href="css/..."` → `href="../css/..."`
   - JS: `src="js/..."` → `src="../js/..."`
   - Images: `src="img/..."` → `src="../img/..."`
   - Includes: `include "nav.php"` → `include "../nav.php"`

3. **Maintain Project Isolation:**
   - Pure files should NOT directly reference TSP files
   - TSP files should NOT directly reference Pure files
   - Both can reference shared resources in root

#### When Adding New Projects
1. Create new subfolder in root (e.g., `/newproject/`)
2. Create `index.php` in subfolder as project landing page
3. Update root `index.php` to add project card/link
4. Update root `nav.php` if project needs global nav entry
5. Store all project files in the subfolder
6. Reference shared resources from root with `../`

### Security Rules

#### .gitignore Requirements
**Always ignore these patterns:**
```
# Secrets and credentials
dbtest.php
.env
**/dropin.config.json
pure/purebot.php
tsp/resolution/dropin.config.json

# Sensitive config
wp-config.php
php.ini (if contains secrets)

# Error logs
error_log

# Temporary/cache files
*.tmp
*.cache
.DS_Store
Thumbs.db

# Backups
*.bak
*.backup
*.old
```

#### API Keys and Secrets
- **NEVER** commit API keys, passwords, or tokens
- Store secrets in `.env` files (ignored by git)
- Use environment variables for sensitive data
- If a secret is committed, immediately:
  1. Rotate/invalidate the exposed secret
  2. Add file to `.gitignore`
  3. Remove from git history with `git-filter-repo`

### Mobile/Responsive Rules

#### Navigation on Mobile
- Mobile menu uses `.res-nav_click` hamburger button
- JavaScript (jQuery) toggles `.main-nav` visibility with `slideToggle()`
- CSS media query `@media (max-width: 767px)` handles mobile styles
- Mobile nav should be `position: relative` (not absolute) for proper layout
- Ensure touch targets are at least 44x44px

#### Mobile Testing
- Test all pages on mobile viewport (375px, 768px)
- Verify navigation works on touch devices
- Check all forms are usable on mobile
- Ensure text is readable without zooming (min 16px font)

### Git Workflow

#### Branch Strategy
- `unstable` - Main development branch (current)
- Push directly to `unstable` for ongoing work
- Use feature branches for experimental work

#### Commit Messages
- Use descriptive messages: "Add X feature" or "Fix Y issue"
- Reference project in message: "[Pure] Add exam questions" or "[TSP] Fix lost receipt form"

#### Before Committing
1. Check `.gitignore` is up to date
2. Verify no secrets in staged files
3. Test changed pages locally if possible
4. Run `git status` to review changes

### Common Maintenance Tasks

#### Adding a New Pure Feature
```bash
# Create file in pure/ folder
touch pure/new-feature.php

# Edit file with proper path references
# CSS: href="../css/style.css"
# JS: src="../js/jquery.js"
# Includes: include "../nav.php"

# Test locally then commit
git add pure/new-feature.php
git commit -m "[Pure] Add new feature"
git push origin unstable
```

#### Moving a Misplaced File
```bash
# Example: moving askyourself.php to TSP folder
git mv askyourself.php tsp/

# Update path references in the file
# Then commit
git add tsp/askyourself.php
git commit -m "[TSP] Move askyourself.php to correct folder"
git push origin unstable
```

#### Cleaning Up Unused Files
```bash
# Search for file references first
grep -r "filename.php" .

# If no references found, safe to delete
git rm filename.php
git commit -m "Remove unused file: filename.php"
git push origin unstable
```

### Performance Guidelines

- Minify CSS/JS for production (keep readable versions for dev)
- Optimize images (use WebP where supported)
- Lazy-load images below fold
- Use CDN for common libraries (jQuery, Bootstrap) when possible
- Enable gzip compression via `.htaccess`

### Accessibility Guidelines

- Use semantic HTML (`<nav>`, `<main>`, `<header>`, `<footer>`)
- Include alt text for all images
- Ensure sufficient color contrast (4.5:1 minimum)
- Make all interactive elements keyboard accessible
- Use ARIA labels where needed

---

## Quick Reference Commands

### Check for misplaced files
```bash
# Find Pure files in root
ls -1 pure*.php 2>/dev/null

# Find TSP files in root
ls -1 tsp*.php 2>/dev/null
```

### Search for file references
```bash
# Find all references to a file
grep -r "filename.php" . --include="*.php" --include="*.html"
```

### Move file and update references
```bash
# Move file
git mv oldpath/file.php newpath/

# Search and update references (manual or with sed)
sed -i 's|oldpath/file.php|newpath/file.php|g' *.php
```

---

**Last Updated:** November 12, 2025
**Maintained By:** Development Team
**Questions?** Review this file before making structural changes.
