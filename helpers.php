<?php
if (!function_exists('highlight')) {
    function highlight($text, $term) {
        if (!$term) return htmlspecialchars($text);
        return preg_replace('/(' . preg_quote($term, '/') . ')/i', '<mark>$1</mark>', htmlspecialchars($text));
    }
}
