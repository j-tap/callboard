<?php

namespace App\Rules;

use App\Classes\Business\WorkTime;
use Illuminate\Contracts\Validation\Rule;

class WorkTimeRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        return WorkTime::checkWorkTime($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The work time is invalid.';
    }
}
