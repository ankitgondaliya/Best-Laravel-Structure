<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class VideoDuration implements Rule
{
    protected $maxDuration;

    public function __construct($maxDuration)
    {
        $this->maxDuration = $maxDuration;
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
        $getID3 = new \getID3;
        $file = $getID3->analyze($value->getRealPath());
        $fileDuration = $file['playtime_seconds'] ?? 30;
        $passes = true;
        if ($this->maxDuration < $fileDuration) {
            $passes = false;
        }
        return $passes;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute duration must be less than ' . $this->maxDuration . ' seconds.';
    }
}
