<?php
@session_start();


function checkPasswordStrength($pwd) {
    $errors = 0;

    if (strlen($pwd) < 6) {
        $errors++;
    }

    if (!preg_match("#[0-9]+#", $pwd)) {
        $errors++;
    }

    if (!preg_match("#[a-zA-Z]+#", $pwd)) {
        $errors++;
    }     

    if( $errors > 0 ){
        return false;
    } else {
        return true;
    }
}

function isTiendaActiva($tienda_id){
    $tienda_activa = get_field('activa',$tienda_id);
    if( $tienda_activa ){
        return true;
    } else {
        return false;
    }
}

function isMyTienda($tienda_id){
    $tienda_usuario = get_field('tienda',session('user_id'));
    if( is_object($tienda_usuario) ){
        $tienda_usuario = $tienda->ID;
    }
    if( $tienda_id != $tienda_usuario ){
        $_SESSION['kioskonos_tienda_id'] = $tienda_usuario;
        return false;
    } else {
        return true;
    }
}

function isMyProduct($product_id){
    $tienda_producto = getTiendaByProduct($product_id);
    $tienda_usuario = getTiendaByUser(session('user_id'));

    if($tienda_producto == $tienda_usuario){
        return true;
    } else {
        return false;
    }
}

function getTiendaByUser($user_id){
    $tienda_usuario = get_field('tienda',session('user_id'));
    if( !$tienda_usuario ){
        return false;
    } else {
        if( is_object($tienda_usuario) ){
            $tienda_usuario = $tienda_usuario->ID;
        }
        return $tienda_usuario;
    }
}


function getTiendaByProduct($product_id){
    $tienda_producto = get_field('tienda',$product_id);
    if( !$tienda_producto ){
        return false;
    } else {
        if( is_object($tienda_producto) ){
            $tienda_producto = $tienda->ID;
        }
        return $tienda_producto;
    }
}


function getProductById($product_id){
    $product_args = array( 
        'post_type'  => 'productos',
        'p' => $product_id
    ); 

    $product = new WP_Query( $product_args );
    if($product->found_posts > 0){
        $return_data = [];
        while( $product->have_posts() ) : $product->the_post();
            $return_data = [
                'product_id' => get_the_ID(),
                'title' => get_the_title( get_the_ID() )
            ];
        endwhile;
        return $return_data;
    } else {
        return false;
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


function getUserByEmail($email){
    $user_args = array( 
        'post_type'  => 'usuarios',
        'meta_key' => 'email',
        'meta_value' => $email
    ); 

    $user = new WP_Query( $user_args );
    if($user->found_posts > 0){
        $return_data = [];
        while( $user->have_posts() ) : $user->the_post();
            $tienda = get_field('tienda',get_the_ID());
            $return_data = [
                'user_id' => get_the_ID(),
                'nombre_completo' => get_the_title( get_the_ID() ),
                'email' => get_field('email',get_the_ID()),
                'tienda_id' => $tienda->ID
            ];
        endwhile;
        wp_reset_query();
        wp_reset_postdata();
        return $return_data;
    } else {
        return false;
    }
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
                if( is_object($tienda) ){
                    $tienda = $tienda->ID;
                }

                $_SESSION['kioskonos_logged'] = true;
                $_SESSION['kioskonos_user_id'] = get_the_ID();
                $_SESSION['kioskonos_nombre_completo'] = get_the_title( get_the_ID() );
                $_SESSION['kioskonos_email'] = get_field('email',get_the_ID());
                $_SESSION['kioskonos_tienda_id'] = $tienda;

                $user = [
                    'user_id' => get_the_ID(),
                    'nombre_completo' => get_the_title( get_the_ID() ),
                    'email' => get_field('email',get_the_ID()),
                    'tienda_id' => $tienda
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


function isFav($user_id,$product_id){
    global $wpdb;
    $sql = "SELECT * FROM favoritos WHERE user_id = $user_id AND product_id = $product_id";
    $fav = $wpdb->get_row($sql);
    if( $fav ){
        return true;
    } else {
        return false;
    }
}


function enviarMail($to="", $from="", $subject="", $message=""){
    if( $to != "" ){
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        if( $from ){
            $headers .= 'From: ' . $from ."\r\n". 'X-Mailer: PHP/' . phpversion();
        } else {
            $headers .= 'From: KioskoNOS <hola@kioskonos.cl>'."\r\n". 'X-Mailer: PHP/' . phpversion();    
        }
        
        if(mail($to, $subject, $message, $headers)){
            return true;
        } else{
            return false;
        } 
    }
}



add_action('wp_ajax_register_user','register_user');
function register_user(){
    
    $user = checkValidUser($_POST['email'],$_POST['password']);
    if($user):
        if( $_GET['redirect'] ){
            $goto = urldecode($_GET['redirect']);
        } else {
            $goto = get_bloginfo('wpurl') . '/mi-tienda/';
        }
        header('Location: ' . $goto);
        exit();
    endif;

    echo json_encode($product_result);
    exit();  
}



add_action('wp_ajax_inscribir_newsletter','inscribir_newsletter');
function inscribir_newsletter(){
    global $wpdb;

    $sql = "
    INSERT INTO newsletter (email) 
        SELECT '". $_POST['newsletter_email'] ."' FROM DUAL
    WHERE NOT EXISTS 
        (SELECT email FROM newsletter WHERE email='". $_POST['newsletter_email'] ."');
    ";
    $wpdb->query($sql);

    echo json_encode(['status'=>'OK']);
    exit();  
}



add_action('wp_ajax_fav','fav');
function fav(){
    global $wpdb;

    if( $_POST['method'] == 'remove' ){
        $wpdb->delete( 'favoritos', [ 'user_id' => $_POST['user_id'],'product_id' => $_POST['product_id'] ] );
    } 

    if( $_POST['method'] == 'add' ){
        $wpdb->insert( 'favoritos', [ 'user_id' => $_POST['user_id'],'product_id' => $_POST['product_id'] ] );
    } 

    extract($_POST);
    $sql = "
    SELECT F.product_id, P.post_title, P.ID
    FROM favoritos F, wp_posts P
    WHERE F.user_id = $user_id
    AND P.ID = F.product_id
    ";
    $favoritos = $wpdb->get_results($sql);

    echo json_encode(['status'=>'OK', 'favoritos' => $favoritos, 'total_favoritos' => count($favoritos) ]);
    exit();  
}


