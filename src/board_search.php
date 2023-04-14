<?php 

define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/");
define( "URL_DB", DOC_ROOT."src/common/db_common.php" );

include_once( URL_DB );

function search_info($search_word)
{
    if (empty($_REQUEST["search_word"])) { // 검색어가 empty일 때 예외처리를 해준다.
        $search_word = "";
    } else {
        $search_word = $_REQUEST["search_word"];
    }

    $sql =
        " SELECT " .
        " board_no " .
        " ,board_title " .
        " ,board_write_date " .
        " FROM " .
        " board_info " .
        " WHERE " .
        " ( board_title LIKE '%$search_word%' ) " .
        " AND " .
        " board_del_flg = 0 ";
    $arr_prepare = array();
    try {
        db_conn($conn);
        $stmt = $conn->prepare($sql);
        $stmt->execute($arr_prepare);
        $result = $stmt->fetchAll();
    } catch (Exception $e) {
        return $e->getMassage();
    } finally {
        $conn = null;
    }
    return $result;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_1 = $_POST;
    $result_info = search_info($post_1["search_word"]);
} else {
    $result_info = array();
}

// var_dump($result_info);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style1.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>
<body style="text-align:center;" >
    

<table style="text-align:center ;" class='table table-striped'>
            <tr style="background-color : gray;" class = 'tr_1'>
                <th width = 150px;>게시글 번호</th>
                <th width = 600px>게시글 제목</th>
                <th width = 150px>작성일자</th>
            </tr>
    <?php
    foreach ($result_info as $recode) {
    ?>
 
        <tr>
            <th><?php echo $recode['board_no'] ?></th>
            <th><a href="board_detail.php?board_no=<?php echo $recode["board_no"]?>"><?php echo $recode['board_title'] ?></a></th>
            <th><?php echo $recode['board_write_date'] ?></th>
        </tr>
    <?php
    }
    ?>
</table>
<button  class="list_bt" type="submit"><a href="board_list.php"> 리스트 목록</a></button>
</body>
</html>