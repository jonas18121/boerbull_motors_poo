<?php
declare(strict_types=1);

/**
 * redirectionne vers un url
 *
 * @param string $url
 * @return void
 */
function redirect(string $url) : void
{
    header('Location: ' . $url);
    exit();
}


/**
 * var_dump avec < pre >< / pre > pour le debogage de code
 * 
 * @param mixed $param1 - Tous les types de param sont accepter
 * @param mixed $param2 - (facultative) Tous les types de param sont accepter
 * @param bool $param3  - sur false par défault , permet d'activer ou pas, la function die()
 * 
 * @return void - retourne la valeur de var_dump
 */
function pre_var_dump($param1, $param2 = null, bool $param3 = false) : void
{
    if ($param3 === false) {
        
        if ($param2 === null) {
            echo '<pre>';
            var_dump($param1);
            echo '</pre>';
        }
        else{
            echo '<pre>';
            var_dump($param1, $param2);
            echo '</pre>';
        }
    }else{
        if ($param2 === null) {
            echo '<pre>';
            var_dump($param1);die;
            echo '</pre>';
        }
        else{
            echo '<pre>';
            var_dump($param1, $param2);die;
            echo '</pre>';
        }
    }
}


/**
 * faire une redirection
 * 
 * @param string $url - url de destination
 * @param bool $bool  - sur true par défault , permet d'activer ou pas, la function exit()
 * 
 * @return void
 */
function header_location(string $url, bool $bool = true) : void
{
    if($bool === false){
        header("Location: {$url}");
    }
    else{
        header("Location: {$url}");
        exit();
    }
}

////////////////////////// pagination //////////////////////////////////////////

/**
 * On détermine sur quelle page on se trouve
 * 
 * @param int $get
 * 
 * @return int $current_page
 */
function get_current_page(int $get) : int
{
    if(isset($get) && !empty($get))
    {
        $current_page = (int) strip_tags($get);   
    }
    else{
        $current_page = 1;
    }

    return $current_page;
}



////////////////////////// fin de pagination //////////////////////////////////////////


//////////////////// uploal_file

function upload_file($filename){

    $file_basename = substr($filename, 0, strripos($filename, '.')); // on récupère que le nom du fichier sans l'extention

    $file_ext = substr($filename, strripos($filename, '.')); // on récupère l'extention sans le nom du fichier

    $filesize = $_FILES["image_url"]["size"];

    $rand = rand(0, 100000000);
    $rand2 = rand(0, 100000000);

    $allowed_file_types = array('.doc','.docx','.rtf','.pdf', '.gif', '.jpg', '.png', '.PNG', '.jpeg');	

    if (in_array($file_ext, $allowed_file_types) && ($filesize < 1200000))
    {	
        $first_filename = $file_basename . $file_ext;
        
        $date = new DateTime('now');
        $date = $date->format('Y_m_d_H_i_s');

        if (file_exists("www/imgBoerbullMotors/" . $first_filename))
        {
            
            // si le fichier existe déjà, on renomme le fichier
            $change         = "change {$date} {$rand2} and {$file_basename} plz";
            $new_filename   = md5($change) . $file_ext;
            $good_img       = $rand . '_' . $date . $new_filename;
            
            move_uploaded_file($_FILES["image_url"]["tmp_name"], "www/imgBoerbullMotors/" . $good_img );
            echo "success le fichier a été renomé et ajouter car il existe déjà dans ce dossier.";
        }
        else
        {		
            $good_img = $first_filename;
            move_uploaded_file($_FILES["image_url"]["tmp_name"], "www/imgBoerbullMotors/" . $good_img);
            echo "success le fichier est bien ajouter.";		
        }
        return $good_img;
    }
    elseif ($filesize > 1200000)
    {	
        echo "Le fichier est trop large";
    }
    else
    {
        echo "Le fichier doit avoir l'un de ces extentions : " . implode(', ',$allowed_file_types);
        unlink($_FILES["image_url"]["tmp_name"]);
    }

    return $good_img = '';
}