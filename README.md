# FinFlow

FinFlow is a full-stack financial management application built with Laravel and React. It includes a separate Laravel wallet service integrated with the main backend through APIs.

The project focuses on financial operations, backend service communication, and building a web interface for managing customers, transactions, and wallets.

> **Project status:** In development. The main backend and wallet service have been implemented, and the frontend is being completed.

## Features

### Main Application
- User authentication
- Customer management
- Financial transaction management
- Transaction approval and rejection
- Dashboard APIs
- Integration with a separate wallet service

### Wallet Service
- Wallet creation and retrieval
- Deposits and withdrawals
- Wallet-related API endpoints

### Frontend
- React application with pages for login, dashboard, customers, transactions, and wallets
- Frontend functionality and API integration are still being completed

## Tech Stack

| Component | Technologies |
| --- | --- |
| Main backend | PHP, Laravel |
| Frontend | React, Vite, JavaScript |
| Wallet service | PHP, Laravel |
| Service communication | REST APIs |

## Project Structure

```text
FinFlowProject/
├── FinFlow/         # Main Laravel backend
├── FinFlowFront/    # React frontend
├── WalletService/   # Separate Laravel wallet service
└── README.md
```

## Architecture

FinFlow is organized into three components:

**1. Main Backend (`FinFlow`)**

Handles the application's core functionality, including authentication, customer management, transactions, and dashboard APIs. It also contains a client for communicating with the wallet service.

**2. Wallet Service (`WalletService`)**

A separate Laravel application responsible for wallet operations. The main backend communicates with it through API requests.

**3. Frontend (`FinFlowFront`)**

A React application that provides the user interface and communicates with the main backend through APIs.

```text
                 React Frontend
                  FinFlowFront
                       |
                       | HTTP / REST API
                       v
                Laravel Backend
                    FinFlow
                       |
                       | API requests
                       v
                Laravel Wallet Service
                  WalletService
```

## Development Progress

- [x] Main backend implementation
- [x] Wallet service implementation
- [x] API client for communication with the wallet service
- [x] Initial React frontend
- [ ] Complete frontend functionality and API integration
- [ ] Run end-to-end tests across all three components
- [ ] Document local setup and API endpoints

## Running the Project

The repository contains three application components, each with its own dependencies and configuration.

The Laravel applications require their respective PHP dependencies and environment configuration. The React frontend requires its JavaScript dependencies.

A complete setup guide will be added after the application has been tested end to end.

**Security note:** Local environment files, credentials, and generated dependencies are excluded from version control.

## Planned Improvements

- Complete the frontend and connect its remaining features to the backend
- Test financial operations across the main backend and wallet service
- Improve error handling and validation
- Add automated tests
- Document API endpoints and setup instructions

## Author

**Shahad Abdullah Albuhiri**

Software Engineering | Full-Stack Development | AI
