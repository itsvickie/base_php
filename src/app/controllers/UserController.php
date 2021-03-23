<?php 

namespace Base_php\App\Controllers;

use Base_php\Database\Psql;
use Sprained\Validator;

class UserController extends Psql
{
    public function register()
    {
        $body = json_decode(file_get_contents("php://input"), true);
        $validator = new Validator();

        $name = $validator->required($body['name'], 'Nome de Usuário');
        $email = $validator->email($body['email']);
        $password = $validator->password($body['password']);

        $con = $this->connect();

        $psql = pg_prepare($con, 'select_email', "SELECT email FROM users WHERE email = $1");
        $psql = pg_execute('select_email', [$email]);
        $psql = pg_fetch_assoc($psql);

        if($psql){
            http_response_code(400);
            die(json_encode(['message' => 'Usuário já cadastrado!']));
        }

        $psql = pg_prepare($con, 'insert_user', "INSERT INTO users (name, email, password) VALUES ($1, $2, $3)");
        $psql = pg_execute('insert_user', [$name, $email, $password]);
        
        if(!$psql){
            http_response_code(500);
            die(json_encode(['message' => 'Não foi possível cadastrar o usuário!']));
        }

        http_response_code(201);
        die();
    }

    public function select()
    {
        $con = $this->connect();

        if(isset($_GET['id'])){
            $id = $_GET['id'];

            $psql = pg_prepare($con, 'select_user', "SELECT name, email FROM users WHERE id = $1");
            $psql = pg_execute('select_user', [$id]);
            
            if(!$psql){
                http_response_code(500);
                die(json_encode(['message' => 'Usuário não existe!']));
            }

            $psql = pg_fetch_assoc($psql);

            http_response_code(200);
            die(json_encode($psql));           
        } else {
            $psql = pg_query($con, "SELECT id, name, email FROM users");
            $psql = pg_fetch_all($psql);

            http_response_code(200);
            die(json_encode($psql));
        }
    }
}