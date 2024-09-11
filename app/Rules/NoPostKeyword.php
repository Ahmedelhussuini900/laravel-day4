<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class NoPostKeyword implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Check if the title contains the word "post"
        return !str_contains(strtolower($value), 'post');
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The title cannot contain the word "post".';
    }
}
