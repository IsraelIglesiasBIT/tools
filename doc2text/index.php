<?php

require 'doc2txt.class.php';

$docObj = new Doc2Txt("test.doc");
//$docObj = new Doc2Txt("test.docx");

$txt = $docObj->convertToText();

// require 'rd-class-text-extraction.php';

// $txt = RD_Text_Extraction::convert_to_text("test.doc");

echo '<pre>';
print_r($txt);
echo '</pre>';
?>