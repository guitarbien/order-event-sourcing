<?php
/** @var $order \App\Order */
?>
<div>
    Hi {{ $order->contact_name }}, thanks for buying our product, your order <a href="#">{{ $order->id }}</a> will be delivered soon.
</div>
