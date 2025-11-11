# Research: Purchase Order Management

This document records the key technical decisions for the Purchase Order Management module.

## Technology Stack

- **Decision**: Use Laravel 12 as the backend framework.
- **Rationale**: The project is already a Laravel application. Using the existing framework ensures consistency and leverages existing knowledge.
- **Alternatives considered**: None, as the project context dictates the framework.

## Architecture & Patterns

- **Decision**: Implement a Service Layer (`PurchaseOrderService`) to handle business logic.
- **Rationale**: This separates business logic from the controller, improving code organization and reusability. It aligns with the Code Quality principle.
- **Alternatives considered**: Placing logic in controllers was rejected as it leads to "fat controllers" and violates SRP.

- **Decision**: Use FormRequests for input validation.
- **Rationale**: Laravel's FormRequests provide a dedicated, reusable way to handle complex validation scenarios, keeping controllers clean.
- **Alternatives considered**: Manual validation in controllers was rejected as it adds clutter and is less reusable.

- **Decision**: Use a native PHP Enum for the `status` field and configure Laravel's Eloquent to cast it automatically.
- **Rationale**: Enums provide type-safe, self-documenting states, making the code more robust and readable than using plain strings or integers.
- **Alternatives considered**: Using strings was rejected as it's prone to typos and lacks type safety.

- **Decision**: Use Model Events (e.g., an `updated` event) or a dedicated Event/Listener pair (`PurchaseOrderStatusChanged` / `RecordPurchaseOrderStatusChange`) to automatically create history records.
- **Rationale**: This decouples history tracking from the main business logic, making the system more modular and easier to maintain.
- **Alternatives considered**: Manually creating history records within the service was rejected as it clutters the primary business logic.
