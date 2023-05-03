<?php
/* 
this class is used to convert any doc,docx file to simple text format.
author: Gourav Mehta
author's email: gouravmehta@gmail.com
author's phone: +91-9888316141
*/ 

class Doc2Txt {
	private $filename;
	
	public function __construct($filePath) {
		$this->filename = $filePath;
	}
	
	// private function read_doc()	{
	// 	$fileHandle = fopen($this->filename, "r");
	// 	$line = @fread($fileHandle, filesize($this->filename));   
	// 	$lines = explode(chr(0x0D),$line);
	// 	$outtext = "";
	// 	foreach($lines as $thisline)
	// 	  {
	// 		$pos = strpos($thisline, chr(0x00));
	// 		if (($pos !== FALSE)||(strlen($thisline)==0))
	// 		  {
	// 		  } else {
	// 			$outtext .= $thisline." ";
	// 		  }
	// 	  }
	// 	 $outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\n\r\t@\/\_\(\)]/","",$outtext);
	// 	return $outtext;
	// }

    private function read_doc(){
        $outtext = "";

        if (($fh = fopen($this->filename, 'rb')) !== false) {
            $headers = fread($fh, 0xA00);

            // read doc from 0 to 255 characters
            $n1 = (ord($headers[0x21C]) - 1);

            // read doc from 256 to 63743 characters
            $n2 = ((ord($headers[0x21D]) - 8) * 256);

            // read doc from 63744 to 16775423 characters
            $n3 = ((ord($headers[0x21E]) * 256) * 256);

            //read doc from 16775424 to 4294965504 characters
            $n4 = (((ord($headers[0x21F]) * 256) * 256) * 256);

            // Total length of text in the document
            $textLength = ($n1 + $n2 + $n3 + $n4);
            ini_set('memory_limit', '-1');
            $outtext = fread($fh, $textLength);

            $outtext = preg_replace("/[\a]/","|",$outtext);
            $outtext = str_replace('“', '"', $outtext);
            $outtext = str_replace('”', '"', $outtext);
            //$outtext = str_replace('|||', '|', $outtext);
            
            $outtext = str_replace("\u0093", '"', $outtext);
            $outtext = str_replace("\u0094", '"', $outtext);

            //$outtext = utf8_encode($outtext);
            $outtext = iconv("ISO-8859-1", "UTF-8//TRANSLIT", $outtext);
            //$outtext = preg_replace("/[^a-zA-Z0-9\s\,\.\-\r\t@\/\_\(\)]/","",$outtext);
        }
        return $outtext;
    }

	private function read_docx(){

		$striped_content = '';
		$content = '';

		$zip = zip_open($this->filename);

		if (!$zip || is_numeric($zip)) return false;

		while ($zip_entry = zip_read($zip)) {

			if (zip_entry_open($zip, $zip_entry) == FALSE) continue;

			if (zip_entry_name($zip_entry) != "word/document.xml") continue;

			$content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));

			zip_entry_close($zip_entry);
		}// end while

		zip_close($zip);

		$content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);
		$content = str_replace('</w:r></w:p>', "\r\n", $content);
		$striped_content = strip_tags($content);

		return $striped_content;
	}
	
	public function convertToText() {
	
		if(isset($this->filename) && !file_exists($this->filename)) {
			return "File Not exists";
		}
		
		$fileArray = pathinfo($this->filename);
		$file_ext  = $fileArray['extension'];
		if($file_ext == "doc" || $file_ext == "docx")
		{
			if($file_ext == "doc") {
				return $this->read_doc();
			} else {
				return $this->read_docx();
			}
		} else {
			return "Invalid File Type";
		}
	}
}
?>