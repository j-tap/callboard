<?php

namespace App\Rules;

use App\Models\Kladr\City;
use Illuminate\Contracts\Validation\Rule;

class CitiesRule implements Rule
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
        if (is_array($value)) {
            foreach ($value as $val) {
                if (!City::find($val))
                    return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Нет такого города, либо вы посылаете ошибочные данные.';
    }
}
