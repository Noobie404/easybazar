<?php

namespace App\Repositories\Admin\Invoice;

interface InvoiceInterface
{
    public function getPaginatedList($request, int $per_page = 20);
    public function postStore($request);
    public function postMerchantInvoicePdfAccess($request);
    public function getPaginatedListForProcess($request, int $per_page = 20);
    public function delete($request, int $id);
    public function postStoreInvoiceProcessing($request);
    public function invoiceQBentry(int $id);
    public function invoiceLoyaltyClaime(int $id, $invoice_for);
    public function invoiceVatClaime(int $id, $invoice_for);
    public function findOrThrowException($request, int $id);
    public function postUpdate($request, int $id);
    public function deleteImage(int $id, $invoice_for);
    public function getDeleteGeneratedStock($request,int $id);
    public function getVatProcessing();
}
