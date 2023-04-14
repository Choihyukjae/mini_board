<?php
    define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/");
    define( "URL_DB", DOC_ROOT."src/common/db_common.php" );

    include_once( URL_DB );
    $http_method = $_SERVER["REQUEST_METHOD"];
    //겟체크
    if( array_key_exists( "page_num", $_GET ) )
    {
        $page_num = $_GET["page_num"];
    }
    else
    {
        $page_num = 1; 
    }

    $limit_num = 5;


    //게시판 정보 테이블 전체 카운트 획득개이득
    $result_cnt = select_board_info_cnt();
    
    // max page number
    $max_page_num = ceil( (int)$result_cnt[0]["cnt"] / $limit_num) ;

    // offset
    $offset = ( $page_num * $limit_num ) - $limit_num ;

    $arr_prepare =
        array(
            "limit_num" => $limit_num
            ,"offset"   => $offset
        );
        $result_paging = select_board_info_paging( $arr_prepare );
        // print_r( $max_page_num );

?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="style1.css">
    <title>게시판</title>
    <style>
        body {
            background-image : url('kkkkk.png') ;
            background-repeat : no-repeat;
            background-repeat : cover;
        }
        a{  
            color : black;
            font-size : 20px;
        }
    </style>
</head>
<body>
<h1>주식 게시판</h1>

    <script>
if (!sessionStorage.getItem('visited')) 
    {
        var name = prompt('이름을 입력하세요','4글자 이하로 입력해주세요');
        sessionStorage.setItem('visited', true);
    }
    </script>
        <div class="kosdaq">
    <a class="btn btn-outline-primary" href="https://m.stock.naver.com/domestic/index/KOSPI/total" target="_blank" >코스피지수 보기</a>
    <a class="btn btn-outline-primary" href="https://m.stock.naver.com/domestic/index/KOSDAQ/total" target="_blank">코스닥지수 보기</a>
    </div>

    <button class="insert_1" type="button" > <a href="board_insert.php">게시글 작성</a> </button>

    <div class='table table-striped'>
        <div class='div_2'>환영합니다 <script> document.write(name)</script> 님</div>
    <table class='table table-striped'>
        <thead>
            <tr style="background-color : gray;" class = 'tr_1'>
                <th width = 150px;>게시글 번호</th>
                <th width = 600px>게시글 제목</th>
                <th width = 150px>작성일자</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach ($result_paging as $recode ) 
                {
            ?>      
                    <tr>
                    <td><?php echo $recode["board_no"]?></td>
                    <td><a href="board_detail.php?board_no=<?php echo $recode["board_no"] ?>"><?php echo $recode["board_title"]?></td>
                    <td> <?php echo $recode["board_write_date"]?></td>
                    </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
    </div>
    <div class='div_1'>
    <a class='btn btn-outline-success'  href='board_list.php?page_num=1'>처음으로</a>
    <?php
        for( $i = 1; $i <= $max_page_num; $i++)
        {
    ?>
            <a class='btn btn-outline-success'  href='board_list.php?page_num=<?php echo $i ?>'><?php echo $i; ?></a>
    <?php
        }
    ?>
    <a class='btn btn-outline-success'  href='board_list.php?page_num=<?php echo $max_page_num ?>'>마지막으로</a>
    </div>
    <div class='div_4'>
    <select name="search_scope">
							<option value="everything">전체</option>
							<option value="subject">게시글 제목</option>
							<option value="problem">게시글 번호</option>
							<option value="author">작성일자</option>
	</select>
    <?php
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
    $arr_post = $_POST;
    $result_info = search_info($arr_post["search_word"]);
} else {
    $result_info = array();
}
?>
<form method="POST" action="board_search.php">
    <input type="text" name="search_word" placeholder="입력해주세요" value="">
    <button type="submit">검색</button>
</form>
</div>

</body>
</html>