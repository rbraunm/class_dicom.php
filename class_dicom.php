<?PHP

define('TOOLKIT_DIR', '/usr/local/bin');

/*

Dean Vaughan 2011 <dean@deanvaughan.org>
http://www.deanvaughan.org

*/

/*
$d = new dicom_tag;
$d->file = 'SOME_IMAGE.dcm';
$d->load_tags();
$name = $d->get_tag('0010', '0010');
*/

class dicom_tag {

  var $tags = array();
  var $file = -1;

### LOAD DICOM TAGS FROM A FILE INTO AN ARRAY ($this->tags). $this->file is the filename of the image.
  function load_tags() {
    $file = $this->file;
    $dump_cmd = TOOLKIT_DIR . "/dcmdump -M +L +Qn $file";
    $dump = `$dump_cmd`;

    if(!$dump) {
      return(0);
    }

    foreach(explode("\n", $dump) as $line) {

      $t = preg_match_all("/\((.*)\) [A-Z][A-Z]/", $line, $matches);
      if(isset($matches[1][0])) {
        $ge = $matches[1][0];
        $this->tags["$ge"] = '';
      }

      $val = '';
      $t = preg_match_all("/\[(.*)\]/", $line, $matches);
      if(isset($matches[1][0])) {
        $val = $matches[1][0];
        $this->tags["$ge"] = $val;
      }
      else { // a couple of tags are not in []
        $t = preg_match_all("/\=(.*)\#/", $line, $matches);
        if(isset($matches[1][0])) {
          $val = $matches[1][0];
          $this->tags["$ge"] = rtrim($val);
        }
      }
    }
  }

### AFTER load_tags() HAS BEEN CALLED, USE THIS TO GET A SPECIFIC TAG
  function get_tag($group, $element) {
    $val = '';
    if(isset($this->tags["$group,$element"])) {
      $val = $this->tags["$group,$element"];
    }
    return($val);
  }

### WRITE TAGS INTO AN IMAGE, $tag_arr SHOULD LOOK LIKE:
/*
$tag_arr = array(
  '0010,0010' => 'VAUGHAN^DEAN',
  '0008,0080' => 'DEANLAND, AR'
);
*/
### $this->file is the filename of the image.
  function write_tags($tag_arr) {
    if(!is_array($tag_arr)) {
      return(1);
    }

    $str = '';
    foreach($tag_arr as $group => $element) {
      $str .= "-i \"($group)=$element\" ";
    }

    $write_cmd = TOOLKIT_DIR . "/dcmodify $str " .
               "-nb \"" . $this->file . "\"";
    $out = `$write_cmd`;
    if(!$out) {
      return(0);
    }
    else {
      return($out);
    }
  }


}

class dicom_convert {

  var $file = '';  
  var $transfer_syntax = '';
  var $jpg_file = '';
  var $tiff_file = '';
  var $tn_file = '';
  
### REQUIRES IMAGE MAGICK
### Convert a DICOM image to JPEG. $this->file is the filename of the image.
  function dcm_to_jpg() {

    $filesize = 0;
    $jpg_quality = 95;

    $this->jpg_file = $this->file . '.jpg';
    $this->tiff_file = $this->file . '.tiff';
   
    if(!$this->transfer_syntax) {
      $tags = new dicom_tag;
      $tags->file = $this->file;
      $tags->load_tags();
      $this->transfer_syntax = $tags->get_tag('0002', '0010');
    }

    if(strstr($this->transfer_syntax, 'LittleEndian')) {
      $convert_cmd = TOOLKIT_DIR . "/dcm2pnm +Tn --write-tiff --use-window 1 \"" . $this->file . "\" \"" . $this->tiff_file . "\"";
      $out = Execute($convert_cmd);

      if(file_exists($this->tiff_file)) {
        $filesize = filesize($this->tiff_file);
      }

      if($filesize < 10) {
        $convert_cmd = TOOLKIT_DIR . "/dcm2pnm +Wm +Tn --write-tiff \"" . $this->file . "\" \"" . $this->tiff_file . "\"";
        $out = Execute($convert_cmd);
      }

      $convert_cmd = "convert -quality $jpg_quality \"" . $this->tiff_file . "\" \"" . $this->jpg_file . "\"";
      $out = Execute($convert_cmd);
      if(file_exists($this->tiff_file)) {
        unlink($this->tiff_file);
      }
    }
    else if(strstr($this->transfer_syntax, 'JPEG')) {

      if(strstr($this->transfer_syntax, 'Baseline') || strstr($this->transfer_syntax, 'Lossless')) {
        $jpg_quality = 100;
      }

      $convert_cmd = TOOLKIT_DIR . "/dcmj2pnm +oj +Jq $jpg_quality --use-window 1 \"" . $this->file . "\" \"" . $this->jpg_file . "\"";
      $out = Execute($convert_cmd);

      if(file_exists($this->jpg_file)) {
        $filesize = filesize($this->jpg_file);
      }

      if($filesize < 10) {
        $convert_cmd = TOOLKIT_DIR . "/dcmj2pnm +Wm +oj +Jq $jpg_quality \"" . $this->file . "\" \"" . $this->jpg_file . "\"";
        $out = Execute($convert_cmd);
      }
    }

    return($this->jpg_file);

  }

### REQUIRES IMAGE MAGICK
### Convert $this->file into a JPEG thumbnail.
  function dcm_to_tn() {
    $this->dcm_to_jpg();
    $this->tn_file = $this->jpg_file;
    $this->tn_file = preg_replace('/.jpg$/', '_tn.jpg', $this->tn_file);

    $convert_cmd = "convert -resize 125 -quality 75 \"" . $this->jpg_file . "\" \"" . $this->tn_file . "\"";
    $out = Execute($convert_cmd);
    return($this->tn_file);
  }

### This will uncompress $this->file. 
  function uncompress($new_file = '') {
    if(!$new_file) {
      $new_file = $this->file;
    }

    $uncompress_cmd = TOOLKIT_DIR . "/dcmdjpeg \"" . $this->file . "\" \"" . $new_file . "\"";
    $out = Execute($uncompress_cmd);
    return($new_file);
  }

// THIS REALLY SHOULD BE EXPANDED TO INCLUDE OTHER COMPRESSION OPTIONS
### This will JPEG losslessly compress $this->file 
  function compress($new_file = '') {
    if(!$new_file) {
      $new_file = $this->file;
    }

    $uncompress_cmd = TOOLKIT_DIR . "/dcmcjpeg \"" . $this->file . "\" \"" . $new_file . "\"";
    $out = Execute($uncompress_cmd);
    return($new_file);
  }


  function jpg_to_dcm($arr_info) {

  }

  function pdf_to_dcm($arr_info) {

  }

  function pdf_to_dcmsc($arr_info) {

  }




}


class dicom_net {

  var $transfer_syntax = '';
  var $file = '';

### 
  function store_server($port, $dcm_dir, $handler_script, $config_file, $debug = 0) {
    $dflag = '';
    if($debug) {
      $dflag = '-d -v ';
    }

    system(TOOLKIT_DIR . "/storescp $dflag -td 20 -ta 20 --fork -xf $config_file Default -od $dcm_dir -xcr \"$handler_script \"#p\" \"#f\" \"#c\" \"#a\"\" $port");
  }

###
  function echoscu($host, $port, $my_ae = 'DEANO', $remote_ae = 'DEANO') {
    $ping_cmd = TOOLKIT_DIR . "/echoscu -ta 5 -td 5 -to 5 -aet \"$my_ae\" -aec \"$remote_ae\" $host $port";
    $out = Execute($ping_cmd);
    if(!$out) {
      return(0);
    }
    return($out);
  }

### 
  function send_dcm($host, $port, $my_ae = 'DEANO', $remote_ae = 'DEANO', $send_batch = 0) {

    if(!$this->transfer_syntax) {
      $tags = new dicom_tag;
      $tags->file = $this->file;
      $tags->load_tags();
      $this->transfer_syntax = $tags->get_tag('0002', '0010');
    }

    $ts_flag = '';
    switch($this->transfer_syntax) {
      case 'JPEGBaseline':
        $ts_flag = '-xy';
      break;
      case 'JPEGExtended:Process2+4':
        $ts_flag = '-xx';
      break;
      case 'JPEGLossless:Non-hierarchical-1stOrderPrediction':
        $ts_flag = '-xs';
      break;
    }

    $to_send = $this->file;

    if($send_batch) {
      $to_send = dirname($this->file);
      $send_command = TOOLKIT_DIR . "/storescu -ta 10 -td 10 -to 10 $ts_flag -aet \"$my_ae\" -aec $remote_ae $host $port +sd \"$to_send\"";
    }
    else {
      $send_command = TOOLKIT_DIR . "/storescu -ta 10 -td 10 -to 10 $ts_flag -aet \"$my_ae\" -aec $remote_ae $host $port \"$to_send\"";
    }

    $out = Execute($send_command); 
    if($out) {
      return($out);
    }
    return(0);

  }


}

### CAPTURES ALL OF THE GOOD OUTPUTS!
function Execute($command) {

  $command .= ' 2>&1';
  $handle = popen($command, 'r');
  $log = '';

  while (!feof($handle)) {
    $line = fread($handle, 1024);
    $log .= $line;
  }
  pclose($handle);

  return $log;
}

?>