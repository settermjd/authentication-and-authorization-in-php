# Authentication and Authorization in PHP Course Code and Supporting Material

This repository contains the PHP code and any other supporting material for my Pluralsight course: [Authentication and Authorization in PHP](https://app.pluralsight.com/library/courses/authentication-authorization-php/).

## Requirements

To use this repository, you need the following:

- PHP 7.4 or above.
- [Composer](https://getcomposer.org) installed globally.
- [Docker Engine](https://docs.docker.com/engine/install/)
- [Docker Compose (version 2)](https://docs.docker.com/compose/install/)

## Getting Started

To get started with the code, first clone it, and then install the required PHP dependencies, by running the commands below.

```bash
git clone git@github.com:settermjd/authentication-and-authorization-in-php.git
cd authentication-and-authorization-in-php
composer install --no-interaction --quiet
```

Then, start the application by running the following command:

```bash
docker compose up -d
```

After the command completes, run the following command to check that the application is running.

```bash
docker compose ps
```

If so, you should see output similar to the example below.

```bash
NAME             COMMAND                  SERVICE   STATUS    PORTS
course-nginx-1   "/docker-entrypoint.…"   nginx     running   0.0.0.0:8008->80/tcp, :::8008->80/tcp
course-php-1     "docker-php-entrypoi…"   php       running   9000/tcp
```

To shut down the application, run the following command.

```bash
docker compose down
```

**TIP:** If you're not too familiar with Docker Compose, you can learn more about it in the **FREE** book [Deploy With Docker Compose](https://deploywithdockercompose.com).

## Running the Examples

### Authentication

#### Basic Authentication

In your browser of choice, make a request to http://localhost:8080/authentication/basic/basic-authentication.php.
When prompted for the username and password, use the following credentials:

| Username   | Password   |
|------------|------------|
| `admin`    | `passw0rd` |

#### Digest Authentication

In your browser of choice, make a request to http://localhost:8080/authentication/digest/digest-authentication.php.
When prompted for the username and password, use the following credentials:

| Username | Password |
|----------|----------|
| `admin`  | `mypass` |
| `guest`  | `guest`  |

#### Form-based Authentication

In your browser of choice, make a request to http://localhost:8080/authentication/form-based/index.php.
When prompted for the username and password, use the following credentials:

| Username   | Password   |
|------------|------------|
| `admin`    | `passw0rd` |

### Authorization

#### ACLs

In your browser of choice, make a request to http://localhost:8008/authorization/acls/acl.php.
You should see the following output.

```bash
The helpdesk operator has the dashboard resource with the user.suspend privilege.
```

#### RBAC

In your browser of choice, make a request to http://localhost:8008/authorization/rbac/rbac.php
You should see the following output.

```bash
Jane has the users.add role
Jane in the Finance Department has the users.add role
```

#### JWTs

In your browser of choice, make a request to http://localhost:8008/authorization/jwt/login.php:
In the form that appears, use the following credentials:

| Username   | Password   |
|------------|------------|
| `admin`    | `passw0rd` |

You should see output similar to the following.

```bash
eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2xvY2FsZG9tYWluLmRldiIsImF1ZCI6Imh0dHBzOi8vbG9jYWxkb21haW4uZGV2IiwiaWF0IjoxNjU1OTkwNjAxLCJuYmYiOjE2NTU5OTA2NjEsInN1YiI6ImFkbWluIiwiZXhwIjoxNjU1OTkxODAxfQ.kPUqXKcNIklcrMllGpp1uEg3UOzNACQY6kyHZ07AGtQ
```

Now, run the command below, replacing `{token}` with the string displayed after logging in.

```bash
curl http://localhost:8008/authorization/jwt/index.php \
  -H "Accept: application/json" \
  -H "Authorization: Bearer {token}"
```

You should see output similar to the following.

```bash
*   Trying 127.0.0.1:8008...
* Connected to localhost (127.0.0.1) port 8008 (#0)
> GET /authorization/jwt/index.php HTTP/1.1
> Host: localhost:8008
> User-Agent: curl/7.81.0
> Accept: application/json
> Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2xvY2FsZG9tYWluLmRldiIsImF1ZCI6Imh0dHBzOi8vbG9jYWxkb21haW4uZGV2IiwiaWF0IjoxNjU1OTkxNTUwLCJuYmYiOjE2NTU5OTE2MTAsInN1YiI6ImFkbWluIiwiZXhwIjoxNjU1OTkyNzUwfQ.hYPQEGCg2k1lgi4YVvJ6J-7-G0kRuHTpINs0HWCQ5Vc
>
* Mark bundle as not supporting multiuse
  < HTTP/1.1 200 OK
  < Server: nginx/1.23.0
  < Date: Thu, 23 Jun 2022 13:42:34 GMT
  < Content-Type: text/html; charset=UTF-8
  < Transfer-Encoding: chunked
  < Connection: keep-alive
  < X-Powered-By: PHP/8.1.7
```

## Questions

If you have any questions, please either [ask them in the course discussion](https://app.pluralsight.com/library/courses/authentication-authorization-php/discussion), or [email me (matthew@matthewsetter.com)](mailto:matthew@matthewsetter.com).

## Want to Grow Your Docker Compose Skills?

If you're not too familiar with Docker Compose, download the **FREE** book, [Deploy With Docker Compose](https://deploywithdockercompose.com), and learn the six essentials steps to deploying applications both locally and remotely.