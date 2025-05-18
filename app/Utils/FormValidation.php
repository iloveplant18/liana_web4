<?php

namespace App\Utils;

class FormValidation
{
    protected $rules = []; // Array to store validation rules
    protected $errors = []; // Array to store validation error messages

    // Check if the value is not empty
    public function isNotEmpty($data)
    {
        if (empty($data)) {
            return "Поле не должно быть пустым.";
        }
        return null;
    }

    // Check if the value is an integer
    public function isInteger($data)
    {
        if (!filter_var($data, FILTER_VALIDATE_INT)) {
            return "Значение должно быть целым числом.";
        }
        return null;
    }

    // Check if the value is less than or equal to a given value
    public function isLess($data, $value)
    {
        if (!filter_var($data, FILTER_VALIDATE_INT) || $data >= $value) {
            return "Значение должно быть меньше, чем $value.";
        }
        return null;
    }

    // Check if the value is greater than or equal to a given value
    public function isGreater($data, $value)
    {
        if (!filter_var($data, FILTER_VALIDATE_INT) || $data <= $value) {
            return "Значение должно быть больше, чем $value.";
        }
        return null;
    }

    // Check if the value is a valid email
    public function isEmail($data)
    {
        if (!filter_var($data, FILTER_VALIDATE_EMAIL)) {
            return "Значение должно быть корректным email.";
        }
        return null;
    }

    // Проверка, что загруженный файл является изображением
    public function isImage($file)
    {
        if (!$file) {
            return "Файл не был загружен.";
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            return "Загруженный файл должен быть изображением (JPEG, PNG или GIF).";
        }

        return null;
    }

    // Add a validation rule for a specific field
    public function setRule($field_name, $validator_name, ...$args)
    {
        $this->rules[$field_name][] = [$validator_name, $args];
        return $this;
    }

    // Validate the data based on the rules
    public function validate($post_array)
    {
        foreach ($this->rules as $field => $validators) {
            foreach ($validators as [$validator, $args]) {
                if (method_exists($this, $validator)) {
                    // Если это валидация файла, передаем файл напрямую
                    if ($validator === 'isImage') {
                        $error = $this->$validator(...$args);
                    } else {
                        $error = $this->$validator($post_array[$field] ?? null, ...$args);
                    }
                    if ($error) {
                        $this->errors[$field][] = $error;
                    }
                }
            }
        }
        return empty($this->errors); // Return true if no errors
    }

    // Get validation errors
    public function getErrors()
    {
        return $this->errors;
    }
}