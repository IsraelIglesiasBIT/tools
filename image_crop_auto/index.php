<?php
//SCRIPT QUE AUTORECORTA LAS IMÁGENES
//Author: Israel Iglesias
//Organization: Conwork

include './autocrop.php';

new AutoCrop('1.jpeg', 'crop_1.jpeg');
new AutoCrop('2.jpeg', 'crop_2.jpeg');
new AutoCrop('3.jpeg', 'crop_3.jpeg');
new AutoCrop('4.jpeg', 'crop_4.jpeg');
new AutoCrop('5.jpeg', 'crop_5.jpeg');
new AutoCrop('6.jpeg', 'crop_6.jpeg');

?>