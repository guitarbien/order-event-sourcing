<?php
/** @var $order \App\Order */
?>
<div>
    Hi {{ $order->contact_name }}, your order <a href="#">{{ $order->id }}</a> was delivered at: {{ $order->delivered_at }}
</div>
