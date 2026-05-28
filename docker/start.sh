#!/bin/sh
set -eu

export APP_KEY="${APP_KEY:-$(php -r 'echo "base64:".base64_encode(random_bytes(32));')}"
export APP_URL="${APP_URL:-https://maecprojecta.onrender.com}"
export LOG_CHANNEL="${LOG_CHANNEL:-stderr}"
export DB_CONNECTION="${DB_CONNECTION:-mysql}"

if [ -z "${DB_URL:-}" ] && [ -n "${DATABASE_URL:-}" ]; then
    export DB_URL="$DATABASE_URL"
fi

if [ -z "${DB_URL:-}" ] && [ -n "${MYSQL_URL:-}" ]; then
    export DB_URL="$MYSQL_URL"
fi

if [ -z "${DB_URL:-}" ] && [ -n "${MYSQL_PUBLIC_URL:-}" ]; then
    export DB_URL="$MYSQL_PUBLIC_URL"
fi

if [ -z "${DB_HOST:-}" ] && [ -n "${MYSQLHOST:-}" ]; then
    export DB_HOST="$MYSQLHOST"
fi

if [ -z "${DB_PORT:-}" ] && [ -n "${MYSQLPORT:-}" ]; then
    export DB_PORT="$MYSQLPORT"
fi

if [ -z "${DB_DATABASE:-}" ] && [ -n "${MYSQLDATABASE:-}" ]; then
    export DB_DATABASE="$MYSQLDATABASE"
fi

if [ -z "${DB_USERNAME:-}" ] && [ -n "${MYSQLUSER:-}" ]; then
    export DB_USERNAME="$MYSQLUSER"
fi

if [ -z "${DB_PASSWORD:-}" ] && [ -n "${MYSQLPASSWORD:-}" ]; then
    export DB_PASSWORD="$MYSQLPASSWORD"
fi

if { [ -z "${DB_HOST:-}" ] || [ "${DB_HOST:-}" = "127.0.0.1" ] || [ "${DB_HOST:-}" = "localhost" ]; } && [ -n "${DB_URL:-}" ]; then
    eval "$(php -r '
        $url = getenv("DB_URL");
        $parts = parse_url($url);

        if (! is_array($parts)) {
            exit;
        }

        $scheme = $parts["scheme"] ?? "mysql";
        $connection = str_contains($scheme, "postgres") ? "pgsql" : "mysql";
        $database = isset($parts["path"]) ? ltrim($parts["path"], "/") : "";
        $values = [
            "DB_CONNECTION" => $connection,
            "DB_HOST" => $parts["host"] ?? "",
            "DB_PORT" => (string) ($parts["port"] ?? ""),
            "DB_DATABASE" => $database,
            "DB_USERNAME" => isset($parts["user"]) ? urldecode($parts["user"]) : "",
            "DB_PASSWORD" => isset($parts["pass"]) ? urldecode($parts["pass"]) : "",
        ];

        foreach ($values as $key => $value) {
            if ($value !== "") {
                echo "export ".$key."=".escapeshellarg($value).";\n";
            }
        }
    ')"
fi

if [ "${DB_CONNECTION:-mysql}" = "mysql" ] && { [ -z "${DB_HOST:-}" ] || [ -z "${DB_DATABASE:-}" ] || [ -z "${DB_USERNAME:-}" ]; }; then
    echo "Missing MySQL environment variables. Set DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, and DB_PASSWORD in Render, or connect Railway MYSQLHOST/MYSQLPORT/MYSQLDATABASE/MYSQLUSER/MYSQLPASSWORD."
fi

echo "Database runtime config: connection=${DB_CONNECTION:-missing}, host=${DB_HOST:-missing}, port=${DB_PORT:-missing}, database=${DB_DATABASE:-missing}, username=${DB_USERNAME:-missing}, db_url_set=$([ -n "${DB_URL:-}" ] && echo yes || echo no)"

set_env_value() {
    key="$1"
    value="$2"

    if grep -q "^${key}=" .env; then
        php -r '
            $file = ".env";
            $key = $argv[1];
            $value = $argv[2];
            $lines = file($file, FILE_IGNORE_NEW_LINES);

            foreach ($lines as &$line) {
                if (str_starts_with($line, $key."=")) {
                    $line = $key."=".$value;
                }
            }

            file_put_contents($file, implode(PHP_EOL, $lines).PHP_EOL);
        ' "$key" "$value"
    else
        printf '%s=%s\n' "$key" "$value" >> .env
    fi
}

set_env_value APP_KEY "${APP_KEY}"
set_env_value APP_URL "${APP_URL}"
set_env_value LOG_CHANNEL "${LOG_CHANNEL}"
set_env_value DB_CONNECTION "${DB_CONNECTION}"
set_env_value DB_HOST "${DB_HOST:-}"
set_env_value DB_PORT "${DB_PORT:-3306}"
set_env_value DB_DATABASE "${DB_DATABASE:-}"
set_env_value DB_USERNAME "${DB_USERNAME:-}"
set_env_value DB_PASSWORD "${DB_PASSWORD:-}"
set_env_value SESSION_DRIVER "${SESSION_DRIVER:-file}"
set_env_value CACHE_STORE "${CACHE_STORE:-file}"
set_env_value QUEUE_CONNECTION "${QUEUE_CONNECTION:-sync}"

php artisan config:clear
php artisan cache:clear

(
    echo "Running database migrations and admin seeder in the background..."
    php artisan migrate --force && php artisan db:seed --class=AdminUserAccountSeeder --force
) &

exec php artisan serve --host=0.0.0.0 --port="${PORT:-10000}"
