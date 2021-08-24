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