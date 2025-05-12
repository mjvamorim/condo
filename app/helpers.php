<?php

if (! function_exists('money_format')) {
  function money_format($format, $number){
    if (class_exists('NumberFormatter')) {
        $fmt = new NumberFormatter('pt_BR', NumberFormatter::CURRENCY);
        return $fmt->formatCurrency($number, 'BRL');
    } else {
        return sprintf($format, $number);
    }
  }
}