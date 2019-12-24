<?php

define('ROOT', dirname(__DIR__));

if (isset($_POST['action']) && $_POST['action'] == "upload")
{
    include_once ROOT ."/src/Components/Uploader.php";
    include_once ROOT ."/src/Components/ResizeImage.php";
    $uploader = new Uploader($_FILES['files']);
    $uploader->set_upload_to("./attachment");
    $uploader->set_valid_extensions(array('jpg', 'png', 'bmp'));
    $uploader->set_resize_image_library(new ResizeImage());

    if ($uploader->is_valid_extension() === false) {
        echo "<p>Error</p>";
        print_r($uploader->get_errors());
    }else{

        if ($uploader->run() === false) {
            echo "<p>Error</p>";
            print_r($uploader->get_errors());
        }else{
            echo "...Uploaded";

            if ($uploader->resize(70) === false) {
                echo "<p>Error</p>";
                print_r($uploader->get_errors());
            }else{
                echo "...Resized";
            }
        }

    }

    exit;
}
?>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="upload" />
    1: <input type="file" name="files[]" /><br />
    2: <input type="file" name="files[]" /><br />
    3: <input type="file" name="files[]" />
    <input type="submit" value="Upload" />
</form>