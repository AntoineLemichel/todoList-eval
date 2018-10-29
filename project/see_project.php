<!doctype html>
<html class="no-js" lang="fr-FR">
<?php
require("../bdd.php");

?>

<head>
  <meta charset="utf-8">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>Todo List -
    <?= $_GET['name']?>
  </title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <link rel="manifest" href="site.webmanifest">
  <link rel="apple-touch-icon" href="icon.png">
  <!-- Place favicon.ico in the root directory -->

  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../css/main.css">
  <link rel="stylesheet" href="../css/semantic.min.css">
  <link rel='stylesheet prefetch' href='https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.1.8/components/icon.min.css'>
  <link rel="stylesheet" href="../sass/style.css">
  <link rel="shortcut icon" href="../favicon.png" type="image/x-icon">
</head>

<body>
  <!--[if lte IE 9]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->

  <!-- Add your site or application content here -->
  <?php



  $req_list = $bdd->query('SELECT 
  -- SELECT TABLE PROJECT
  p.id AS project_id, 
  p.name AS project_name, 
  p.deadline AS project_deadline, 
  p.description AS project_description,

  -- SELECT TABLE LIST
  l.id AS list_id,
  l.id_project AS list_project_id,
  l.name AS list_name, 
  l.deadline AS list_deadline, 
  l.done AS list_done,

  -- SELECT TABLE TASK
  t.id AS task_id, 
  t.name AS task_name, 
  t.deadline AS task_deadline,
  t.list_id AS task_list_id,
  t.done AS task_done


  FROM project AS p 
  LEFT JOIN list AS l ON l.id_project = p.id
  LEFT JOIN task AS t ON t.list_id = l.id
  WHERE p.id =' . $_GET['index']
  );
  
  


  $req_list_simple = $bdd->query('SELECT 
  -- SELECT TABLE PROJECT
  p.id AS project_id, 
  p.name AS project_name, 
  p.deadline AS project_deadline, 
  p.description AS project_description,

  -- SELECT TABLE LIST
  l.id AS list_id,
  l.id_project AS list_project_id,
  l.name AS list_name, 
  l.deadline AS list_deadline, 
  l.done AS list_done,

  -- SELECT TABLE TASK
  t.id AS task_id, 
  t.name AS task_name, 
  t.deadline AS task_deadline,
  t.list_id AS task_list_id,
  t.done AS task_done


  FROM project AS p 
  LEFT JOIN list AS l ON l.id_project = p.id
  LEFT JOIN task AS t ON t.list_id = l.id
  WHERE p.id =' . $_GET['index']
  );
  

  $req_select_list = $bdd->query('SELECT * FROM list WHERE id_project =' . $_GET['index']);
  

  $data_list_simple = $req_list_simple->fetch();
  ?>
  <header>
    <nav>
      <div class="ui menu one item menu">
        <div class="header item center-menu">
          <a href="../index.php"><i class="home icon"></i>Home</a>
        </div>
      </div>
    </nav>
  </header>


  <ul class="breadcrumb">
    <li><a href="../index.php">Home</a></li>
    <li><a href="#">
        <?= $data_list_simple['project_name']?></a></li>
  </ul>

  <div class="container_detail">
    <div class="ui card">
      <div class="content">
        <div class="header">
          <span>
            <?= $data_list_simple['project_name']?></span>
        </div>
        <div class="meta">
          <span>Deadline in :
            <?= $data_list_simple['project_deadline']?></span>
        </div>
        <div class="description">
          <p>
            <?= $data_list_simple['project_description']?>
          </p>
        </div>
      </div>

      <table class="ui selectable celled table">
        <thead>
          <span class="ui header">
          </span>
          <tr>
            <th>List name</th>
            <th>Task name</th>
            <th>Deadline</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
            while($data_list = $req_list->fetch()){
              $dtz = new DateTimeZone("Europe/Paris"); //Your timezone
              $now = new DateTime(date("Y-m-d H:i:s"), $dtz);
              $deadline = new DateTime($data_list['task_deadline']);
              $interval = $now->diff($deadline);
          ?>
          <tr>
            <td>
              <?= $data_list['list_name']?>
            </td>
            <?php
              if($data_list['task_done'] == 1){
                ?>
            <td class="positive">
              <?= $data_list['task_name']?>
            </td>
            <?php
              } else {
                ?>
            <td>
              <?= $data_list['task_name']?>
            </td>
            <?php
              }
              if($deadline < $now AND $data_list['task_done'] == 0){
                ?>
            <td class="negative">
              <?= $data_list['task_deadline']?>
            </td>
            <?php
              } else {
            ?>
            <td>
              <?= $data_list['task_deadline']?>
            </td>
            <?php
            }
            ?>

            <td>
              <?php
                if ($data_list['task_done'] == 1) {
                ?>
              <a href="update/update_notdone_task.php?index=<?= $data_list['task_id']?>" class="ui orange button">Not
                done</a>
              <?php
                } else {

              ?>
              <a href="update/update_task.php?index=<?= $data_list['task_id']?>" class="ui green button">Done</a>

              <?php
                }
              ?>
              <a href="delete_task.php?index=<?= $data_list['task_id']?>&amp;index_list=<?= $data_list['list_id']?>" class="delete">Delete</a>
            </td>
          </tr>
          <?php
          }
          ?>
        </tbody>
      </table>

      <div class="extra content">
        <button class="ui blue button" id="settings_project"><i class="cogs icon"></i>Settings</button>
      </div>
    </div>
  </div>













  <div class="ui modal">
    <i class="close icon"></i>
    <div class="header">
      <span>Settings of
        <?= $data_list_simple['project_name'] ?></span>
    </div>
    <div class="ui placeholder segment">
      <div class="ui two column very relaxed stackable grid">
        <div class="column">
          <div class="ui form">
            <form action="insert/insert_list.php" method="post">
              <p class="ui header">Add list</p>
              <div class="field required">
                <label for="name_list">Name list :</label>
                <input placeholder="Name list" type="text" name="name_list" id="name_list">
              </div>
              <input type="hidden" name="index" value="<?= $_GET['index']?>">
              <input class="ui blue submit button" type="submit" value="Add list">
            </form>
          </div>
        </div>
        <div class="middle aligned column">
          <div class="ui form">
            <form action="insert/insert_task.php" method="post">
              <p class="ui header">Add task</p>
              <div class="field required">
                <label for="task_name">Name task :</label>
                <input placeholder="Name task" type="text" name="name_task" id="task_name">
              </div>
              <div class="field required">
                <label for="select_list">Select one list :</label>
                <select id="select_list" name="select_list">
                  <?php
                      while($data_select_list = $req_select_list->fetch()){
                  ?>
                  <option value="<?= $data_select_list['id'];?>">
                    <?= $data_select_list['name'];?>
                  </option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              <div class="field required">
                <label for="deadline_task">Deadline :</label>
                <input type="date" name="deadline_task" id="deadline_task">
              </div>
              <input class="ui blue submit button" type="submit" value="Add task">
            </form>
          </div>
        </div>
      </div>
      <div class="ui vertical divider">
        Or
      </div>
    </div>
  </div>











  <script src="../js/vendor/modernizr-3.6.0.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
    crossorigin="anonymous"></script>
  <script>
    window.jQuery || document.write('<script src="../js/vendor/jquery-3.3.1.min.js"><\/script>')

  </script>
  <script src="../js/plugins.js"></script>
  <script src="../js/main.js"></script>
  <script src="../js/semantic.min.js"></script>

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
