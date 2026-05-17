#!/usr/bin/env bash
# =============================================================================
# NusaLumbung — Deploy Script
# =============================================================================
# Jalankan script ini di server production setelah git pull/clone.
#
# Usage:
#   chmod +x deploy.sh
#   ./deploy.sh            # deploy biasa
#   ./deploy.sh --seed     # deploy + seed database
#   ./deploy.sh --fresh    # deploy + fresh migrate + seed (HAPUS SEMUA DATA!)
# =============================================================================

set -euo pipefail

# Warna output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
CYAN='\033[0;36m'
NC='\033[0m'

log()  { echo -e "${CYAN}[DEPLOY]${NC} $1"; }
ok()   { echo -e "${GREEN}[  OK  ]${NC} $1"; }
warn() { echo -e "${YELLOW}[ WARN ]${NC} $1"; }
err()  { echo -e "${RED}[ERROR ]${NC} $1"; exit 1; }

SEED=false
FRESH=false

for arg in "$@"; do
    case $arg in
        --seed)  SEED=true ;;
        --fresh) FRESH=true; SEED=true ;;
        *)       err "Unknown option: $arg" ;;
    esac
done

# ─────────────────────────────────────────────
# 1. Pre-flight checks
# ─────────────────────────────────────────────
log "Pre-flight checks..."

[ ! -f ".env" ] && err ".env file not found! Copy .env.production ke .env terlebih dahulu."

if grep -q "APP_DEBUG=true" .env; then
    err "APP_DEBUG=true terdeteksi di .env! Set ke false untuk production."
fi

if grep -q "APP_ENV=local" .env; then
    warn "APP_ENV=local terdeteksi. Pastikan ini memang diinginkan."
fi

if grep -q "APP_KEY=$" .env || grep -q "APP_KEY=<" .env; then
    warn "APP_KEY belum di-set. Generating..."
    php artisan key:generate --force
    ok "APP_KEY generated"
fi

ok "Pre-flight checks passed"

# ─────────────────────────────────────────────
# 2. Install dependencies
# ─────────────────────────────────────────────
log "Installing PHP dependencies (production)..."
composer install --no-dev --optimize-autoloader --no-interaction
ok "Composer dependencies installed"

# ─────────────────────────────────────────────
# 3. Build frontend assets
# ─────────────────────────────────────────────
log "Installing Node dependencies & building assets..."
npm ci --ignore-scripts
npm run build
ok "Frontend assets built"

# ─────────────────────────────────────────────
# 4. Database migration
# ─────────────────────────────────────────────
if [ "$FRESH" = true ]; then
    warn "Running fresh migration + seed (ALL DATA WILL BE LOST)..."
    php artisan migrate:fresh --seed --force
    ok "Fresh migration + seed completed"
elif [ "$SEED" = true ]; then
    log "Running migration + seed..."
    php artisan migrate --force
    php artisan db:seed --force
    ok "Migration + seed completed"
else
    log "Running migration..."
    php artisan migrate --force
    ok "Migration completed"
fi

# ─────────────────────────────────────────────
# 5. Storage link
# ─────────────────────────────────────────────
log "Creating storage link..."
php artisan storage:link 2>/dev/null || warn "Storage link already exists"
ok "Storage link ready"

# ─────────────────────────────────────────────
# 6. Cache optimization
# ─────────────────────────────────────────────
log "Caching configuration, routes, and views..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
ok "All caches built"

# ─────────────────────────────────────────────
# 7. Restart queue workers (if any)
# ─────────────────────────────────────────────
log "Restarting queue workers..."
php artisan queue:restart
ok "Queue restart signal sent"

# ─────────────────────────────────────────────
# Done!
# ─────────────────────────────────────────────
echo ""
echo -e "${GREEN}══════════════════════════════════════════${NC}"
echo -e "${GREEN}  ✅ Deploy NusaLumbung selesai!${NC}"
echo -e "${GREEN}══════════════════════════════════════════${NC}"
echo ""
echo -e "  ${CYAN}Checklist:${NC}"
echo -e "  • Pastikan Cloudflare Tunnel sudah berjalan"
echo -e "  • Pastikan web server (php artisan serve / Nginx) running"
echo -e "  • Cek health: curl https://your-domain.com/up"
echo ""
