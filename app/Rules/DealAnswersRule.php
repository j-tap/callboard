<?php

namespace App\Rules;

use App\Models\Org\OrganizationDeal;
use Illuminate\Contracts\Validation\Rule;

class DealAnswersRule implements Rule
{

    private $deal;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(OrganizationDeal $deal)
    {
        $this->deal = $deal;
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
        $empty = 0;

        if (!is_array($value)) {
            return false;
        }

        if (is_array($value)) {
            foreach ($value as $val) {
                if (isset($val['id']) && !$this->deal->questions()->where('question_id', $val['id'])->first()) {
                    return false;
                } else {
                    if (!isset($val['id']) && $empty == 0) {
                        $empty += 1;
                    } else if ($empty > 0)
                        return false;
                }

                if (!isset($val['answer']) || strlen($val['answer']) > 1024)
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
        return 'The validation error message.';
    }
}
