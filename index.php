<!doctype html>
<html class="no-js" lang="fr-FR">

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Todo List</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">
  <!-- Place favicon.ico in the root directory -->

  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/main.css">
  <link rel="stylesheet" href="css/semantic.min.css">
  <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.1.8/components/icon.min.css'>
  <link rel="stylesheet" href="sass/style.css">
  <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
</head>

<body>
  <!--[if lte IE 9]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->

  <!-- Add your site or application content here -->
  <header>
    <nav>
      <div class="ui menu one item menu">
        <div class="header item center-menu">
          <a href="index.php"><i class="home icon"></i>Home</a>
        </div>
      </div>
    </nav>
  </header>


  <div class="ui one column stackable center aligned page grid">
    <div class="column twelve wide">
      <button class="ui button green add_project" id="add_project">
        <i class="plus square icon"></i>Add project
      </button>
    </div>
  </div>
  <div class="container-index">
    <?php
  require("bdd.php");
  $req = $bdd->query('SELECT * FROM project');

  while($data = $req->fetch()){

  $deadline = new DateTime($data['deadline']);
  $datecreate = new DateTime($data['datetime']);

  $interval = $datecreate->diff($deadline);

?>
    <div class="ui cards">
      <div class="card">
        <div class="content">
          <div class="header">
            <span>
              <?= $data['name']; ?></span>
          </div>
          <div class="meta">
            <span>50 %</span>
            <?php
            if($deadline < $datecreate){
              ?>
              <div class="ui top right attached">
                <span class="ui ribbon label red">Failure</span>
              </div>
              <?php
            } else {
              ?>
              <div class="ui top right attached">
                <span class="ui ribbon label orange">Working</span>
              </div>
              <?php
            }
            ?>
          </div>
          <div class="description">
            <p>
              <?= $data['description']; ?>
            </p>
          </div>
        </div>
        <div class="extra content ui grid two column">
          <div class="tree wide column">
            <a href="project/see_project.php?index=<?= $data['id']?>&amp;name=<?= $data['name']?>" class="ui green button">See</a>
          </div>
          <div class="tree wide column">
            <a href="delete/delete_project.php?index=<?= $data['id']?>" class="delete">Delete</a>
          </div>
        </div>
        <div class="meta">
          <span>Deadline in :
            <?= $interval->format('%R%a days');?></span>
          <span>Create at :
            <?= $data['datetime']; ?></span>
        </div>
      </div>
    </div>


    <?php }?>
  </div>



  <div class="ui modal">
    <i class="close icon"></i>
    <div class="header">
      <span>Add project</span>
    </div>
    <div class="ui container">
      <form class="ui form" action="insert/insert_project.php" method="POST">
        <div class="field required">
          <label>Project name :</label>
          <input type="text" name="name" placeholder="First Name" required>
        </div>
        <div class="field required">
          <label>Deadline :</label>
          <input type="date" name="deadline" required>
        </div>
        <div class="field required">
          <label>Description :</label>
          <textarea name="description" cols="20" rows="4"></textarea>
        </div>
        <div class="actions">
          <div class="ui red deny button">
            <span>Cancel</span>
          </div>
          <button class="ui positive right labeled icon button" type="submit">
            <span>Create</span>
            <i class="checkmark icon"></i>
          </button>
        </div>
      </form>
    </div>
  </div>


  <script src="js/vendor/modernizr-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>
  <script>
    window.jQuery || document.write('<script src="js/vendor/jquery-3.3.1.min.js"><\/script>')

  </script>
  <script src="js/plugins.js"></script>
  <script src="js/main.js"></script>
  <script src="js/semantic.min.js"></script>

  <!-- Google Analytics: change UA-XXXXX-Y to be your site's ID. -->
  <script>
    window.ga = function () {
      ga.q.push(arguments)
    };
    ga.q = [];
    ga.l = +new Date;
    ga('create', 'UA-XXXXX-Y', 'auto');
    ga('send', 'pageview')

  </script>
  <!-- <script src="https://www.google-analytics.com/analytics.js" async defer></script> -->
</body>

</html>
