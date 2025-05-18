<?php

namespace App\Utils;

class ResultVerification extends CustomFormValidation
{
    public function validate($post_array)
    {
        // Automatically set validation rules for the test fields
        $this->setRule('favorite_color', 'isNotEmpty');        // Validate that the favorite color is not empty
        $this->setRule('animal', 'isNotEmpty');                // Validate that an animal is selected
        $this->setRule('hobbies', 'isNotEmpty');               // Validate that at least one hobby is selected
        $this->setRule('favorite_color', 'isEqual', 'синий');  // Validate that the age is not empty
        $this->setRule('animal', 'isEqual', 'cat');  // Validate that the age is not empty
        $this->setRule('name', 'isName');  // Validate that the age is not empty

        // Call the parent validate method to perform validation
        return parent::validate($post_array);
    }

    public function isEqual($data, $value)
    {
        if ($data != $value) {
            return "Значение должно быть равно $value.";
        }
        return null;
    }
}
