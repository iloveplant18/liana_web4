<?php

namespace App\Utils;

class CustomFormValidation extends FormValidation
{
    // Validate that the name contains exactly three words separated by spaces
    public function isName($data)
    {
        if (!preg_match('/^[a-zA-Zа-яА-ЯёЁ]+ [a-zA-Zа-яА-ЯёЁ]+ [a-zA-Zа-яА-ЯёЁ]+$/u', $data)) {
            return "Имя должно содержать три слова, состоящих только из букв, разделенных пробелами.";
        }
        return null;
    }
}