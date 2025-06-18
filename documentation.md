# Documentation
## CurseForge Scraper API
### Overview
The CurseForge scraper is a php-built page located in scripts/curseforge.php. The currently supported endpoints are name and loader (comma separated).

#### Endpoints
- `/curseforge.php?name=mod_name` - Searches for mods by name.
- `/curseforge.php?loader=loader_type, loader_type2, etc.` - Searches for mods by loader type (e.g., forge, fabric, quilt).