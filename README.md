
# Technical Challenge

Product Registration and Sales System for a Marketplace


## Stacks

**Front-end:** VueJs with Quasar

**Back-end:** PHP

## Require

Make sure you have the following require installed on your machine:

- Docker
- Docker Compose

## Installation

```bash
 git clone https://github.com/biancamota/desafio-tecnico.git
```
```bash
 cd desafio-tecnico
```

```bash
 docker-compose up --build -d
```

#### The API will be available at: http://localhost:9090/

#### The Frontend will be available at: http://localhost:9000/

## Routes API

#### Products

```http
  GET /products
```

| Parameter   | Type       | Description                           |
| :---------- | :--------- | :---------------------------------- |
| none | none | return all products |

```http
  GET /products/{id}
```

| Parameter   | Type       | Description                           |
| :---------- | :--------- | :---------------------------------- |
| id | string | return a specific product with the given ID |                      |

```http
  POST /products
```

| Parameter   | Type       | Description                           |
| :---------- | :--------- | :---------------------------------- |
| id | string | Creates a new product. |   

```http
  PUT /products/{id}
```

| Parameter   | Type       | Description                           |
| :---------- | :--------- | :---------------------------------- |
| id | string | Updates an existing product with the provided ID. |  

```http
  DELETE /products/{id}
```

| Parameter   | Type       | Description                           |
| :---------- | :--------- | :---------------------------------- |
| id | string | Deletes a product with the provided ID. |  

#### Caterogories

```http
  GET /categories
```

| Parameter   | Type       | Description                           |
| :---------- | :--------- | :---------------------------------- |
| none | none | return all categories |

```http
  GET /categories/{id}
```

| Parameter   | Type       | Description                           |
| :---------- | :--------- | :---------------------------------- |
| id | string | return a specific category with the given ID |                      |

```http
  POST /categories
```

| Parameter   | Type       | Description                           |
| :---------- | :--------- | :---------------------------------- |
| id | string | Creates a new category. |   

```http
  PUT /categories/{id}
```

| Parameter   | Type       | Description                           |
| :---------- | :--------- | :---------------------------------- |
| id | string | Updates an existing category with the provided ID. |  

```http
  DELETE /categories/{id}
```

| Parameter   | Type       | Description                           |
| :---------- | :--------- | :---------------------------------- |
| id | string | Deletes a category with the provided ID. |  

#### Sales

```http
  GET /sales
```

| Parameter   | Type       | Description                           |
| :---------- | :--------- | :---------------------------------- |
| none | none | return all sales |

```http
  GET /sales/{id}
```

| Parameter   | Type       | Description                           |
| :---------- | :--------- | :---------------------------------- |
| id | string | return a specific sale with the given ID |                      |

```http
  POST /sales
```

| Parameter   | Type       | Description                           |
| :---------- | :--------- | :---------------------------------- |
| id | string | Creates a new sale. |   

```http
  PUT /sales/{id}
```

| Parameter   | Type       | Description                           |
| :---------- | :--------- | :---------------------------------- |
| id | string | Updates an existing sale with the provided ID. |  

```http
  DELETE /sales/{id}
```

| Parameter   | Type       | Description                           |
| :---------- | :--------- | :---------------------------------- |
| id | string | Deletes a sale with the provided ID. |  

#### Users

```http
  GET /users
```

| Parameter   | Type       | Description                           |
| :---------- | :--------- | :---------------------------------- |
| none | none | return all users |

```http
  GET /users/{id}
```

| Parameter   | Type       | Description                           |
| :---------- | :--------- | :---------------------------------- |
| id | string | return a specific user with the given ID |                      |

```http
  POST /users
```

| Parameter   | Type       | Description                           |
| :---------- | :--------- | :---------------------------------- |
| id | string | Creates a new user. |   

```http
  PUT /users/{id}
```

| Parameter   | Type       | Description                           |
| :---------- | :--------- | :---------------------------------- |
| id | string | Updates an existing user with the provided ID. |  

```http
  DELETE /users/{id}
```

| Parameter   | Type       | Description                           |
| :---------- | :--------- | :---------------------------------- |
| id | string | Deletes a user with the provided ID. |  

