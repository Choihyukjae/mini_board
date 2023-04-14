<?php
define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/");
define( "URL_DB", DOC_ROOT."src/common/db_common.php" );
define( "URL_HEADER", "board_header.php" );
include_once( URL_DB );

$http_method = $_SERVER["REQUEST_METHOD"];

if ( $http_method === "POST"  )
{
    $arr_post = $_POST ;

    $result_cnt = insert_board_info_no( $arr_post );

    header( "Location: board_list.php" );
    exit();
}

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시글작성</title>
    <link rel="stylesheet" href="style1.css">
    <style>
        body{
            text-align : center;
            margin : 50px;
        }
        input{
            text-align : center;
        }
        .list_bt{
            background-color : #cdfcbd;
        }
        .up_bt{
            background-color : #cdfcbd;
        }
        .fo_1{
        }
    </style>
</head>
<body>
<?php include_once( URL_HEADER ) ?>
    <form class="fo_1" method="post" action= "board_insert.php">
        <label for=title>게시글 제목 :</label>
        <input style="width:600px;" type="text" name="board_title" id="title" >
        <br>
        <label for="contents">게시글 내용 :</label>
        <input style="width:600px; height:300px;" class="fix" type="text" name="board_contents" id="contents">
        <br>
        <div class="hhh" >
        <button class="up_bt" type="submit">작성</button>
        <button class="list_bt" type="button"> <a href="board_list.php"> 취소</a></button>
        </div>
    </form>


</body>
</html>