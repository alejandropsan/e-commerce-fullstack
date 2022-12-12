<?php
require_once 'models/usuario.php';

class UsuarioController{
    public function index() {
        echo "Controlador Usuarios, Accion index";
    }
    
    public function registro() {
        require_once 'views/usuario/registro.php';
    }
    
    public function save() {
        if(isset($_POST)){
            $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : false;
            $apellidos = isset($_POST['apellidos']) ? $_POST['apellidos'] : false;
            $email = isset($_POST['email']) ? $_POST['email'] : false;
            $password = isset($_POST['password']) ? $_POST['password'] : false;
            
            $errores = array();
            
            if(!empty($nombre) && !is_numeric($nombre) && !preg_match("/[0-9]/", $nombre)){
                $nombre_validado = true;
            }else{
                $nombre_validado = false;
                $errores['nombre'] = "El nombre introducido no es válido";
            }
            
            if(!empty($apellidos) && !is_numeric($apellidos) && !preg_match("/[0-9]/", $apellidos)){
                $apellidos_validado = true;
            }else{
                $apellidos_validado = false;
                $errores['apellidos'] = "Los apellidos introducidos no son válidos";
            }
            
            if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)){
                $email_validado = true;
            }else{
                $email_validado = false;
                $errores['email'] = "El email introducido no es válido";
            }
            
            if(!empty($password)){
                $password_validado = true;
            }else{
                $password_validado = false;
                $errores['password'] = "La contraseña introducida está vacía";
            }

            
            $guardar_usuario = false;
            if(count($errores) == 0){
                $guardar_usuario = true;
            }
            if($nombre_validado && $apellidos_validado && $email_validado && $password_validado){
                $usuario = new Usuario();
                $usuario->setNombre($nombre);
                $usuario->setApellidos($apellidos);
                $usuario->setEmail($email);
                $usuario->setPassword($password);

                $save = $usuario->save();
                if($save){
                    $_SESSION['register'] = "complete";
                }else{
                    $_SESSION['register'] = "failed";
                } 
            }else{
                $_SESSION['register'] = "failed";
            }      
        }else{
            $_SESSION['register'] = "failed";
        }
        header('Location:'.base_url.'usuario/registro');
    }
    
    public function login(){
        if(isset($_POST)){
            //Identificar usuario
            //Consulta a la base de datos
            $usuario = new Usuario();
            $usuario->setEmail($_POST['email']);
            $usuario->setPassword($_POST['password']);
            
            $identity = $usuario->login();

            //Crear una sesión
            if($identity && is_object($identity)){
                $_SESSION['identity'] = $identity;
                
                if($identity->rol == 'admin'){
                    $_SESSION['admin'] = true;
                }
            }else{
                $_SESSION['error_login'] = 'Identificación fallida !!';
            }
            
        }
        header("Location:".base_url);
    }
    
    public function logOut() {
        if(isset($_SESSION['identity'])){
            unset($_SESSION['identity']);
        }
        
        if(isset($_SESSION['admin'])){
            unset($_SESSION['admin']);
        }
        
        header("Location:".base_url);
    }
} // Fin clase
