<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;

class SameSizeAs implements Rule
{
    protected $otherArrayKey;

    /**
     * Create a new rule instance.
     *
     * @param  string  $otherArrayKey
     * @return void
     */
    public function __construct($otherArrayKey)
    {
        $this->otherArrayKey = $otherArrayKey;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $otherArray = request()->input($this->otherArrayKey);

        return is_array($otherArray) && count($value) === count($otherArray);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must have the same number of elements as ' . $this->otherArrayKey . '.';
    }
}
