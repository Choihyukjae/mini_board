<?php
    define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/");
    define( "URL_DB", DOC_ROOT."src/common/db_common.php" );
    include_once( URL_DB );
    // Request method 를 획득
    $http_method = $_SERVER["REQUEST_METHOD"];

    //GET 체크
    // GET 일때
    if( $http_method === "GET")
    {
        $board_no = 1;
        if( array_key_exists( "board_no", $_GET ) )
        {
            $board_no = $_GET["board_no"];
        }
        $result_info = select_board_info_no( $board_no );
    }
    // POST 일때
    else
    {   
        $arr_post = $_POST;
        $arr_info = 
            array(
                "board_no" => $arr_post["board_no"]
                ,"board_title" => $arr_post["board_title"]
                ,"board_contents" => $arr_post["board_contents"]

            );
        // update
        $result_cnt = update_board_info_no( $arr_info );
        // select (업데이트 된걸 다시 호출)
        // $result_info = select_board_info_no( $arr_post["board_no"] ); // 0412del
        
        header( "Location: board_detail.php?board_no=".$arr_post["board_no"] );
        exit(); // 35행에서 rediret 했기 때문에 이후의 소스코드는 실행할 필요가 없다.
    }
    // print_r($result_info);

?>


<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>게시판</title>
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
<h1>게시물수정</h1>
    <form class="fo_1" method="post" action= "board_update.php">
        <label for=bno>게시글 번호 :</label>
        <input style="width:600px;" type="text" name="board_no" id="bno" value="<?php echo $result_info['board_no'] ?>"  readonly >
        <br>
        <label for=title>게시글 제목 :</label>
        <input style="width:600px;" type="text" name="board_title" id="title" value="<?php echo $result_info['board_title'] ?>" >
        <br>
        <label for="contents">게시글 내용 :</label>
        <input style="width:600px; height:300px;" class="fix" type="text" name="board_contents" id="contents" value="<?php echo $result_info['board_contents'] ?>" >
        <br>
        <div class="hhh" >
        <button class="up_bt" type="submit">수정</button>
        <button class="list_bt" type="button"> <a href="board_detail.php?board_no=<?php echo $result_info['board_no'] ?> "> 취소</a></button>
        </div>
    </form>
        <button class="list_bt" type="submit"><a href="board_list.php?board_no=<?php echo $result_info['board_no'] ?> "> 리스트 목록</a></button>
</body>
</html>