
# Angular with Lumen




## Project Setup

Lumen install

```bash
  composer create-project --prefer-dist laravel/lumen giveProjectName
```

Angular install

```bash
  ng new giveProjectName
```

Lumen server run on custom host and port

```bash
  php -S giveHost:givePort -t public
```

Angular run on custom host and port

```bash
ng serve --host giveHost --port givePort
```


## FAQ

## Git ignore not working 
#### run these commands 

```bash
git rm -r --cached .
git add .
git commit -m “.gitignore is now working”
```



## Environment variables for angular




- create environment.ts file like below

- src\environments\environment.ts 
  - add below class :
    
    export const environment = {
        production: false,
        apiURL: 'Host:port/'
    };
    



