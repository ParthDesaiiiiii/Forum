<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to iDiscuss - Coding Forums</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <?php
    include 'partials/_header.php';
    ?>
    <?php
    include 'partials/_dbconnect.php';
    ?>
    <?php
    $id = $_GET['threadid'];
    $sql = "SELECT * FROM `threads` where thread_id = $id";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
    }
    ?>

    <?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method=="POST"){
        // Insert comment into db
        $comment = $_POST['comment'];
        $comment = str_replace("<",  "&lt;", $comment);
        $comment = str_replace(">", "&gt;", $comment);
        $sql = "INSERT INTO `comment` (`comment_content`, `thread_id`, `comment_by`, `comment_time`) VALUES ('$comment', '$id', '0', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if($showAlert){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your Comment has been added!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    }
    ?>

    <div class="container my-3">
        <div class="jumbotron">
            <h1 class="display-4"><?php echo $title; ?></h1>
            <p class="lead"><?php echo $desc; ?></p>
            <hr class="my-4">
            <p>This is a peer to peer forum for sharing knowledge with each other</p>
            <p class="lead">
            <p>Posted by: <b>Parth</b></p>
            </p>
        </div>
    </div>

    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
        echo '<div class="container">
            <h1 class="py-2">Post a Comment</h1>
            <form class="my-3" action="'. $_SERVER["REQUEST_URI"] .'" method="post">
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Type your comment</label>
                    <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Post Comment</button>
            </form>
        </div>';
    }
    else{
        echo '<div class="container">
        <h1 class="py-2">Post a Comment</h1>
        <p class="lead">You are not logged in. Please Login to be able to post a comments</p>
        </div>';
    }

    ?>

    <div class="container">
        <h1 class="py-2">Discussions</h1>
        <?php
        $id = $_GET['threadid'];
        $sql = "SELECT * FROM `comment` where thread_id = $id";
        $result = mysqli_query($conn, $sql);
        $noResult = true;
        while($row = mysqli_fetch_assoc($result)){
            $noResult = false;
            $id = $row['comment_id'];
            $content = $row['comment_content'];
            echo '<div class="media my-3">
            <img class="mr-3" src="img/user_image.webp" width="40px" alt="...">
            <div class="media-body" style="margin-left: 45px; margin-top: -35px;">
                '. $content .'
            </div>
        </div>';
        }
        if($noResult){
            echo '<div class="jumbotron jumbotron-fluid">
            <div class="container">
              <p class="display-4">No Threads Found</p>
              <p class="lead">Be the first person to ask the Questions.</p>
            </div>
          </div>';
        }
        ?>
    </div>

    <?php
    include 'partials/_footer.php';
    ?>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
    </script>
</body>

</html>