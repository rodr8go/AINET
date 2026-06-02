<!DOCTYPE html>
<html>
<head>
    <title>@if($type == 'pending') Order Confirmation - FunShirt @else Order Completed - FunShirt @endif</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, 
                @if($type == 'pending') #4f46e5 0%, #6366f1 100% 
                @else #22c55e 0%, #16a34a 100% @endif);
            color: white;
            text-align: center;
            padding: 30px 20px;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
        }
        @if($type == 'closed')
        .success-badge {
            background-color: #22c55e;
            color: white;
            padding: 10px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }
        @endif
        .content {
            padding: 30px;
        }
        .order-details {
            background: #f8fafc;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            border-left: 4px solid 
                @if($type == 'pending') #4f46e5 
                @else #22c55e @endif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }
        .button {
            display: inline-block;
            background: 
                @if($type == 'pending') #4f46e5 
                @else #22c55e @endif;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .footer {
            background: #f8fafc;
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #64748b;
        }
        .receipt-note {
            background: #fef3c7;
            padding: 10px;
            border-radius: 5px;
            margin-top: 15px;
            font-size: 13px;
        }
    </style>
</head>
<body>
    <div class="container">
        {{-- Header with dynamic color --}}
        <div class="header">
            <div class="logo">
                @if($type == 'pending') 🎨 FunShirt @else ✅ FunShirt @endif
            </div>
            <p>Custom T-Shirts &amp; Printing</p>
        </div>
        
        {{-- Success badge for closed orders --}}
        @if($type == 'closed')
        <div class="success-badge">
            🎉 ORDER COMPLETED! 🎉
        </div>
        @endif
        
        <div class="content">
            {{-- Dynamic greeting based on status --}}
            <h2>Hello {{ $order->customer->user->name }}! 👋</h2>
            
            @if($type == 'pending')
                <p>Thank you for your order! We're excited to let you know that your order has been <strong>received</strong> and is now being processed.</p>
            @else
                <p>Great news! Your order <strong>#{{ $order->id }}</strong> has been <strong>completed</strong> and is on its way to you! 🚚</p>
            @endif
            
            {{-- Order details --}}
            <div class="order-details">
                <h3 style="margin-top: 0;">📋 Order Summary</h3>
                <p><strong>Order Number:</strong> #{{ $order->id }}</p>
                <p><strong>Order Date:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                
                @if($type == 'closed')
                    <p><strong>Completion Date:</strong> {{ $order->updated_at->format('d/m/Y H:i') }}</p>
                @endif
                
                <p><strong>Total Amount:</strong> €{{ number_format($order->total_price, 2) }}</p>
                
                <h4>Items:</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Size</th>
                            <th>Qty</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->tshirtImage->name ?? 'Product' }}</td>
                            <td>{{ $item->size }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>€{{ number_format($item->sub_total, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                
                <p><strong>Delivery Address:</strong> {{ $order->address }}</p>
                
                @if($order->notes)
                    <p><strong>Notes:</strong> {{ $order->notes }}</p>
                @endif
            </div>
            
            {{-- Dynamic message based on status --}}
            @if($type == 'pending')
                <p>We'll notify you as soon as your order is ready to be shipped! 🚀</p>
            @else
                <p>Your receipt is attached to this email. You can also download it from your account.</p>
            @endif
            
            {{-- Receipt note for closed orders --}}
            @if($type == 'closed')
            <div class="receipt-note">
                📄 <strong>Receipt attached:</strong> A PDF receipt has been attached to this email for your records.
            </div>
            @endif
            
            {{-- Button --}}
            <center>
                <a href="{{ route('orders.show', $order) }}" class="button">View Order Details</a>
            </center>
        </div>
        
        {{-- Footer --}}
        <div class="footer">
            <p>FunShirt - Custom T-Shirts</p>
            <p>Questions? Contact us at <a href="mailto:support@funshirt.com">support@funshirt.com</a></p>
            <p>&copy; {{ date('Y') }} FunShirt. All rights reserved.</p>
        </div>
    </div>
</body>
</html>