<?php

namespace App\Repositories\Admin\Notification;

interface NotificationInterface
{
    public function getPaginatedList($request, int $per_page = 500);
    public function postAppBulkSend($request);
    public function sendWebNotification($request);
    public function ajaxImageUpload($request);
    public function getDeviceList($request);
    public function postToken($request);
    public function postBulkToken($request);





}
