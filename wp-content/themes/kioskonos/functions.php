<?php
@session_start();

function logout(){
    $_SESSION['kioskonos_logged'] = false;
    $_SESSION['kioskonos_user_id'] = false;
    $_SESSION['kioskonos_nombre_completo'] = false;
    $_SESSION['kioskonos_email'] = false;
    $_SESSION['kioskonos_tienda_id'] = false;
}


/** 
 * Busca un usuario valido
 *  
 * @param (string) $email, Email
 * @param (string) $pass, Password
 * @return (string) 
 */ 
function checkValidUser($email, $pass){
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
                'value' => $pass
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
                'user_id' => $_SESSION['kioskonos_userid'],
                'nombre_completo' => $_SESSION['kioskonos_nombre_completo'],
                'email' => $_SESSION['kioskonos_email'],
                'tienda_id' => $_SESSION['kioskonos_tiendaid']
            ];
        endwhile;

        return $user;

    } else {
        return false;
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

register_sidebar( array(
	'name' => 'Address Footer',
	'id' => 'address_footer',
	'description' => 'Address Footer',
	'before_widget' => '',
	'after_widget' => '',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
) );

register_sidebar( array(
	'name' => 'Social Footer',
	'id' => 'social_footer',
	'description' => 'Social Footer',
	'before_widget' => '',
	'after_widget' => '',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>',
) );




/**
 * Retorna el src del thumbnail generado pasando x parametros el ancho, alto y crop (default=1)
 * @uses titulares_home:  220x137
 * @uses mas_vistos:  40x40
 * @uses producto:  220x290
 * @uses main_content:  600x252
 * @uses titulares_interior:  186x116
 * @uses populares:  62x62
 *
 */
 function my_thumb_src($post_id,$options){

    if(!isset($options['crop'])){
        $crop = 1;
    } else {
        $crop = $options['crop'];
    }
 
    if(is_array($options['size'])){
        $options['ancho'] = $options['size']['ancho'];
        $options['alto'] = $options['size']['alto'];
    } else {
        switch($options['size']){
            case 'titulares_home':
                $options['ancho'] = 220;
                $options['alto'] = 137;
                break;
            case 'mas_vistos':
                $options['ancho'] = 40;
                $options['alto'] = 40;
                break;
            case 'producto':
                $options['ancho'] = 220;
                $options['alto'] = 290;
                break;
            case 'main_content':
                $options['ancho'] = 600;
                $options['alto'] = 253;
                break;
            case 'titulares_interior':
                $options['ancho'] = 186;
                $options['alto'] = 115;
                break;
            case 'populares':
                $options['ancho'] = 62;
                $options['alto'] = 62;
                break;
        }
    }
    
    
    $image_id = get_post_thumbnail_id( $post_id );
    if($image_id != ""){
        $thumb = wp_get_attachment_image_src($image_id,'large');
        $src = get_bloginfo('wpurl')."/thumb/thumb.php?src=".$thumb[0]."&h=".$options['alto']."&w=".$options['ancho']."&zc=".$crop; 
    } else {
        $src = "";
    }
    
    return $src;
}

function thumbnail($src,$options){
    if(!isset($options['crop'])){
        $crop = 1;
    } else {
        $crop = $options['crop'];
    }
 
    if(is_array($options['size'])){
        $options['ancho'] = $options['size']['ancho'];
        $options['alto'] = $options['size']['alto'];
    } else {
        switch($options['size']){
            case 'titulares_home':
                $options['ancho'] = 220;
                $options['alto'] = 137;
                break;
            case 'mas_vistos':
                $options['ancho'] = 40;
                $options['alto'] = 40;
                break;
            case 'producto':
                $options['ancho'] = 220;
                $options['alto'] = 290;
                break;
            case 'main_content':
                $options['ancho'] = 600;
                $options['alto'] = 253;
                break;
            case 'titulares_interior':
                $options['ancho'] = 186;
                $options['alto'] = 115;
                break;
            case 'populares':
                $options['ancho'] = 62;
                $options['alto'] = 62;
                break;
        }
    }
    
    $new_src = get_bloginfo('wpurl')."/thumb/thumb.php?src=".$src."&h=".$options['alto']."&w=".$options['ancho']."&zc=".$crop; 

    return $new_src;
}




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

