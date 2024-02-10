# Microservice Course Unit

The Microservices Course Unit is an autonomous service that deals with operations related to course units within a distributed system.

## Overview

The Course Unit (CUs) microservice provides CRUD (create, read, update, delete) operations to manage CUs. It is designed as a RESTful API, supporting standard HTTP methods.

## Endpoints

### 1. Get Course Unit (CU) Information

- **Method:** GET
- **Endpoint:** `/api/uc/{code}`
- **Description:** Retrieve CU information based on the Course Unit Code.
- **Example:** `GET /api/uc/SE`

### 2. Create a New Course Unit

- **Method:** POST
- **Endpoint:** `/api/uc`
- **Description:** Create a new CU.
- **Example Request:**
  ```json
  {
    "code": "SE",
    "name": "Software engineering",
    "description": "This a description of CU"
  }

### 3. Update CU Information

- **Method:** PUT
- **Endpoint:** `/api/uc/{code}`
- **Description:** update a CU.
- **Example Request:**
  ```json
  {
    "code": "SE",
    "name": "Software engineering",
    "description": "This a description of CU - example"
  }

### 4. Delete CU
- **Method:** DELETE
- **Endpoint:** `/api/uc/{code}`
- **Description:** Delete a CU based on the code of CU.
- **Example:** `DELETE /api/uc/SE`