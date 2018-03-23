<?php
/**
 * 将非UTF-8字符集的编码转为UTF-8
 *
 * @param mixed $mixed 源数据
 *
 * @return mixed utf-8格式数据
 */
function charsetToUTF8($mixed)
{
    if (is_array($mixed)) {
        foreach ($mixed as $k => $v) {
            if (is_array($v)) {
                $mixed[$k] = charsetToUTF8($v);
            } else {
                $encode = mb_detect_encoding($v, array('ASCII', 'UTF-8', 'GB2312', 'GBK', 'BIG5'));
                if ($encode == 'EUC-CN') {
                    $mixed[$k] = iconv('GBK', 'UTF-8', $v);
                }
            }
        }
    } else {
        $encode = mb_detect_encoding($mixed, array('ASCII', 'UTF-8', 'GB2312', 'GBK', 'BIG5'));
        if ($encode == 'EUC-CN') {
            $mixed = iconv('GBK', 'UTF-8', $mixed);
        }
    }
    return $mixed;
}

//是否录像文件
function isVideo($file_name){
  $file_name_lower = strtolower($file_name);
  $preg_match_result = preg_match ('/mov|mp4|ogg/', $file_name_lower, $matches, PREG_OFFSET_CAPTURE);
  if( $preg_match_result ){
      return true;
  }
  return false;
}

//是否图片
function isImage($file_name){
  $file_name_lower = strtolower($file_name);
  $preg_match_result = preg_match ('/png|jpg|jpeg/', $file_name_lower, $matches, PREG_OFFSET_CAPTURE);
  if( $preg_match_result ){
      return true;
  }
  return false;
}

$video_array = array();
$image_array = array();

//读取video目录句柄
if($handle = opendir('video')){  

  while (false !== ($file = readdir($handle))){   
  if ($file != "." && $file != "..") {

      //有后缀的文件
      $utf_file_name = charsetToUTF8($file);

      // returns the portion of $utf_file_name which starts at the last occurrence of . and goes until the end of utf_file_name.
      $posfix = strrchr($utf_file_name, '.');

      //没有后缀的文件
      $utf_file_name_no_ext = basename($utf_file_name, $posfix);

      if (isVideo($utf_file_name)) {
        //video
        $video_array[$utf_file_name_no_ext] = $utf_file_name;
      }elseif (isImage($utf_file_name)) {
        //image
        $image_array[$utf_file_name_no_ext] = $utf_file_name;
      }else{
        echo "unhandle file:$utf_file_name<br>" ;
      }
      
    }  
  }   
  closedir($handle); 
}

var_dump($video_array); 
var_dump($image_array); 

foreach ($video_array as $file_no_ext => $file) {
 echo '<video src="video/'. $file .'" controls="controls" poster="video/'.$image_array[$file_no_ext].'">
您的浏览器不支持 video 标签。
</video>';
  echo $file . " ";
  echo $image_array[$file_no_ext];
  echo "<br>";
}
?>
