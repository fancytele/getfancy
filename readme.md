# Fancy

Aplicación y Página Web

### Install Docker image
```
docker-compose up --build
```

### Enter to docker container
```
docker-compose exec app bash
```

Once inside your Docker container install dependencies

### Laravel dependencies
```
composer install
```

### Node dependencies
```
npm install
```

### Build assets
```
npm run dev
```

## Watch build assets
```
npm run watch-poll
```

The application should run in [http://localhost:80]

If you already installed Docker image you don't need to pass on the argument build
```
docker-compose up -d
```