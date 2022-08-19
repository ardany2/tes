<?php

class Variabel {
    protected $_content = '';
    private $_docx = null;
    private $_source = null;

    //Mendapatkan sumber dokumen.
    
    //private $docx = \PhpOffice\PhpWord\IOFactory::load($source);
    
    public function getContentDocx($source){        
        $docx = \PhpOffice\PhpWord\IOFactory::load($source);        
        $content = '';        
        foreach ($docx->getSections() as $section) {
    
            foreach ($section->getElements() as $element) {
                
                if (method_exists($element, 'getElements')) {
                    foreach ($element->getElements() as $childElement) {
                        if (method_exists($childElement, 'getText')) {
                            $content .= $childElement->getText() . ' ';
                            
                            $styles = $childElement->getParagraphStyle(); //do somethign witth the style
                            $fonts = $childElement->getFontStyle(); //do somethign witth the style
                            
                        } else if (method_exists($childElement, 'getContent')) {
                            $content .= $childElement->getContent() . ' ';
                        }
                    }
                } else if (method_exists($element, 'getText')) {
                    $content .= $element->getText() . ' ';
                    
                }
            }
        
        }
        return $content;
    }

    public function getVariabels($content)
    { 
        $matches = array();	 
        $pattern = "/#([a-zA-Z0-9_.]+)|{\*?\\.+(;})|\s?\\[A-Za-z0-9]+|\s?{\s?\\[A-Za-z0-9]+\s?|\s?}\s?#/";  
        preg_match_all($pattern, $content, $matches); 
        $variabel_unik=array_unique($matches[1]);        
        return array_merge($variabel_unik);
    }

    
}