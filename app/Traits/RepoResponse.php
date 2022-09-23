<?php namespace App\Traits;

trait RepoResponse {

    public function formatResponse(bool $status, string $msg, string $redirect_to, $data = null, string $flash_type = '',$PK_NO = null) : object
    {

        if ($flash_type == '') {
            $flash_type = $status ? 'flashMessageSuccess' : 'flashMessageError'; // flashMessageWarning
        }

        return (object) array(
            'status'         => $status,
            'msg'            => $msg,
            'description'    => $msg,
            'data'           => $data,
            'PK_NO'          => $PK_NO,
            'redirect_to'    => $redirect_to,
            'redirect_class' => $flash_type
        );
    }
}
