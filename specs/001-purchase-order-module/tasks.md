# Tasks: Purchase Order Management

**Feature**: [Purchase Order Management](specs/001-purchase-order-module/spec.md)

This document outlines the development tasks for implementing the Purchase Order Management module.

## Phase 1: Setup

- [x] T001 Create `purchase_orders` table migration in `database/migrations/xxxx_xx_xx_xxxxxx_create_purchase_orders_table.php`
- [x] T002 Create `purchase_order_items` table migration in `database/migrations/xxxx_xx_xx_xxxxxx_create_purchase_order_items_table.php`
- [x] T003 Create `purchase_order_histories` table migration in `database/migrations/xxxx_xx_xx_xxxxxx_create_purchase_order_histories_table.php`
- [x] T004 Create `PurchaseOrderStatus` enum in `app/Enums/PurchaseOrderStatus.php`
- [x] T005 [P] Create `PurchaseOrder` model in `app/Models/PurchaseOrder.php`
- [x] T006 [P] Create `PurchaseOrderItem` model in `app/Models/PurchaseOrderItem.php`
- [x] T007 [P] Create `PurchaseOrderHistory` model in `app/Models/PurchaseOrderHistory.php`

## Phase 2: Foundational (Service & History Tracking)

- [x] T008 Create `PurchaseOrderService` class in `app/Services/PurchaseOrderService.php`
- [x] T009 Create `PurchaseOrderStatusChanged` event in `app/Events/PurchaseOrderStatusChanged.php`
- [x] T010 Create `RecordPurchaseOrderStatusChange` listener in `app/Listeners/RecordPurchaseOrderStatusChange.php`
- [x] T011 Register the event and listener in `app/Providers/EventServiceProvider.php`

## Phase 3: User Story 1 - Create and Submit PO

**Goal**: A procurement staff member can create a new purchase order as a 'draft' and submit it for approval, changing its status to 'pending'.

- [x] T012 [US1] Create `StorePurchaseOrderRequest` in `app/Http/Requests/StorePurchaseOrderRequest.php` for validation.
- [x] T013 [US1] Implement `create` method in `app/Services/PurchaseOrderService.php` to handle PO creation logic.
- [x] T014 [US1] Implement `store` method in `app/Http/Controllers/PurchaseOrderController.php` to handle the API request.
- [x] T015 [US1] Add `POST /api/purchase-orders` route to `routes/api.php`.
- [x] T016 [US1] Create `UpdatePurchaseOrderRequest` in `app/Http/Requests/UpdatePurchaseOrderRequest.php` for status update validation.
- [x] T017 [US1] Implement `submit` method in `app/Services/PurchaseOrderService.php` to change status to 'pending'.
- [x] T018 [US1] Implement logic in `update` method of `app/Http/Controllers/PurchaseOrderController.php` to handle PO submission.
- [x] T019 [US1] Add `PUT /api/purchase-orders/{id}` route to `routes/api.php`.

## Phase 4: User Story 2 - Approve or Reject PO

**Goal**: A manager can approve a 'pending' PO to 'approved' or reject it to 'cancelled'.

- [x] T020 [P] [US2] Implement `approve` method in `app/Services/PurchaseOrderService.php`.
- [x] T021 [P] [US2] Implement `approve` method in `app/Http/Controllers/Api/v1/PurchaseOrderController.php`.
- [x] T022 [US2] Add `POST /api/purchase-orders/{id}/approve` route to `routes/api.php`.
- [x] T023 [P] [US2] Implement `reject` method in `app/Services/PurchaseOrderService.php`.
- [x] T024 [P] [US2] Implement rejection logic within the `update` method in `app/Http/Controllers/Api/v1/PurchaseOrderController.php`.

## Phase 5: User Story 3 - Track PO History

**Goal**: Any user with access can view a complete history of a PO's status changes.

- [x] T025 [US3] Implement `getHistory` method in `app/Services/PurchaseOrderService.php`.
- [x] T026 [US3] Implement `history` method in `app/Http/Controllers/Api/v1/PurchaseOrderController.php`.
- [x] T027 [US3] Add `GET /api/purchase-orders/{id}/history` route to `routes/api.php`.

## Phase 6: Polish & Cross-Cutting Concerns

- [x] T028 [P] Implement `index` method in `app/Http/Controllers/Api/v1/PurchaseOrderController.php` for listing POs.
- [x] T029 [P] Add `GET /api/purchase-orders` route to `routes/api.php`.
- [x] T030 [P] Implement `show` method in `app/Http/Controllers/Api/v1/PurchaseOrderController.php` for viewing a single PO.
- [x] T031 [P] Add `GET /api/purchase-orders/{id}` route to `routes/api.php`.
- [x] T032 [P] Implement `destroy` method in `app/Http/Controllers/Api/v1/PurchaseOrderController.php`.
- [x] T033 [P] Add `DELETE /api/purchase-orders/{id}` route to `routes/api.php`.

## Dependencies

- **User Story 1** is a prerequisite for all other user stories.
- **User Story 2** depends on User Story 1.
- **User Story 3** can be implemented after the foundational event/listener setup is complete but is most useful after User Stories 1 and 2 are done.

## Parallel Execution

- Within each user story, tasks marked with `[P]` can often be worked on in parallel. For example, in Phase 1, the three model creation tasks (T005, T006, T007) can be done simultaneously.
- In Phase 4, the `approve` and `reject` service methods (T020, T023) can be developed in parallel.

## Implementation Strategy

The implementation will follow an MVP-first approach. The primary goal is to deliver User Story 1, which provides the core functionality of creating and submitting a purchase order. Subsequent user stories will be implemented incrementally. This ensures that the most critical functionality is delivered first.
