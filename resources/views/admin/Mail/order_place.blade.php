<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your order has been placed in Easybazar</title>
  </head>
  <body>
    <!DOCTYPE html>
    <html lang="en">
      <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Your Order Has been Placed in Easybazar</title>
      </head>
      <body>
        @php
          $settings   = getWebSettings();
          $image_path = getImagePath();
        @endphp
        <div style="height:100%;margin:0;padding:0;width:100%">
          <center>
            <table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" style="border-collapse:collapse;height:100%;margin:0;padding:0;width:100%">
              <tbody>
                <tr>
                  <td align="center" valign="top" style="height:100%;margin:0;padding:0;width:100%">
                    <table cellpadding="0" cellspacing="0" border="0" height="210" width="100%" style="border-collapse:collapse">
                      <tbody>
                        <tr>
                          <td bgcolor="#212121" valign="bottom">
                            <div>
                              <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;max-width:1500px">
                                <tbody>
                                  <tr>
                                    <td valign="top" style="background-color:#transparent;background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:0;padding-bottom:0">
                                      <table border="0" cellpadding="0" cellspacing="0"
                                        width="100%"
                                        style="min-width:100%;border-collapse:collapse">
                                        <tbody>
                                          <tr>
                                            <td valign="top" style="padding:9px">
                                              <table align="left" width="100%"
                                                border="0" cellpadding="0" cellspacing="0" style="min-width:100%;border-collapse:collapse">
                                                <tbody>
                                                  <tr>
                                                    <td valign="top" style="padding-right:9px; padding-left:9px;padding-top:0;padding-bottom:0;text-align:center">
                                                      <a href="{{ url('/') }}" title="{{ $settings->TITLE ?? 'Easybazar' }}" target="_blank">
                                                      @if(!empty($settings->EMAIL_HEADER_LOGO))
                                                      <img align="center" alt="Easybazar" src="{{ $image_path }}/{{ 'assets/images/logo/easybazar.png' }}" width="248" style="max-width:112px;padding-bottom:0;display:inline!important;vertical-align:bottom;border:0;height:auto;outline:none;text-decoration:none">
                                                      @endif
                                                      </a>
                                                    </td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                      <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;border-collapse:collapse">
                                        <tbody>
                                          <tr>
                                            <td valign="top" style="padding:9px">
                                              <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" style="min-width:100%;border-collapse:collapse"></table>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                      <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%; border-collapse:collapse">
                                        <tbody>
                                          <tr>
                                            <td valign="top" style="padding-top:30px">
                                              <table align="left" border="0"
                                                cellpadding="0" cellspacing="0"
                                                style="max-width:100%;min-width:100%;border-collapse:collapse"
                                                width="100%">
                                                <tbody>
                                                  <tr>
                                                    <td valign="top"
                                                      style="height:30px;background-color:#ffffff;border-top:1px solid #e3e9ed;border-left:1px solid #e3e9ed;border-right:1px solid #e3e9ed">
                                                    </td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </td>
                                  </tr>
                                </tbody>
                              </table>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse">
                      <tbody>
                        <tr>
                          <td align="center" valign="top" style="background-color:#f8fafb;background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:0px;padding-bottom:20px">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color:#fff;border-left:1px solid #e3e9ed;border-right:1px solid #e3e9ed;border-bottom:1px solid #e3e9ed;border-collapse:collapse;max-width:1500px">
                              <tbody>
                                <tr>
                                  <td valign="top"
                                    style="background-color:transparent;background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:0;padding-bottom:0">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;border-collapse:collapse">
                                      <tbody>
                                        <tr>
                                          <td valign="top">
                                            <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%;min-width:100%;border-collapse:collapse" width="100%">
                                              <tbody>
                                                <tr>
                                                  <td valign="top" style="padding-top:0;padding-right:30px;padding-bottom:30px;padding-left:10px;word-break:break-word;color:#5f7d95;font-family:Helvetica;font-size:16px;text-align:left">
                                                    <p style="font-size:26px;color:#374957;margin:0;font-weight:600;padding:0;font-family:Helvetica,Arial;line-height:150%;text-align:left">Thank you for shopping with us!</p>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td>
                                                    <div style="padding: 10px;font-family: Helvetica,Arial;">
                                                      <table style="margin:0;width:100%" cellspacing="0" cellpadding="0" border="0">
                                                        <tbody>
                                                          <tr style="width:100%">
                                                            <td style="width:50%;text-align:left">
                                                              <h2>YOUR ORDER INFORMATION</h2>
                                                            </td>
                                                            <td style="width:50%;text-align:right">
                                                              <h2>DELIVERY INFO</h2>
                                                            </td>
                                                          </tr>
                                                          <tr style="width:100%">
                                                            <td style="width:50%;text-align:left">
                                                              <p style="margin-top:1px;margin-bottom:1px">Order Number : ORD-{{ $row->BOOKING_NO }}</p>
                                                            </td>
                                                            <td style="width:50%;text-align:right">
                                                              <p style="margin-top:1px;margin-bottom:1px">{{ $row->DELIVERY_NAME}}</p>
                                                            </td>
                                                          </tr>
                                                          <tr style="width:100%">
                                                            <?php
                                                              $date=date_create($row->BOOKING_TIME);
                                                              ?>
                                                            <td style="width:50%;text-align:left">
                                                              <p style="margin-top:1px;margin-bottom:1px">Order Date : {{ $date->format('d F Y') }}</p>
                                                            </td>
                                                            @if ($row->DELIVERY_ADDRESS_LINE_1)
                                                            <td style="width:50%;text-align:right">
                                                              <p style="margin-top:1px;margin-bottom:1px">Address 1 : {{ $row->DELIVERY_ADDRESS_LINE_1 }}</p>
                                                            </td>
                                                            @endif
                                                          </tr>

                                                          <tr style="width:100%">
                                                            <td style="width:50%;text-align:left">
                                                              <p style="margin-top:1px;margin-bottom:1px">
                                                                Customer no : {{ $row->F_CUSTOMER_NO}}
                                                              </p>
                                                            </td>


                                                          </tr>
                                                          <tr style="width:100%">
                                                            <td style="width:50%;text-align:left">
                                                              <p style="margin-top:1px;margin-bottom:1px"> Your items may arrive separately.</p>
                                                            </td>

                                                            <td style="width:50%;text-align:right">
                                                              <p style="margin-top:1px;margin-bottom:1px">
                                                                {!! !empty($row->DELIVERY_CITY) ? $row->DELIVERY_CITY." " : '' !!}
                                                                {!! !empty($row->DELIVERY_POSTCODE) ? $row->DELIVERY_POSTCODE."<br>" : '' !!}
                                                                {!! !empty($row->DELIVERY_STATE) ? $row->DELIVERY_STATE : '' !!}{!! !empty($row->DELIVERY_COUNTRY) ? ', '.$row->DELIVERY_COUNTRY."<br>" : '' !!}

                                                                {{ $row->DELIVERY_MOBILE }}
                                                              </p>
                                                            </td>
                                                          </tr>
                                                          {{--
                                                          <tr style="width:100%">
                                                            <td style="width:50%;text-align:left">
                                                              <p style="margin-top:1px;margin-bottom:1px">Prefered delivery time : {{$row->DELIVERY_SLOT}}
                                                              </p>
                                                            </td>
                                                            <td style="width:50%;text-align:right">
                                                              <p style="margin-top:1px;margin-bottom:1px">+8801724 838383</p>
                                                            </td>
                                                          </tr>
                                                          --}}
                                                        </tbody>
                                                      </table>
                                                    </div>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td>
                                                    <div style="padding: 10px;font-family: Helvetica,Arial;">
                                                      <table style="margin:0;padding:0;width:100%" cellspacing="0" cellpadding="0" border="0">
                                                        <thead style="width:100%">
                                                          <tr style="width:100%;background-color:#424242;color:#fff">
                                                            {{--
                                                            <th style="width:5%;padding:10px">SL</th>
                                                            --}}
                                                            <th style="width:20%;padding:10px">Image</th>
                                                            <th style="width:60%;padding:10px;text-align:left">Product Description</th>
                                                            <th style="width:20%;padding:10px;text-align:right">Price (Taka)</th>
                                                          </tr>
                                                        </thead>
                                                        <tbody>


                                                          @if (isset($row->products) && !empty($row->products))
                                                          @foreach($row->products as $key => $product )
                                                          <tr style="border-bottom: .1rem solid #ebebeb;">
                                                            <td style="text-align:center;padding-right: 5px;">
                                                              <img src="{{ getImagePath().$product->THUMB_PATH }}" alt="{{ $product->VARIANT_NAME }}" style="width:100px;height:100px">
                                                            </td>
                                                            <td colspan="1">
                                                              <p>{{ $product->VARIANT_NAME }}</p>
                                                              <p>Qty : {{ $product->LINE_QTY }}</p>
                                                            </td>
                                                            <td style="text-align:right">
                                                                <small style="font-style: italic;"></small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ number_format($product->LINE_PRICE) }}
                                                            </td>
                                                          </tr>
                                                          @endforeach
                                                          @endif

                                                          <tr>
                                                            <td style="border-bottom: 3px solid #424242;"></td>
                                                            <td style="border-bottom: 3px solid #424242;"></td>
                                                            <td style="border-bottom: 3px solid #424242;"></td>
                                                          </tr>
                                                          <tr>
                                                            <td style="padding-top: 10px; padding-bottom: 10px;"></td>
                                                          </tr>
                                                          <tr>
                                                            <td colspan="2" style="text-align:right;padding: 5px; font-size: 15px; line-height: 17px; font-family: arial, sans-serif; color: #54595f;">Subtotal</td>
                                                            @if($row->SUB_TOTAL)
                                                            <td style="text-align:right;padding: 5px; font-size: 15px; line-height: 17px; font-family: arial, sans-serif; color: #54595f;">{{ number_format($row->SUB_TOTAL,2) }}</td>
                                                            @endif
                                                          </tr>
                                                          <tr>
                                                            <td colspan="2" style="text-align:right;padding: 5px; font-size: 15px; line-height: 17px; font-family: arial, sans-serif; color: #54595f;">Discount</td>
                                                            <td style="text-align:right;padding: 5px; font-size: 15px; line-height: 17px; font-family: arial, sans-serif; color: #54595f;">(-){{ number_format($row->COUPON_DISCOUNT,2) ?? 0.00 }}</td>
                                                          </tr>

                                                          <tr>
                                                            <td colspan="2" style="text-align:right;padding: 5px; font-size: 15px; line-height: 17px; font-family: arial, sans-serif; color: #54595f;">Delivery charge </td>
                                                            <td style="text-align:right;padding: 5px; font-size: 15px; line-height: 17px; font-family: arial, sans-serif; color: #54595f;">{{ number_format($row->POSTAGE_COST,2) ?? 0.00 }}</td>
                                                          </tr>

                                                          <tr>
                                                            <td colspan="2" style="text-align:right;padding: 5px; font-size: 15px; line-height: 17px; font-family: arial, sans-serif; color: #54595f;"><strong>Total</strong> </td>
                                                            <td style="text-align:right;padding: 5px; font-size: 15px; line-height: 17px; font-family: arial, sans-serif; color: #54595f;"><strong>{{ number_format($row->TOTAL_PRICE,2) }}</strong>
                                                            </td>
                                                          </tr>
                                                        </tbody>
                                                      </table>
                                                    </div>
                                                  </td>
                                                </tr>
                                                <tr>
                                                  <td valign="top" style="padding-top: 30px;padding-right: 30px;padding-bottom: 30px;padding-left: 30px;word-break: break-word;color: #5f7d95;font-family: Helvetica;font-size: 13px;line-height: 150%;text-align: left;font-weight: 600;">
                                                    <div style="text-align: center;">
                                                      <a style="padding-right: 22px;color: #374957; font-weight: 700;" href="#">Please Click Here For Details</a>

                                                      <a style="padding-right: 22px;color: #374957; font-weight: 700;" href="{{ url('page/terms-and-conditions') }}">Our Terms & Condition</a>
                                                    </div>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                        <tr>
                          <td align="center" valign="top" id="m_-5683066376376837812templateFooter" style="background-color:#f8fafb;background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:0px;padding-bottom:40px">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;max-width:600px">
                              <tbody>
                                <tr>
                                  <td valign="top" style="background-color:transparent;background-image:none;background-repeat:no-repeat;background-position:center;background-size:cover;border-top:0;border-bottom:0;padding-top:0px;padding-bottom:0px">
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;border-collapse:collapse">
                                      <tbody>
                                        <tr>
                                          <td valign="top" style="padding:9px">
                                            <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0" style="min-width:100%;border-collapse:collapse">
                                              <tbody>
                                                <tr>
                                                  <td valign="top"
                                                    style="padding-right:9px;padding-left:9px;padding-top:0;padding-bottom:0;text-align:center">
                                                    <a href="{{ url('/') }}" title="{{ $settings->TITLE ?? 'Easybazar' }}" target="_blank">
                                                    @if(!empty($settings->EMAIL_FOOTER_LOGO))
                                                    <img align="center" alt="{{ $settings->TITLE }}" src="{{ $image_path.$settings->EMAIL_FOOTER_LOGO }}" width="100px" style="padding-bottom:0;display:inline!important;vertical-align:bottom;border:0;height:auto;outline:none;text-decoration:none">
                                                    @else
                                                    <img align="center" alt="Easybazar" src="{{ $image_path }}/{{ 'assets/images/logo/easybazar.png' }}" width="100px" style="padding-bottom:0;display:inline!important;vertical-align:bottom;border:0;height:auto;outline:none;text-decoration:none">
                                                    @endif
                                                    </a>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="min-width:100%;border-collapse:collapse;table-layout:fixed">
                                      <tbody>
                                        <tr>
                                          <td style="min-width:100%;padding:12px 0px">
                                            <table border="0" cellpadding="0"
                                              cellspacing="0" width="100%"
                                              style="min-width:100%;border-top:1px solid #e3e9ed;border-collapse:collapse">
                                              <tbody>
                                                <tr>
                                                  <td>
                                                    <span></span>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <table border="0" cellpadding="0" cellspacing="0"
                                      width="100%"
                                      style="min-width:100%;border-collapse:collapse">
                                      <tbody>
                                        <tr>
                                          <td valign="top" style="padding-top:9px">
                                            <table align="left" border="0"
                                              cellpadding="0" cellspacing="0"
                                              style="max-width:100%;min-width:100%;border-collapse:collapse"
                                              width="100%">
                                              <tbody>
                                                <tr>
                                                  <td valign="top"
                                                    style="padding-top:0;padding-right:18px;padding-bottom:9px;padding-left:18px;word-break:break-word;color:#869fb2;font-family:Helvetica;font-size:13px;line-height:150%;text-align:center">
                                                    <p style="margin-top:0;margin-bottom:20px;margin:10px 0;padding:0;color:#869fb2;font-family:Helvetica;font-size:13px;line-height:150%;text-align:center">You will have access to all the platforms mentioned above by using the login details you have just entered to create your account.</p>
                                                    <p style="margin-top:0;margin-bottom:20px;margin:10px 0;padding:0;color:#869fb2;font-family:Helvetica;font-size:13px;line-height:150%;text-align:center">This is an automatically generated email, please do not reply.</p>
                                                    <p style="margin-top:0;margin-bottom:20px;margin:10px 0;padding:0;color:#869fb2;font-family:Helvetica;font-size:13px;line-height:150%;text-align:center">&copy; {{ date('Y') }} <a href="{{ url('/') }}">easybazar.com</a> , All rights reserved.</p>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </td>
                                        </tr>
                                      </tbody>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </tbody>
            </table>
          </center>
        </div>
      </body>
    </html>
  </body>
</html>
