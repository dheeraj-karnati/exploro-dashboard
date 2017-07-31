<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
		
		
	}

    //Transform XML
    public function testconvert()
    {
        $files = glob("application/ceads/files/*xml");

        if (is_array($files)) {
            foreach ($files as $filename) {
                $ead_doc = new DOMDocument();
                $ead_doc->load($filename);
                $xpath = new DOMXPath($ead_doc);
                if ($xpath->query("/C/did")->item(0)){
                    $filesNode = $ead_doc ->createElement('files');
                    $itemNode = $xpath ->query("/C/")->item(0);

                    $itemattributes = $itemNode ->attributes;
                    foreach ($itemattributes as $itemattr){
                        $filesNode->setAttributeNodeNS($itemattr->cloneNode());

                    }
                    $ead_doc->documentElement->appendChild($filesNode);
                    if ($childNodes = $xpath->query("/C/*"))
                    {
                        foreach ($childNodes as $childNode)
                        {   $filesNode->appendChild($childNode);  }
                    }
                    $filesNode->parentNode->removeChild($filesNode);

                }
                $newString1 = $ead_doc->saveXML();
                $file = basename($filename);

                file_put_contents("application/ceads/$file", $newString1);

            }
        }
    }


    /*public function sample(){

        $directory = '/Applications/MAMP/htdocs/exploro/application/eads';

        if (! is_dir($directory)) {
            exit('Invalid diretory path');
        }

        $files = array();

        foreach (new DirectoryIterator($directory) as $file) {
            if ('.' === $file) continue;
            if ('..' === $file) continue;
            $ead_doc = new DOMDocument();
            $ead_doc->load($file);

            //load xsl file
            $xsl_doc = new DOMDocument();
            $xsl_doc->load("application/xslt/ead_solr.xsl");
            $proc = new XSLTProcessor();
            $proc->importStylesheet($xsl_doc);
            //create new domfile
            $newdom = $proc->transformToDoc($ead_doc);
            //save new dom file into solr_xmls directory
            $newdom->save("application/solr_xmls/".$file)or die("Error");


            //$files[] = $file;
        }


    }*/


    /*    $xml_doc = new DOMDocument();
        $xml_doc->load("application/ead/");


    // XSL
        $xsl_doc = new DOMDocument();
        $xsl_doc->load("file.xsl");

    // Proc
        $proc = new XSLTProcessor();
        $proc->importStylesheet($xsl_doc);
        $newdom = $proc->transformToDoc($xml_doc);

        print $newdom->saveXML();*/


    /* public function newf(){
         foreach (new DirectoryIterator(__DIR__) as $file) {
        //     if ($file->isFile()) {
                 print $file . "\n";
          //   }
         }




     }*/

    /* public function readxml() {

         $files = glob("application/eads/*xml");

         if (is_array($files)) {

             foreach ($files as $filename) {
                 $ead_doc = new DOMDocument();
                 $ead_doc->load($filename);
               //  $ead_doc->loadXML($filename);
              //   echo $ead_doc ->saveXML();
                  $newString =str_replace("xmlns=\"http://ead3.archivists.org/schema/\"","",$ead_doc->saveXML());
                // echo $newString;
                 file_put_contents($filename, $newString);

                 print_r($filename);

             }}

     }*/

    /*public function readfile()
    {
        $files = glob("application/eads/*xml");

        if (is_array($files)) {

            foreach ($files as $filename) {
              //  print $filename;
                $ead_doc = new DOMDocument();
                $ead_doc->load($filename);
                $string1 = $ead_doc->saveXML() ;
echo $string1;

            }
        }

    }*/

    public function convertead2s()
    {
        $files = glob("application/ead2/*xml");
        if (is_array($files)) {

            foreach ($files as $filename) {

                //$eadfile = file_get_contents($filename);
                //load ead file from eads folder
                $ead_doc = new DOMDocument();
                $ead_doc->load($filename);
                $file = basename($filename);
                //  $xml=simplexml_load_file($filename);
                $newString = $ead_doc->saveXML();
                file_put_contents("application/cead2s/$file", $newString);
                $new_ead_doc = new DOMDocument();
                $new_ead_doc->load("application/cead2s/$file");
                // $filepath = $filename;
                //load xsl file
                $xsl_doc = new DOMDocument();
                $xsl_doc->load("application/xslt/ead2_solr.xsl");
                $proc = new XSLTProcessor();
                $proc->importStylesheet($xsl_doc);
                //create new domfile
                $newdom = $proc->transformToDoc($new_ead_doc);
                //save new dom file into solr_xmls directory
                $newdom->save("application/solr_ead2/" . $file) or die("Error");

            }
            $filecount = sizeof($files);
            echo "total number of ead documents converted: " .$filecount;

        }
    }
    public function finalEads(){

        $files = glob("application/solr_xmls/*xml");
        if (is_array($files)) {
            foreach ($files as $filename) {
                $ead_doc = new DOMDocument();
                $ead_doc->load($filename);
                $file = basename($filename);

                $xsl_doc = new DOMDocument();
                $xsl_doc->load("application/xslt/new_ead_solr.xsl");
                $proc = new XSLTProcessor();
                $proc->importStylesheet($xsl_doc);

                $newdom = $proc->transformToDoc($ead_doc);
                //save new dom file into solr_xmls directory
                $newdom->save("application/final_eads/".$file)or die("Error");
            }
        }
    }

    public function parseXMLdoc(){
        // $new_ead_doc = new DOMDocument();
        // $new_ead_doc -> load("application/ceads/2.1.1.xml");
        $xmlparser = xml_parser_create();
// open a file and read data
        $fp = fopen("application/solr_xmls/2.1.1.xml", 'r');
        $xmldata = fread($fp, 500000);
        xml_parse_into_struct($xmlparser,$xmldata,$values);
        xml_parser_free($xmlparser);
        print_r(json_encode($values));
        //print_r($values);

    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */