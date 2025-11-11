# Data Model: Purchase Order Management

This document defines the database schema for the Purchase Order module.

## Tables

### `purchase_orders`

Stores the main purchase order information.

| Column | Type | Constraints | Description |
| --- | --- | --- | --- |
| `id` | `bigint`, unsigned | Primary Key, Auto-increment | Unique identifier for the PO. |
| `po_number` | `varchar(255)` | Unique, Indexed | The human-readable PO number. |
| `supplier_id` | `bigint`, unsigned | Foreign Key to `suppliers` | The supplier for this order. |
| `order_date` | `date` | | The date the order was placed. |
| `expected_delivery_date` | `date` | Nullable | The expected delivery date. |
| `status` | `varchar(255)` | | The current status of the PO (draft, pending, etc.). Backed by `PurchaseOrderStatus` Enum. |
| `total_amount` | `decimal(15, 2)` | | The calculated total amount of the order. |
| `notes` | `text` | Nullable | Any notes or comments. |
| `created_by` | `bigint`, unsigned | Foreign Key to `users` | The user who created the PO. |
| `approved_by` | `bigint`, unsigned | Foreign Key to `users`, Nullable | The user who approved the PO. |
| `approved_at` | `timestamp` | Nullable | The timestamp of approval. |
| `created_at` | `timestamp` | | |
| `updated_at` | `timestamp` | | |

### `purchase_order_items`

Stores the individual line items for each purchase order.

| Column | Type | Constraints | Description |
| --- | --- | --- | --- |
| `id` | `bigint`, unsigned | Primary Key, Auto-increment | Unique identifier for the item. |
| `purchase_order_id` | `bigint`, unsigned | Foreign Key to `purchase_orders` | The PO this item belongs to. |
| `product_id` | `bigint`, unsigned | Foreign Key to `products` | The product being ordered. |
| `quantity` | `int` | | The quantity of the product ordered. |
| `price` | `decimal(15, 2)` | | The price per unit at the time of order. |
| `total` | `decimal(15, 2)` | | The calculated total for this line item. |
| `created_at` | `timestamp` | | |
| `updated_at` | `timestamp` | | |

### `purchase_order_histories`

Stores the audit trail of status changes for each purchase order.

| Column | Type | Constraints | Description |
| --- | --- | --- | --- |
| `id` | `bigint`, unsigned | Primary Key, Auto-increment | Unique identifier for the history record. |
| `purchase_order_id` | `bigint`, unsigned | Foreign Key to `purchase_orders` | The PO this history belongs to. |
| `status` | `varchar(255)` | | The status being recorded. |
| `user_id` | `bigint`, unsigned | Foreign Key to `users` | The user who triggered the status change. |
| `notes` | `text` | Nullable | Any notes related to this change. |
| `created_at` | `timestamp` | | |
| `updated_at` | `timestamp` | | |

## Enums

### `PurchaseOrderStatus` (app/Enums/PurchaseOrderStatus.php)

A string-backed enum for the `status` field in `purchase_orders`.

```php
<?php

namespace App\Enums;

enum PurchaseOrderStatus: string
{
    case DRAFT = 'draft';
    case PENDING = 'pending';
    case APPROVED = 'approved';
    case PARTIALLY_RECEIVED = 'partially_received';
    case RECEIVED = 'received';
    case CANCELLED = 'cancelled';
}
```
