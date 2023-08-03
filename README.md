# Instalação
Após clonar o projeto, instale as dependência utilizando o composer:
```
composer install
```

# Configurando o ambiente
Após instaladas as dependências, deve-se criar um novo arquivo `.env` copiando o arquivo `.env.example` e então gerar a chave da aplicação:
```
cp .env.example .env
php artisan key:generate
```

Dentro do arquivo `.env` devem ser colocadas as informações necessárias para se conectar ao banco de dados mysql. Os dados abaixo são os dados padrão
que o [Laravel Sail](https://github.com/laravel/sail) criou durante a instalação inicial do projeto:
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=sail
DB_PASSWORD=password
```

## Docker e Laravel Sail
O [Laravel Sail](https://github.com/laravel/sail) foi utilizado para criar os containers utilizados pela aplicação.
Podemos usar o Sail para rodar comandos Artisan dentro do container da aplicação:
```
.vendor/bin/sail artisan migrate
```
Pode-se criar um alias para agilizar o uso do sail:
```
alias sail="bash ./vendor/bin/sail"
```

Os comandos mostrados neste documento utilizarão o sail no lugar de utilizar o `docker-compose` diretamente.

# Iniciando a aplicação
A aplicação pode ser iniciada pelo `sail` utilizando o seguinte comando:
```
sail up
ou
sail up -d
```

Com isso os serviços `laravel.test`, que corresponde ao container principal da aplicação, e o container do `mysql` serão iniciados.
A primeira execução desse comando pode demorar um pouco já que o docker precisará construir os containers. Caso o processo de build falhe,
tente executar o comando novamente no caso do build ter falhado por causa de algum erro de rede.

## Executando `sail` como usuário root com `sudo`
Se o seu usuário não possuir permissões para executar o docker sem o `sudo`, a execução de comandos com o sail como root pode causar problemas
com o container da aplicação relacionados a permissão de pastas. Neste caso, deve-se sobrescrever as variáveis `WWWUSER` e `WWWGROUP` no arquivo
`.env` da seguinte maneira:
```
WWWUSER=1000 #execute 'echo $UID' para obter o id do seu usuário
WWWGROUP=1000 #execute 'id -g' para obter o id do grupo do seu usuário
```

Após isso execute o processo de build dos containers novamente:
```
sudo ./vendor/bin/sail build laravel.test mysql
```
Com isso a aplicação agora deve funcionar sem os problemas mencionados anteriormente.

## Migrando a base de dados
Continuando a instalação, migre a base de dados:
```
sail artisan migrate
```

## Configurando o Laravel Passport
Após migrada a base de dados, devemos configurar o Laravel Passport para que possamos gerar tokens JWT que serão utilizados para autenticação:
```
sail artisan passport:install
```

## Populando a base de dados
Após configurado o Passport, podemos executar o comando abaixo para popular a base de dados:
```
sail artisan db:seed
```

# A API
A url principal para acesso da API é a [http://localhost:80](http://localhost:80). Para testar a API, foi utilizada a seguinte [collection](https://www.postman.com/nova-versao-fc-teste/workspace/teste-facil-consulta/collection/23818071-1ee3f4ef-d351-45e2-a38f-1b4940c3ad58?action=share&creator=23818071) do Postman.
Nesta collection estão disponíveis todas as rotas implementadas na aplicação, só sendo necessário a emissão de um token de autenticação com um usuário para poder acessar as rotas protegidas.
Durante o processo de população da base de dados é criado o seguinte usuário de testes:
```
christian.ramires@example.com
password
```
Caso se queira criar um novo usuário, pode-se fazer uma requisição post para a rota `api/register` na aplicação com um payload no seguinte formato:
```json
{
    "name": "Christian Ramires",
    "email": "christian.ramires@example.com",
    "password": "password"
}
```
Tendo as credenciais do usuário, pode-se fazer login e obter um token de autenticação fazendo uma requisição post para a rota `api/login`.
Feito o login, o token de autenticação estará disponível no corpo da resposta.

# Testes automatizados
A suite de testes automatizados pode ser executado com o seguinte comando:
```
sail artisan test
ou
sail test
```
