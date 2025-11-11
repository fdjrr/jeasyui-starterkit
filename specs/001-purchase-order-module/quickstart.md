# Quickstart: Purchase Order Management

This guide provides a brief overview of how to use the Purchase Order Management module.

## 1. Creating a Purchase Order

- **Endpoint**: `POST /api/purchase-orders`
- **Body**:
  ```json
  {
    "supplier_id": 1,
    "order_date": "2025-11-11",
    "items": [
      { "product_id": 101, "quantity": 10, "price": 150.00 },
      { "product_id": 102, "quantity": 5, "price": 200.00 }
    ]
  }
  ```
- **Description**: Creates a new PO in `draft` status.

## 2. Submitting a Purchase Order

- To submit a PO for approval, update its status to `pending`.
- **Endpoint**: `PUT /api/purchase-orders/{id}`
- **Body**:
  ```json
  {
    "status": "pending"
  }
  ```

## 3. Approving a Purchase Order

- **Endpoint**: `POST /api/purchase-orders/{id}/approve`
- **Description**: A user with manager roles can approve a `pending` PO. This will change its status to `approved`.

## 4. Viewing PO History

- **Endpoint**: `GET /api/purchase-orders/{id}/history`
- **Description**: Retrieves a chronological log of all status changes for a specific PO.

## PO Status Lifecycle

The status of a PO progresses as follows:

1.  `draft`: Initial state. Can be edited.
2.  `pending`: Submitted for approval. Locked from editing.
3.  `approved`: Approved by a manager. Ready for receiving goods.
4.  `partially_received`: Some, but not all, items have been received.
5.  `received`: All items have been received. The PO is complete.
6.  `cancelled`: The PO has been cancelled. This can happen from `draft` or `pending` status.
