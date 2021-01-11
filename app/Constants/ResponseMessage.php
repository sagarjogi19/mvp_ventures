<?php


namespace App\Constants;

/**
 * Response represents an HTTP response.
 *
 * @author Fabien Potencier <fabien@symfony.com>
 */
class ResponseMessage
{
    const UNAUTHORIZED_ACCESS = 'Your account has been deactivate by admin.';
    const LOGIN_SUCCESS = 'Login Successfully.';
    const LOGOUT_SUCCESS = 'Logout successfully.';
    const LOGIN_UNAUTHORIZED = "These credentials do not match with our records.";
    const USER_NOT_FOUND = 'User not found.';
    const CAR_SAVE_SUCCESS = 'Car added successfully.';
}
