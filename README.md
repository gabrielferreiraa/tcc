#Install

* Certifique-se que a vesão do PHP seja 5.6 ou maior.
* Libere as extenções do PHP, `intl` e `mbstring`.
* Certifique-se de que tem instalado [Composer](http://getcomposer.org/doc/00-intro.md) globalmente.
* Caso tenha instalado, `composer update` em seu terminal do git.
* Certifique-se de que tem o  NodeJS instalado globalmente
* Caso tenha instalado, `npm i` em seu terminal do git.
* Vá no diretório `./config/` e crie um arquivo identico ao `app.sample.php` com nome de `app_development.php`;
* Configure seu banco de dados dentro deste arquivo no índice `DataSource`.
* Após o banco de dados configurado, vá até o terminal do git e rode `bin/cake migrations migrate`