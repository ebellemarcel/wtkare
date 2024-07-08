#!/bin/bash
# Synchronize the filesystem
sudo sync

# Clear PageCache only
sudo sh -c "echo 1 > /proc/sys/vm/drop_caches"

# Clear dentries and inodes
sudo sh -c "echo 2 > /proc/sys/vm/drop_caches"

# Clear PageCache, dentries, and inodes
sudo sh -c "echo 3 > /proc/sys/vm/drop_caches"

echo "Caches have been cleared."

