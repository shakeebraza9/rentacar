<?php

use App\Models\EmailTemplate;

if (! function_exists('getEmailTemplate')) {
    /**
     * Get the email template by ID.
     *
     * @param int $id
     * @return \App\Models\EmailTemplate|null
     */
    function getEmailTemplate($id)
    {
        return EmailTemplate::find($id);  // Fetch the email template by ID
    }
}