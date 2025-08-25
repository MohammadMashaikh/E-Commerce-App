<x-mail::message>
# Order #{{ $order->id }} Placed Successfully

Hello {{ $order->user->name }},

Your order has been placed and is waiting for review. Here’s a summary:

@foreach ($order->orderItems as $item)
- {{ $item->product->name }} x {{ $item->quantity }} — ${{ $item->price * $item->quantity }}
@endforeach

**Total:** ${{ $order->total }}

<x-mail::button :url="route('orders.list')">
View Order
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
