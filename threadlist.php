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
    $id = $_GET['catid'];
    $sql = "SELECT * FROM `categories` where category_id = $id";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_assoc($result)){
        $catname = $row['category_name'];
        $catdesc = $row['category_description'];
    }
    ?>

    <?php
    $showAlert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method=="POST"){
        // Insert thread into db
        $th_title = $_POST['title'];
        $th_desc = $_POST['desc'];

        $th_title = str_replace("<",  "&lt;", $th_title);
        $th_title = str_replace(">", "&gt;", $th_title);

        $th_desc = str_replace("<",  "&lt;", $th_desc);
        $th_desc = str_replace(">", "&gt;", $th_desc);

        $sql = "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '0', current_timestamp())";
        $result = mysqli_query($conn, $sql);
        $showAlert = true;
        if($showAlert){
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Your thread has been added! Please wait for community to respond.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>';
        }
    }
    ?>

    <div class="container my-3">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $catname; ?> Forums</h1>
            <p class="lead"><?php echo $catdesc; ?></p>
            <hr class="my-4">
            <p>This is a peer to peer forum for sharing knowledge with each other</p>
            <p class="lead">
                <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
            </p>
        </div>
    </div>

    <?php
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
        echo '<div class="container">
            <h1 class="py-2">Start a Discussion</h1>
            <form class="my-3" action="'. $_SERVER["REQUEST_URI"] .'" method="post">
    <div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">Problem Title</label>
        <input type="text" class="form-control" id="exampleInputEmail1" id="title" name="title"
            aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text">Keep your title as short and crisp as possible.</div>
    </div>
    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Elaborate your Problem</label>
        <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
    </div>
    <button type="submit" class="btn btn-success">Submit</button>
    </form>
    </div>';
    }
    else{
    echo '<div class="container">
            <h1 class="py-2">Start a Discussion</h1>
            <p class="lead">You are not logged in. Please login to be able to start a discussion.</p>
          </div>';
    }
    ?>

    <div class="container">
        <h1 class="py-2">Browse Questions</h1>
        <?php
        $id = $_GET['catid'];
        $sql = "SELECT * FROM `threads` where thread_cat_id = $id";
        $result = mysqli_query($conn, $sql);
        $noResult = true;
        while($row = mysqli_fetch_assoc($result)){
            $noResult = false;
            $id = $row['thread_id'];
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            echo '<div class="media my-3">
            <img class="mr-3" src="img/user_image.webp" width="40px" alt="...">
            <div class="media-body" style="margin-left: 45px; margin-top: -35px;">
                <h5 class="mt-0"><a class="text-dark" href="thread.php?threadid='. $id .'">'. $title .'</a></h5>
                '. $desc .'
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