# API Platform starter
This is a starter for your API platform project.

## Requirements
* PHP 7.4
* MySQL 5

## Generate keys
Create a folder named jwt in config folder:
```bash
mkdir config/jwt
```
Generate a private key using openssl
```bash
openssl genrsa -out config/jwt/private.pem -aes256 4096
```
You will have to provide a pass phrase.

Next, you will generate the public key:
```bash
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```
You will have to provide the same pass phrase.

## Configuration
In the config/packages/lexik_jwt_authentication.yaml file, you have to add
the token_ttl (An access token has a “time-to-live” (ttl), which is the maximum time that the access token will be valid for use within the application. 3600 seconds is 1 hour)

## Add refresh token 
```bash
composer require gesdinet/jwt-refresh-token-bundle
```
In the file config/routes.yaml, add :
```bash
gesdinet_jwt_refresh_token:
    path:       /token/refresh
    controller: gesdinet.jwtrefreshtoken::refresh
```
In the security, add this in the firewall section:
```bash
    refresh:
        pattern:  ^/token/refresh
        stateless: true
        anonymous: true
```

Create gesdinet_jwt_refresh_token.yaml in config/packages, and add :
```bash
  gesdinet_jwt_refresh_token:
      ttl: 2592000
      user_identity_field: email
```