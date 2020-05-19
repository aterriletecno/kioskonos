<?php
@session_start();


function isMyTienda($tienda_id){
    $tienda_usuario = get_field('tienda',session('user_id'));
    if( $tienda_id != $tienda_usuario->ID ){
        $_SESSION['kioskonos_tienda_id'] = $tienda_usuario->ID;
        return false;
    } else {
        return true;
    }
}

function logout(){
    $_SESSION['kioskonos_logged'] = false;
    unset($_SESSION['kioskonos_logged']);
    unset($_SESSION['kioskonos_user_id']);
    unset($_SESSION['kioskonos_nombre_completo']);
    unset($_SESSION['kioskonos_email']);
    unset($_SESSION['kioskonos_tienda_id']);
}


/** 
 * Busca un usuario valido
 *  
 * @param (string) $email, Email
 * @param (string) $pass, Password
 * @return (string) 
 */ 
function checkValidUser($email="", $pass=""){
    if( session('logged') ){
        $user = [
            'user_id' => session('user_id'),
            'nombre_completo' => session('nombre_completo'),
            'email' => session('email'),
            'tienda_id' => session('tienda_id')
        ];

        return $user;
    } else {
        $user_args = array( 
            'post_type'  => 'usuarios',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key'   => 'email',
                    'value' => $email
                ),
                array(
                    'key'   => 'password',
                    'value' => md5($pass)
                ),
                array(
                    'key'   => 'activo',
                    'value' => 1
                )
            )
        );  

        $valid_user = new WP_Query( $user_args );

        if($valid_user->found_posts > 0){

            $user = [];
            while( $valid_user->have_posts() ) : $valid_user->the_post();
                $tienda = get_field('tienda',get_the_ID());

                $_SESSION['kioskonos_logged'] = true;
                $_SESSION['kioskonos_user_id'] = get_the_ID();
                $_SESSION['kioskonos_nombre_completo'] = get_the_title( get_the_ID() );
                $_SESSION['kioskonos_email'] = get_field('email',get_the_ID());
                $_SESSION['kioskonos_tienda_id'] = $tienda->ID;

                $user = [
                    'user_id' => get_the_ID(),
                    'nombre_completo' => get_the_title( get_the_ID() ),
                    'email' => get_field('email',get_the_ID()),
                    'tienda_id' => $tienda->ID
                ];
            endwhile;

            return $user;

        } else {
            return false;
        }
    }

}

/** 
 * Retorna el valor de una variable de session 
 *  
 * @param (string) $var_sess, Nombre de la variable de session 
 * @return (string) 
 */ 
function session($var_sess){ 
    return $_SESSION['kioskonos_' . $var_sess]; 
} 


add_image_size('product-thumbnail',300,300,true);
add_image_size('banner-tienda',1400,400,true);
add_image_size('banner-tienda-small',400,100,true);

/**
 * Muestra un arreglo de forma amigable al usuario
 * 
 */
function show_array($array, $die=true){
    echo "<pre>";
    print_r($array);
    echo "</pre>";
    if($die){
        die();
    }
}


add_theme_support( 'post-formats', array( 'aside', 'gallery' ) );

// This theme uses post thumbnails
add_theme_support( 'post-thumbnails' );

register_nav_menus( array(
	'primary' => __( 'Primary Navigation', 'twentyten' ),
) );    


/**
 * Muestra un resumen del contenido, separado por palabras
 * @uses $txt = El contenido
 * @uses $cant_palabras = Cuantas palabras quieres mostrar
 */
function excerpt($txt, $cant_palabras){
    $txt = strip_tags($txt);
    $arr_txt = explode(" ",$txt);
    if($cant_palabras > count($arr_txt)){
        return $txt;
    } else {
        $new_txt = "";
        
        for($i=0; $i<=$cant_palabras; $i++){
            $new_txt .= $arr_txt[$i]." ";
        }
    }
    return $new_txt;
}

/* http://biostall.com/hashing-acf-password-type-fields-in-wordpress/ */
function ns_function_encrypt_passwords( $value, $post_id, $field  )
{
    $value = md5( $value );
 
    return $value;
}
add_filter('acf/update_value/type=password', 'ns_function_encrypt_passwords', 10, 3);