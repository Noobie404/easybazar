<div class="row">
    <div class="col-md-12 col-sm-12">
        
        <a href="{{ route('admin.reseller.refund') }}" class="btn btn-md btn-warning c-btn {{ request()->route()->getName() == 'admin.reseller.refund' ? 'active' : ''}} " style="min-width:90px;">Reseller list </a>
        <a href="{{ route('admin.reseller.refundrequest') }}" class="btn btn-md btn-warning c-btn {{ request()->route()->getName() == 'admin.reseller.refundrequest' ? 'active' : ''}}" style="min-width:90px;">Request for Refund</a>
        <a href="{{ route('admin.reseller.refunded') }}" class="btn btn-md btn-warning c-btn {{ request()->route()->getName() == 'admin.reseller.refunded' ? 'active' : ''}}" style="min-width:90px;">Refunded</a>

      </div>
</div>
