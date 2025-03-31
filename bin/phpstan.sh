#!/bin/bash
APP_DEBUG=1 bin/console cache:warm -etest
vendor/bin/phpstan clear-result-cache -c phpstan.neon
vendor/bin/phpstan analyse --memory-limit 2048M -c phpstan.neon $@