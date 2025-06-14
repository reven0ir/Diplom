<?php

define("ROOT", dirname(__DIR__));
const DEBUG = 1;
const ERROR_LOG_FILE = ROOT . '/tmp/error.log';
const WWW = ROOT . '/public';
const UPLOADS = WWW . '/uploads';
const APP = ROOT . '/app';
const CORE = ROOT . '/core';
const HELPERS = ROOT . '/helpers';
const CONFIG = ROOT . '/config';
const VIEWS = APP . '/Views';
const CACHE = ROOT . '/tmp/cache';
const LAYOUT = 'default';
const PATH = 'https://Test';
const USER_AVATAR = PATH . '/images/avatar.png';
const LOGIN_PAGE = PATH . '/login';

const DB = [
    'host' => 'MariaDB-11.7',
    'dbname' => 'zenblog',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ],
];

const EMAIL = [
    'host' => 'sandbox.smtp.mailtrap.io',
    'auth' => true,
    'username' => '851414cc03c80e',
    'password' => '91de611eb0901d',
    'secure' => 'tls', // ssl
    'port' => 587, // 25, 465, 2525
    'from_email' => '722d9f4dad-61c669@inbox.mailtrap.io',
    'is_html' => true,
    'charset' => 'UTF-8',
    'debug' => 0,
];
