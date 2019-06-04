<?php
/** @var $order \App\Order */
?>
<div>
    Hi {{ $order->contact_name }}, your order {{ $order->id }} was delivered at: {{ $order->delivered_at }}
</div>
