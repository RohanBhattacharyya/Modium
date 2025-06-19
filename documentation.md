# Documentation
## Scraper API
### Overview
The Unified scraper is a php-built page located in scripts/unified.php. The currently supported endpoints are name and loader (comma separated).

#### Endpoints
- `/unified.php?name=mod_name` - Searches for mods by name.
- `/unified.php?loader=loader_type, loader_type2, etc.` - Searches for mods by loader type (e.g., forge, fabric, quilt).