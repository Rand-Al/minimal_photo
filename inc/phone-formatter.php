<?php
function format_phone_number($phone) {
    // Убираем все кроме цифр
    $clean = preg_replace('/[^0-9]/', '', $phone);

    // Приводим к формату 380XXXXXXXXX
    if (substr($clean, 0, 3) === '380') {
        // Уже правильный формат - ничего не делаем
    } elseif (substr($clean, 0, 2) === '80') {
        // 80XXXXXXXXX -> 380XXXXXXXXX
        $clean = '3' . $clean;
    } elseif (substr($clean, 0, 1) === '0') {
        // 0XXXXXXXXX -> 380XXXXXXXXX  
        $clean = '38' . $clean;
    } else {
        // Неизвестный формат - возвращаем как есть
        return $phone;
    }

    // Проверяем длину (должно быть 12 цифр)
    if (strlen($clean) !== 12) {
        return $phone;
    }

    // Форматируем как +38-XXX-XXX-XX-XX
    return '+' . substr($clean, 0, 2) . '-' .
        substr($clean, 2, 3) . '-' .
        substr($clean, 5, 3) . '-' .
        substr($clean, 8, 2) . '-' .
        substr($clean, 10, 2);
}
