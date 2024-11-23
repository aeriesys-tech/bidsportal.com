<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;

class ValidDateRule implements Rule
{
    public function passes($attribute, $value)
    {
        // Check if the value is numeric (Excel serial date)
        if (is_numeric($value)) {
            try {
                // Try to convert Excel numeric date to a Carbon instance
                Date::excelToDateTimeObject($value);
                return true;
            } catch (\Exception $e) {
                return false;
            }
        }
        
        // Check if it's a valid date string in 'Y-m-d' format or other recognizable format
        if (is_string($value) && strtotime($value)) {
            try {
                Carbon::createFromFormat('Y-m-d', $value)->format('Y-m-d');
                return true;
            } catch (\Exception $e) {
                return false;
            }
        }

        // If none of the above conditions are met, return false
        return false;
    }

    public function message()
    {
        return 'Invalid date. The date should be in the format YYYY-MM-DD';
    }
}
