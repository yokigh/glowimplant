<?php
return[
    'registration_success' => 'Account successfully created! Please check your email to verify your account.',
    'email_required' => 'Email is required.',
    'email_invalid' => 'Invalid email address.',
    'email_unique' => 'Email is already in use.',
    'password_required' => 'Password is required.',
    'password_min' => 'Password must be at least :min characters.',
    'password_confirmed' => 'Password confirmation does not match.',
    'name_required' => 'Name is required.',
    'username_required' => 'Username is required.',
    'username_unique' => 'Username is already taken.',
    'phone_required' => 'Phone number is required.',
    'country_required' => 'Country selection is required.',
    'role_required' => 'Role selection is required.',
    'invalid_verification_link' => 'Invalid or expired verification link.',
    'account_verified' => 'Your account has been successfully verified! You can now log in.',
    'password_reset_link_sent' => 'The password reset link has been sent to your email.',
    'password_reset_failed' => 'Failed to send password reset link. Please try again later.',
    'email_not_found' => 'This email is not registered in our system.',
    'newrequired' => 'This field is required.',
    'newemail' => 'Please enter a valid email address.',
    'newpassword.newrequired' => 'Please enter a password.',
    'newpassword.confirmed' => 'The password confirmation does not match.',
    'newpassword.newpassword' => 'Password must be at least 8 characters long and include at least one number and one uppercase letter.',
    // Additional messages can be added as needed
    'newpassword_reset' => 'Your password has been successfully reset.',
    'newpassword_reset_failed' => 'Failed to reset your password.',
    'login' => [
        'email_required' => 'Please enter an email address.',
        'email_invalid' => 'Please enter a valid email address.',
        'password_required' => 'Please enter a password.',
        'invalid_credentials' => 'Invalid login credentials.',
        'email_not_verified' => 'Please verify your account before logging in.',
    ],

    // Logout error messages
    'logout' => [
        'session_not_found' => 'Your session could not be found.',
    ],
    'verification' => [
        'greeting' => 'Hello :name',
        'message' => 'Thank you for registering on our website. Please confirm your email by clicking the button below:',
        'button' => 'Verify Account',
        'ignore' => 'If you did not register, please ignore this message.',
    ],

];