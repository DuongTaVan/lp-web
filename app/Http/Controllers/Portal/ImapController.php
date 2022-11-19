<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;

class ImapController extends Controller
{
    public function countEmailUnseen()
    {
        $hostname = config('mail.imap.host');
        $username = config('mail.imap.username');
        $password = config('mail.imap.password');
        if ($hostname && $username && $password) {
            $result = [];
            try {
                $inbox = imap_open($hostname, $username, $password);
                $result = imap_search($inbox, 'UNSEEN');
            } catch (\Exception $e) {
            }
            return count($result ?: []);
        }

        return 0;
    }
}

