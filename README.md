# Tômbola Digital

## Apoiar o comércio local

Plataforma para gestão de uma tômbola digital. 


## Configurações Servidor

PHP version 7.3 or higher is required, with the following extensions installed:

- [intl](http://php.net/manual/en/intl.requirements.php)
- [libcurl](http://php.net/manual/en/curl.requirements.php) if you plan to use the HTTP\CURLRequest library

Additionally, make sure that the following extensions are enabled in your PHP:

- json (enabled by default - don't turn it off)
- [mbstring](http://php.net/manual/en/mbstring.installation.php)
- [mysqlnd](http://php.net/manual/en/mysqlnd.install.php)
- xml (enabled by default - don't turn it off)

## Algumas definições:

- fotos dos comerciantes aderentes ficam em public/images/aderentes/ com o nome do ficheiro a corresponder ao id_comerciante da tabela da b.d.

- o endpoint do portal é definido no ficheiro [app/Config/app.php](app/Config/app.php)
    ```
    public $baseURL = 'https://<servidor>'; (p.e. public $baseURL = 'https://tombola.cm-mealhada.pt/';)
    ```

- a sub-pasta onde está todo o projeto é definida em [public/.htaccess](public/.htaccess)
    ```
    RewriteBase /tombola_digital/
    ```

- logs da aplicação em  [writable/logs](writable/logs)

- logs de atividade na plataforma (login, logout, registos de códigos...) na base de dados tabela logger ou no backoffice no endpoint /admin/logs

- credenciais de administração (a entrada é feita também no menu "clientes")
    ```
    email: admin@camara.pt
    password: 12345678
    ```


- definições apache2 /etc/apache2/sites-enabled/000-default.conf

   ```
   <Directory "<server_dir>/tombola_digital/public">
       AllowOverride all
       Require all granted
    </Directory>
    ```


- definições para ligação à base de dados em [app/Config/Database.php](app/Config/Database.php)

     ```
        'hostname' => 'localhost',
        'username' => 'dbuser',
        'password' => 'dbpass',
        'database' => 'tombola_digital',
    ```


- definições para envio de emails (recuperação de conta, registo e ativação de conta) em [app/Config/Email.php](app/Config/Email.php)
    ```
    public $SMTPHost = "smtp.host.pt";
    public $SMTPUser = "email@camara.pt";
    public $SMTPPass = "password";
    public $SMTPPort = 587;
    ```

    - definir email "from" para estes emails em [IonAuth/Config/IonAuth.php](IonAuth/Config/IonAuth.php)
    ```
    public $adminEmail = 'admin@camara.pt'; // Admin Email, admin@example.com
    ```


- definições para envio de emails (pedidos de adesão de comerciantes,  ou contato geral) em [system/Email/Email.php](system/Email/Email.php)
    -config igual ao anterior...
    - templates de emails em [app/Views/email](app/Views/email)


- bloqueio de tentativa de login automático

    - após 3 tentativas erradas de um utilizador o sistema bloqueia a entrada

    - necessário limpar os registos desse login na tabela login_attempts da base de dados
 
- chaves API
    - google maps javascript api em [app/Config/gmaps.php](app/Config/gmaps.php) e [app/Views/comerciantes.php](app/Views/comerciantes.php)
    ```
    public $apikey = "<your_api_key>";
    <script src="https://maps.googleapis.com/maps/api/js?key=<maps-api-key>&callback=initMap&v=weekly" defer></script>
    ```
  - google recaptcha v3 key em [app/Controllers/Home.php](app/Controllers/Home.php)
  ```
  - $recaptcha_secret_key = "<recaptcha_secret_key>";
  ```
  - OAUTH2 em [Ion-Auth/Controllers/Auth.php](Ion-Auth/Controllers/Auth.php)
      - google
       ```
        //https://forum.codeigniter.com/showthread.php?tid=82429
        //https://www.youtube.com/watch?v=a5puLR051Is
        //google client code
        //google oauth2
        $this->googleClient = new \Google\Client();
        $this->googleClient->setClientId("<client-id>.apps.googleusercontent.com");
        $this->googleClient->setClientSecret("<client-secret>");
       ```
    - facebook
     ```
      $this->facebookClient = new \League\OAuth2\Client\Provider\Facebook([
            'clientId'          => '<client-id>',
            'clientSecret'      => '<client-secret>',
            'redirectUri'       => base_url('auth/login_facebook'),
            'graphApiVersion'   => 'v15.0',
        ]);
     ```
       
    
      
