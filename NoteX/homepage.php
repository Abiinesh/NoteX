<?php
session_start();

$timeout = 5; // Set timeout minutes
$logout_redirect_url = "http://localhost/SimpleNote/index.php"; // Set logout URL

$timeout = $timeout * 60; // Converts minutes to seconds
if (isset($_SESSION['start_time'])) {
  $elapsed_time = time() - $_SESSION['start_time'];
  if ($elapsed_time >= $timeout) {
      session_destroy();
      header("Location: $logout_redirect_url");
  }
}
$_SESSION['start_time'] = time();



if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

/** @var Connection $connection */
$connection = require_once 'pdo.php';
// Read notes from database
$notes = $connection->getNotes();


$currentNote = [
    'note_id' => '',
    'user_id' => $_SESSION['id'],
    'title' => '',
    'description' => ''
];

if (isset($_GET['note_id'])) {
    $currentNote = $connection->getNoteById($_GET['note_id']);
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NoteX Homepage</title>
    <link rel="shortcut icon" type="image/png" href="favicon.png">
    <link rel="stylesheet" href="homepageStyle.css">
</head>

<body>

  <h2>Note<span class="x_color">X</span></h2>

  <div class="main_title">

    <?php echo "<h1>Welcome " . $_SESSION['username'] . "</h1>"; ?>

  </div>


    <div class="logout_btn">
      <a href="logout.php"><span></span></a>
    </div>


    <div class="grid_container">

      <div class="grid_item1">

	     <div class="container">

        <form class="new-note" action="create.php" method="post">

            <h1> Add Note </h1>

            <input type="hidden" name="note_id" value="<?php echo $currentNote['note_id'] ?>">
            <input type="hidden" name="user_id" value="<?php echo $currentNote['user_id'] ?>">

            <input type="text" name="title" placeholder="Note Title" autocomplete="off"
                   value="<?php echo $currentNote['title'] ?>">

            <textarea name="description" cols="30" rows="4"
                      placeholder="Note Description"><?php echo $currentNote['description'] ?></textarea>

            <div class="new_btn">
              <button>
                  <?php if ($currentNote['note_id']): ?>
                      Update Note
                  <?php else: ?>
                      Add Note
                  <?php endif ?>
              </button>
            </div>

        </form>

        </div>

        </div>

        <div class="grid_item2">

        <div class="container2">
        <div class="notes">

            <?php foreach ($notes as $note): ?>

                <div class="note">

                    <div class="title">
                        <a href="?note_id=<?php echo $note['note_id'] ?>">
                            <?php echo $note['title'] ?>
                        </a>
                    </div>

                    <div class="description">
                        <?php echo $note['description'] ?>
                    </div>

                    <small><?php echo date('d/m/Y H:i', strtotime($note['create_date'])) ?></small>

                    <form action="delete.php" method="post">

                        <input type="hidden" name="note_id" value="<?php echo $note['note_id'] ?>">
                        <button class="close">X</button>

                    </form>

                </div>
            <?php endforeach; ?>
        </div>
        </div>

        </div>

    </div>

</body>
</html>
