<?php

function getUrl($filename)
{

    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $CurPageURL = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $query = $_SERVER['QUERY_STRING'];
    $baseUrl = str_replace($query, '', $CurPageURL);
    $pattern = "/" . preg_quote($filename, "/") . "\??/";
    $baseUrl = preg_replace($pattern, '', $baseUrl);
    $filters = preg_replace('/&page=\d*/', '', $query);
    $filters = preg_replace('/&delete=\d*/', '', $filters);

    return [$query, $filters, $baseUrl];
}