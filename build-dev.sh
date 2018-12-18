#!/usr/bin/env bash
set -euf -o pipefail

composer install
yarn install
#yarn run build
yarn run encore dev
#tar -czf pmbridge-web-dev.tar.gz bin/ src/ config/ templates/ vendor/ public/

