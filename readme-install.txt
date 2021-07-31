/************** INSTALACION PROYECTO ***********************/

1) composer install
2) npm install / yarn install
3) correr webpack: yarn encore dev-server
4) correr el server:  symfony serve -d


script base de datos esta en la raiz de proyecto (db_bank_symfony)

/*** USUARIOS *****/
*  id: 123 password: 123*
*  id: 1234 password: 123*
**** USUARIOS *****/


si queremos generar mas usuarios correr el comando:

php bin/console doctrine:fixtures:load