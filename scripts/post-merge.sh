#!/bin/bash
set -e

# Cashout Casino post-merge: clear Laravel caches so freshly merged
# blade/route/config changes are picked up by the running PHP server.

CASINO_DIR="cashout-casino/casino"

if [ -d "$CASINO_DIR" ]; then
  cd "$CASINO_DIR"

  # Best-effort cache clears — never fail the merge if a cache dir is empty.
  rm -f storage/framework/views/*.php 2>/dev/null || true
  rm -rf bootstrap/cache/*.php 2>/dev/null || true

  if [ -x "$(command -v php)" ] && [ -f artisan ]; then
    timeout 20 php artisan view:clear   2>/dev/null || true
    timeout 20 php artisan config:clear 2>/dev/null || true
    timeout 20 php artisan route:clear  2>/dev/null || true
  fi
fi

echo "post-merge: caches cleared"
