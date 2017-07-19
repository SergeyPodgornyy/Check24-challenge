<?php

function isLogedIn() {
    return isset($_SESSION['UserId']);
}

function isAdmin() {
    return isLogedIn() && $_SESSION['UserRole'] === 'admin';
}

function isSuperAdmin() {
    return isLogedIn() && $_SESSION['UserRole'] === 'superadmin';
}

function isLangSet() {
    return isset($_SESSION['Lang']) ? true : false;
}

function getLanguage() {
    return isset($_SESSION['Lang']) ? $_SESSION['Lang'] : null;
}

function strLimit($value, $limit = 100, $end = '...') {
    if (mb_strwidth($value, 'UTF-8') <= $limit) {
        return $value;
    }

    return rtrim(mb_strimwidth($value, 0, $limit, '', 'UTF-8')).$end;
}
