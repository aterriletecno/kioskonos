<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);

include '../../../wp-load.php';
@session_start();


/********************************************************
* FUNCIONES AJAX
*********************************************************/
if( $_POST['action'] == 'eliminar_producto'){
    if( isMyProduct($_POST['product_id']) ){
        $post_delete = wp_delete_post($_POST['product_id']);
        if( $post_delete ){
            $json = ['status' => 'OK'];
        } else {
            $json = ['status' => 'FAILURE'];
        }
    } else {
        $json = ['status' => 'Access denied for product'];
    }

    echo json_encode($json);
    exit();  
}


if( $_POST['action'] == 'get_producto'){

    $args = [
        'post_type' => 'productos',
        'p' => $_POST['product_id']
    ];

    $product_result = [];
    $producto = new WP_Query($args);
    while( $producto->have_posts() ) : $producto->the_post();
        $product_result['id'] = get_the_ID();
        $product_result['title'] = get_the_title();
        $product_result['descripcion'] = nl2br(strip_tags(get_the_content()));
        $product_result['thumbnail'] = get_the_post_thumbnail_url( get_the_ID(), 'product-thumbnail' );
        $product_result['precio'] = get_field('precio',get_the_ID());
        $product_result['categorias'] = get_the_category(get_the_ID());
    endwhile;

    echo json_encode($product_result);
    exit();  
}



if( $_POST['action'] == 'denunciar_producto'){
    $producto = getProductById($_POST['product_id']);
    $to = 'hola@kioskonos.cl';
    $subject = 'Kioskonos - Denuncia de Producto';
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: no-reply@kioskonos.cl'."\r\n".
        'X-Mailer: PHP/' . phpversion();
     
    // Compose a simple HTML email message
    $message = '<html><body>';
    $message .= '<h3>Hola</h3>';
    $message .= '<p>Acaban de denunciar el producto: <strong><a href="http://www.kioskonos.cl/?post_type=productos&p='.$_POST['product_id'].'">'. $producto['title'] .'</a></strong></p>';
    $message .= '<p>Motivo: ' . $_POST['denuncia_descripcion'] . '</p>';
    $message .= '</body></html>';
     
    // Sending email
    if(mail($to, $subject, $message, $headers)){
        $json = ['status' => 'OK'];
    } else{
        $json = ['status' => 'ERROR'];
    }

    echo json_encode($json);
    exit();  
}




if( $_POST['action'] == 'contacto'){
    $to = 'hola@kioskonos.cl';
    $subject = 'Kioskonos - contacto';
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= 'From: no-reply@kioskonos.cl'."\r\n".
        'X-Mailer: PHP/' . phpversion();
     
    // Compose a simple HTML email message
    $message = '<html><body>';
    $message .= '<h3>Nuevo mensaje desde kioskonos.cl</h3>';
    $message .= '<p><strong>Nombre: </strong>'. $_POST['nombre'] .' '. $_POST['apellido'] .'</p>';
    $message .= '<p><strong>Email: </strong>'. $_POST['email'] .'</p>';
    $message .= '<p><strong>Mensaje: </strong>'. $_POST['mensaje'] .'</p>';
    $message .= '</body></html>';
     
    // Sending email
    if(mail($to, $subject, $message, $headers)){
        $json = ['status' => 'OK'];
    } else{
        $json = ['status' => 'ERROR'];
    }

    echo json_encode($json);
    exit();  
}




if( $_POST['action'] == 'inscribir_newsletter'){
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





if( $_POST['action'] == 'fav'){
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





?>