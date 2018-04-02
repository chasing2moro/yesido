<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>AnXinImage</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="carousel.css" rel="stylesheet">

        <!--自定义配置-->
    <script src="js/config.js"></script>
    
  </head>
  <body style="padding-top: 0.2rem !important;">


    <script>document.write(G_NavHeader)</script>

    <div class="container-fluid">
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



//是否图片
function isImage($file_name){
  $file_name_lower = strtolower($file_name);
  $preg_match_result = preg_match ('/png|jpg|jpeg/', $file_name_lower, $matches, PREG_OFFSET_CAPTURE);
  if( $preg_match_result ){
      return true;
  }
  return false;
}


$image_array = array();

//读取video目录句柄
if($handle = opendir('image')){  

  while (false !== ($file = readdir($handle))){   
  if ($file != "." && $file != "..") {

      //有后缀的文件
      $utf_file_name = charsetToUTF8($file);

      // returns the portion of $utf_file_name which starts at the last occurrence of . and goes until the end of utf_file_name.
      $posfix = strrchr($utf_file_name, '.');

      //没有后缀的文件
      $utf_file_name_no_ext = basename($utf_file_name, $posfix);

      if (isImage($utf_file_name)) {
        //image
        $image_array[$utf_file_name_no_ext] = $utf_file_name;
      }else{
        echo "unhandle file:$utf_file_name<br>" ;
      }
      
    }  
  }   
  closedir($handle); 
}


//var_dump($image_array); 

krsort($image_array);//降序排序

foreach ($image_array as $file_no_ext => $file) {
  echo $file_no_ext . "<br>";
  echo '<image class="img-fluid" src="image/'. $file .'" ></image>';
  echo "<hr>";
}
?>


    </div>

    <script>
      document.write(G_BeiAn);
    </script>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="assets/js/vendor/popper.min.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
    <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
    <script src="assets/js/vendor/holder.min.js"></script>



    <script>



      $(
  
        function () {

          //导航条激活状态
          $("#tag-image .nav-link").attr("href", "#");
          $("#tag-image").addClass("active");
        });
    </script>
  </body>
</html>
