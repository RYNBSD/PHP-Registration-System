<?php

require_once __DIR__ . "/../util/dotenv.php";

DotEnv::init(__DIR__ . "/../.env");

define("DEBUG", $_ENV["DEBUG"] === "true");

define("APP_URL", $_ENV["APP_URL"]);

define("CIPHER_METHOD", $_ENV["CIPHER_METHOD"]);
define("CIPHER_KEY", $_ENV["CIPHER_KEY"]);
define("CIPHER_IV", $_ENV["CIPHER_IV"]);


define("DB_TYPE", $_ENV["DB_TYPE"]);
define("DB_HOST", $_ENV["DB_HOST"]);
define("DB_NAME", $_ENV["DB_NAME"]);
define("DB_USER", $_ENV["DB_USER"]);
define("DB_PASSWORD", $_ENV["DB_PASSWORD"]);
