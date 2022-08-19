<?php
include_once 'Sample_Header.php';

// Read contents

$name = basename(__FILE__, '.php');
$source = __DIR__ . "/resources/{$name}.docx";
function variabel_dokumen($isi_dokumen)
{ 
	$matches = array();	 
	$pattern = "/#([a-zA-Z0-9]+)|{\*?\\.+(;})|\s?\\[A-Za-z0-9]+|\s?{\s?\\[A-Za-z0-9]+\s?|\s?}\s?#/";  
	preg_match_all($pattern, $isi_dokumen, $matches); 
	$variabel_unik=array_unique($matches[1]);
	//var_dump(array_merge($variabel_unik));
	return array_merge($variabel_unik);
}  
$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($source);

echo date('H:i:s'), " Reading contents from `{$source}`", EOL;
$docx = \PhpOffice\PhpWord\IOFactory::load($source);
$content ='';
$fonts = '';
foreach ($docx->getSections() as $section) {
    
    foreach ($section->getElements() as $element) {
        
        if (method_exists($element, 'getElements')) {
            foreach ($element->getElements() as $childElement) {
                if (method_exists($childElement, 'getText')) {
                    $content .= $childElement->getText() . ' ';
                    //$var = variabel_dokumen($content);
                    $styles = $childElement->getParagraphStyle(); //do somethign witth the style
                    $fonts = $childElement->getFontStyle(); //do somethign witth the style
                    
                   /*  echo "<pre>";
                    print_r($fonts->getStyleValues());
                    print_r($content);
                    //echo $fonts->getName().$fonts->getBold();
                    echo "</pre>";  */
                } else if (method_exists($childElement, 'getContent')) {
                    $content .= $childElement->getContent() . ' ';
                }
            }
        } else if (method_exists($element, 'getText')) {
            $content .= $elements->getText() . ' ';
            
        }
    }
}


$awal = microtime(true);

$variabel = variabel_dokumen($content);
$v = $templateProcessor->getVariables();
echo '<pre>';
print_r($variabel);
echo '</pre>';


$akhir = microtime(true);

echo $awal-$akhir.' awal: '. $awal .' akhir: '. $akhir;


// Save file
//echo write($docx, basename(__FILE__, '.php'), $writers);
if (!CLI) {
    include_once 'Sample_Footer.php';
}
