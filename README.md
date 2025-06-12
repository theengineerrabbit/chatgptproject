# Personal Finance API

Simple PHP API to manage personal finances with basic functionality.

## Features

- Login route (`POST /login`)
- Add expenses (`POST /expenses`)
- Add incomes (`POST /incomes`)
- Bank account registration (`POST /bankaccounts` and `GET /bankaccounts`)
- Category registration (`POST /categories` and `GET /categories`)
- Separate values to investments or savings using `target` field
- Euro values handled via `amount_eur` field

## Usage

1. Deploy on a PHP-enabled server.
2. Send JSON requests to the routes above.
3. Data is stored in JSON files inside `api/data` directory.

This is a minimal example and does not include advanced security or persistence features.

### Example Request

```bash
# Login
curl -X POST -H "Content-Type: application/json" -d '{"username":"admin","password":"secret"}' http://localhost/login
```
