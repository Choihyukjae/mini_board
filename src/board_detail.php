<?php
define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/");
define( "URL_DB", DOC_ROOT."src/common/db_common.php" );
include_once( URL_DB );

// Request Parameter 획득(GET)
$arr_get = $_GET;

// DB에서 게시글 정보 획득
$result_info = select_board_info_no($arr_get["board_no"]);

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail</title>
    <style>
        body{
            text-align : center;
        }
        div{
            display : inline-block;
            text-align : center;
        }
        p{
            border : solid 1px black;
            width :600px;
            text-align : center;
        }
        .p_1{
            width :600px;
            height:300px;
        }
    </style>
</head>
<body>
    <div>
        <p>게시글 번호 : <?php echo $result_info["board_no"]  ?><br></p>
        <p>작성일 : <?php echo $result_info["board_write_date"]  ?><br></p>
        <p>게시글 제목 : <?php echo $result_info["board_title"]  ?><br></p>
        <p class="p_1">게시글 내용 : <?php echo $result_info["board_contents"]  ?><br></p>
    
    <button type="button"> 
        <a href="board_update.php?board_no=<?php echo $result_info["board_no"] ?>">
        수정
        </a>
        </button>
    <button type="button"> 
        <a href="board_delete.php?board_no=<?php echo $result_info["board_no"] ?>">
        삭제
        </a> 
    </button>
    </div>


</body>
</html>