#!/bin/bash

mkdir -p /var/_swap_
cd /var/_swap_
dd if=/dev/zero of=swapfile bs=1M count=2000
mkswap swapfile
swapon swapfile
chmod 600 swapfile
echo "/var/_swap_/swapfile none swap sw 0 0" >> /etc/fstab
free -m
