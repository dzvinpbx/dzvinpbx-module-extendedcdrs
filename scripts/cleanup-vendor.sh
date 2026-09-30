#!/bin/bash
# Cleanup script for vendor directory
# Removes test, documentation and example files to reduce module size

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
VENDOR_DIR="$(dirname "$SCRIPT_DIR")/vendor"

if [ ! -d "$VENDOR_DIR" ]; then
    echo "Vendor directory not found: $VENDOR_DIR"
    exit 0
fi

echo "Cleaning up vendor directory..."

# Remove tests, docs, examples from all vendor packages
echo "Removing tests and documentation..."
find "$VENDOR_DIR" -type d \( -name tests -o -name Tests -o -name test \) -exec rm -rf {} + 2>/dev/null
find "$VENDOR_DIR" -type d \( -name docs -o -name doc -o -name examples -o -name samples \) -exec rm -rf {} + 2>/dev/null

echo "Cleanup complete."
