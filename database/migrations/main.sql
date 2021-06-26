DROP TABLE IF EXISTS `pair`;

CREATE TABLE `pair` (
        `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `source` VARCHAR(64) NOT NULL,
        `symbol_id` VARCHAR(64) NOT NULL UNIQUE,
        `symbol` VARCHAR(64) NOT NULL,
        `base_currency` VARCHAR(64) NOT NULL,
        `traded_currency` VARCHAR(64) NOT NULL,
        `traded_currency_unit` VARCHAR(64) NOT NULL,
        `description` VARCHAR(100) NOT NULL,
        `ticker_id` VARCHAR(64) NOT NULL,
        `volume_precision` SMALLINT UNSIGNED NOT NULL DEFAULT 0,
        `price_precision` INT UNSIGNED NOT NULL DEFAULT 0,
        `price_round` INT UNSIGNED NOT NULL DEFAULT 0,
        `pricescale` SMALLINT UNSIGNED NOT NULL DEFAULT 1,
        `trade_min_base_currency` SMALLINT UNSIGNED NOT NULL,
        `trade_min_traded_currency` DECIMAL(30, 10) NOT NULL,
        `has_memo` TINYINT NOT NULL DEFAULT 0,
        `memo_name` VARCHAR(255),
        `trade_fee_percent` FLOAT NOT NULL DEFAULT 0,
        `url_logo` VARCHAR(128) NOT NULL,
        `url_logo_png` VARCHAR(128) NOT NULL,
        `is_maintenance` TINYINT,
        `old_ticker_id` VARCHAR(24)
);

DROP TABLE IF EXISTS `ticker`;

CREATE TABLE `ticker` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `high` DECIMAL(30, 10) NOT NULL,
    `low` DECIMAL(30, 10) NOT NULL,
    `vol_left` DECIMAL(30, 10) NOT NULL,
    `vol_right` DECIMAL(30, 10) NOT NULL,
    `last` DECIMAL(30, 10) NOT NULL,
    `buy` DECIMAL(30, 10) NOT NULL,
    `sell` DECIMAL(30, 10) NOT NULL
);

DROP TABLE IF EXISTS `watch_list`;

CREATE TABLE `watch_list` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    `pair_id` INT UNSIGNED NOT NULL UNIQUE,
    `source` VARCHAR(64) NOT NULL
);