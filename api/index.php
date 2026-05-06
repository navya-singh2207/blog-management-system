<?php

// Vercel PHP entrypoint (repo root).
// Forwards all requests to Laravel located in ./laravel-app

require __DIR__ . '/../laravel-app/public/index.php';

