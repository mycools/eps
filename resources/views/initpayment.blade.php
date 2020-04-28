<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>initPayment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  </head>
  <body>
    <div class="container-md">
  
    <p>
      <a class="btn btn-primary" href="{{ route('eps.demo.initPayment') }}">New Invoice QR Pay</a>
      <a class="btn btn-primary" href="{{ route('eps.demo.initCardPayment') }}">New Invoice Kbank Card</a>
      <a class="btn btn-primary" href="{{ route('eps.demo.initPayment',['paymentId' => $payment->id]) }}">Refresh Status</a>
    </p>
  <table class="table table-bordered">
    <tr>
      <td>ID</td><td>{{$payment->id }}</td>
    </tr>
    <tr>
      <td>ORDER</td><td>{{$payment->order }}</td>
    </tr>
    <tr>
      <td>Method</td><td><img src="{{$payment->service->image }}" height="25" /> {{$payment->service->name }} <span class="badge badge-success">{{$payment->service->type }}</span></td>
    </tr>
    <tr>
      <td>AMOUNT</td><td>{{$payment->amount }}</td>
    </tr>
    <tr>
      <td>Fee</td><td>{{ number_format($fee,2) }}</td>
    </tr>
    @if(isset($payment->resellerFee))
    <tr>
      <td>Reseller Fee</td><td>{{$payment->resellerFee }}</td>
    </tr>
    <tr>
      <td>Payee Amount</td><td>{{ number_format($payment->amount-($fee+$payment->resellerFee),2) }}</td>
    </tr>
    @endif
    <tr>
      <td>ISSUE DATE</td><td>{{ \Carbon\Carbon::parse($payment->date)->setTimezone('Asia/Bangkok')->format("d/M/Y H:i:s") }}</td>
    </tr>
    <tr>
      <td>VALID UNTIL</td><td>{{ \Carbon\Carbon::parse($payment->date)->setTimezone('Asia/Bangkok')->addSeconds($payment->ttl)->format("d/M/Y H:i:s") }}</td>
    </tr>
    <tr>
      <td>TTL</td><td>{{$payment->ttl}}</td>
    </tr>
    <tr>
      <td>STATUS</td><td>({{$payment->status}}) - {{ config('eps.status.'.$payment->status) }}</td>
    </tr>
    
  </table>
  @if($payment->status=="206")
<br />
  @foreach ($payment->attributes as $attr)
      @switch($attr->key)
          @case('qrcode')
          @case('barcode')
              <p><img src="{{ $attr->value }}" /></p>
              @break
          @case('redirectUrl')
              <p><a class="btn btn-info" href="{{ $attr->value }}">Pay now</a></p>
              @break
          @default
              
      @endswitch
  @endforeach
  @endif
    </div>
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>