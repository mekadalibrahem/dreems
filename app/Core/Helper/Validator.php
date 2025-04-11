<?php

namespace App\Core\Helper;

use App\Core\Helper\Rules\Required;
use Exception;

class Validator
{
    public static $rules = [
        'required' => Required::class,
    ];


    public static function checkRule($rule, $errorKey, $data)
    {
        $valid_rule = self::$rules[$rule] ?? false;
       
        if ($valid_rule) {
            if ($valid_rule::check($data)) {
                return true;
            } else {
                Session::error($errorKey, $valid_rule::getError());
                return false;
            }
        } else {
            throw new Exception("Rule not found");
        }
    }


    
    /**
     * Validates the given request data against the given rules.
     *
     * @param array $requestdata The request data to validate.
     * @param array $rules The rules to validate the request data against.
     *
     * @throws Exception If the request data does not contain a key specified in the rules.
     *
     * @return mixed If any validation fails, returns a redirect response to the previous page.
     *               If all validation succeeds, returns nothing.
     */
    public static function validate($requestdata, $rules)
    {
        foreach ($rules as $errorKey => $ruleList) {
            if (!array_key_exists($errorKey, $requestdata)) {
                throw new Exception("InvalidParameter: key not found in request data");
            }
            foreach ($ruleList as $rule) {
                if (!self::checkRule($rule, $errorKey, $requestdata[$errorKey])) {
                    return redirect(back());
                }
            }
        }
    }
}
