<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Receipt #{{ $order->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            background: white;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
        }
        
        /* Header */
        .header {
            text-align: center;
            border-bottom: 3px solid #4f46e5;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #4f46e5;
            margin-bottom: 5px;
        }
        
        .tagline {
            font-size: 11px;
            color: #666;
        }
        
        /* Title */
        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin: 20px 0;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        /* Sections */
        .section {
            margin-bottom: 20px;
        }
        
        .section-title {
            font-weight: bold;
            font-size: 14px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            margin-bottom: 10px;
            color: #4f46e5;
        }
        
        /* Info rows */
        .info-row {
            display: flex;
            margin-bottom: 5px;
        }
        
        .info-label {
            width: 120px;
            font-weight: bold;
            color: #555;
        }
        
        .info-value {
            flex: 1;
        }
        
        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        
        th {
            background-color: #f3f4f6;
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }
        
        td {
            border: 1px solid #ddd;
            padding: 8px 10px;
            text-align: left;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-right {
            text-align: right;
        }
        
        /* Total row */
        .total-row {
            background-color: #f3f4f6;
            font-weight: bold;
        }
        
        .total-label {
            text-align: right;
            font-weight: bold;
        }
        
        /* Footer */
        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            font-size: 10px;
            color: #666;
        }
        
        /* Status badges */
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
        }
        
        .status-closed {
            background-color: #22c55e;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        
        {{-- Header with Logo --}}
        <div class="header">
            <div class="logo">FunShirt</div>
            <div class="tagline">Custom T-Shirts &amp; Printing</div>
            <div class="tagline">Rua das Camisetas, 123 | 2400-000 Leiria | Portugal</div>
        </div>

        {{-- Receipt Title --}}
        <div class="title">
            PURCHASE RECEIPT
        </div>

        {{-- Order Information --}}
        <div class="section">
            <div class="section-title">Order Details</div>
            <div class="info-row">
                <div class="info-label">Order Number:</div>
                <div class="info-value"><strong>#{{ $order->id }}</strong></div>
            </div>
            <div class="info-row">
                <div class="info-label">Order Date:</div>
                <div class="info-value">{{ $order->created_at->format('d/m/Y H:i') }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Order Status:</div>
                <div class="info-value">
                    <span class="status-badge status-closed">COMPLETED</span>
                </div>
            </div>
        </div>

        {{-- Customer Information --}}
        <div class="section">
            <div class="section-title">Customer Information</div>
            <div class="info-row">
                <div class="info-label">Name:</div>
                <div class="info-value">{{ $order->customer->user->name ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">NIF:</div>
                <div class="info-value">{{ $order->nif ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Email:</div>
                <div class="info-value">{{ $order->customer->user->email ?? 'N/A' }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Delivery Address:</div>
                <div class="info-value">{{ $order->address ?? 'N/A' }}</div>
            </div>
        </div>

        {{-- Payment Information --}}
        <div class="section">
            <div class="section-title">Payment Information</div>
            <div class="info-row">
                <div class="info-label">Payment Method:</div>
                <div class="info-value">{{ $order->payment_type ?? 'N/A' }}</div>
            </div>
            @if($order->payment_ref)
            <div class="info-row">
                <div class="info-label">Payment Reference:</div>
                <div class="info-value">{{ $order->payment_ref }}</div>
            </div>
            @endif
        </div>

        {{-- Items Table --}}
        <div class="section">
            <div class="section-title">Items</div>
            
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th class="text-center" style="width: 60px">Size</th>
                        <th class="text-center" style="width: 60px">Qty</th>
                        <th class="text-right" style="width: 100px">Unit Price</th>
                        <th class="text-right" style="width: 100px">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr>
                        <td>
                            {{ $item->tshirtImage->name ?? 'Product' }}
                            <br>
                            <small style="color: #666;">Color: {{ $item->color->name ?? $item->color_code }}</small>
                            @if($item->tshirtImage && !$item->tshirtImage->isCatalogImage())
                                <br><small style="color: #8b5cf6;">(Custom Image)</small>
                            @endif
                        </td>
                        <td class="text-center">{{ $item->size }}</td>
                        <td class="text-center">{{ $item->qty }}</td>
                        <td class="text-right">€{{ number_format($item->unit_price, 2) }}</td>
                        <td class="text-right">€{{ number_format($item->sub_total, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <td colspan="4" class="total-label">TOTAL:</td>
                        <td class="text-right"><strong>€{{ number_format($order->total_price, 2) }}</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- Notes if any --}}
        @if($order->notes)
        <div class="section">
            <div class="section-title">Notes</div>
            <p style="background: #f9fafb; padding: 10px; border-radius: 5px;">{{ $order->notes }}</p>
        </div>
        @endif

        {{-- Footer --}}
        <div class="footer">
            <p>Thank you for shopping with FunShirt!</p>
            <p>This receipt is electronically generated and does not require a signature.</p>
            <p>For any questions, please contact: <strong>support@funshirt.com</strong></p>
            <p>© {{ date('Y') }} FunShirt - All rights reserved.</p>
        </div>
        
    </div>
</body>
</html>