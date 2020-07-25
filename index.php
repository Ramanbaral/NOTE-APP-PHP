<?php
$server="localhost";
$username='root';
$password="";
$database="note_app";

$conn=mysqli_connect($server,$username,$password,$database);
if(!$conn)
    {
        die("sorry for the inconvience. some technical issue has occured.");
    }

$update=false;
    // to update note 
    if(isset($_POST['note_id']))
    {
      $updated_title=$_POST['updated_title'];
      $updated_note=$_POST['updated_note'];
      $note_id=$_POST['note_id'];
      
      $sql="UPDATE `usernote` SET `title` = '$updated_title', `note` = '$updated_note' WHERE `usernote`.`id` = $note_id";
      $update=mysqli_query($conn,$sql);
      
    }

$delete=false;
    // to delete note 
    if(isset($_POST['deletenote_id']))
    {
      $id=$_POST['deletenote_id'];
      $sql="DELETE FROM `usernote` WHERE `id` =$id;";
      $delete=mysqli_query($conn,$sql);
      
    }
    
    // to not to show error if result not created if method is get 
    $result=false;
    if($_SERVER['REQUEST_METHOD']=="POST" && isset($_POST['title']))
    {
    $title=$_POST['title'];
    $note=$_POST['note'];


    $sql=" INSERT INTO `usernote` (`title`, `note`, `timestamp`) VALUES ('$title', '$note', current_timestamp());";
    $result=mysqli_query($conn,$sql);

}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <link rel="stylesheet" href="style.css" />
    <link
      rel="stylesheet"
      href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
      integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk"
      crossorigin="anonymous"
    />

    <title>Beautiful Note</title>
  </head>
  <body>
  <!-- ########################################## TITLE ################################################# -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="/">Beautiful Note</a>
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="#"
              >Home <span class="sr-only">(current)</span></a
            >
          </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <input
            class="form-control mr-sm-2"
            type="search"
            placeholder="Search"
            aria-label="Search"
          />
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">
            Search
          </button>
        </form>
      </div>
    </nav>
<!-- ########################################## TITLE ################################################# -->

<?php
    if($result)
    {
    print   " <!-- ######################################## alert ######################################### -->
        <div
          class='alert alert-success alert-dismissible fade show mb-0'
          role='alert'
        >
          <strong>Success!</strong>Your note is successfully created
          <button
            type='button'
            class='close'
            data-dismiss='alert'
            aria-label='Close'
          >
            <span aria-hidden='true'>&times;</span>
          </button>
        </div>
        <!-- ######################################## alert ######################################### -->";
    }
?>

<?php
    if($update)
    {
    print   " <!-- ######################################## alert ######################################### -->
        <div
          class='alert alert-success alert-dismissible fade show mb-0'
          role='alert'
        >
          <strong>Success!</strong>Your note is successfully updated
          <button
            type='button'
            class='close'
            data-dismiss='alert'
            aria-label='Close'
          >
            <span aria-hidden='true'>&times;</span>
          </button>
        </div>
        <!-- ######################################## alert ######################################### -->";
    }
?>

<?php
    if($delete)
    {
    print   " <!-- ######################################## alert ######################################### -->
        <div
          class='alert alert-danger alert-dismissible fade show mb-0'
          role='alert'
        >
          <strong>Deleted!</strong>Your note is successfully deleted
          <button
            type='button'
            class='close'
            data-dismiss='alert'
            aria-label='Close'
          >
            <span aria-hidden='true'>&times;</span>
          </button>
        </div>
        <!-- ######################################## alert ######################################### -->";
    }
?>

    <div class="container">

      <h1 style="text-align: center; font-size: 70px;" class="mt-1">
        Welcome to Note App
      </h1>

      <h3 class="mt-4" style="font-size: 25px;">Create your note here:</h3>

<!-- ##################################### FORM TO CREATE NOTE  ######################################### -->
      <div class="form">
        <form action="index.php" method="POST">
          <label for="title">Title</label>
          <input
            type="text"
            class="form-control"
            id="title"
            placeholder="@title"
            name="title"
            required
          />

          <label for="note" class="mt-4">Your note:</label>
          <textarea
            class="form-control"
            id="note"
            rows="3"
            name="note"
            required=""
            style="margin-top: 0px; margin-bottom: 0px; height: 316px;"
          ></textarea>

          <button
            type="submit"
            class="btn btn-outline-info mt-3"
            style="display: block; margin: auto; width: 300px;"
          >
            Create
          </button>
          <button
            type="reset"
            class="btn btn-outline-info mt-2"
            style="display: block; margin: auto; width: 300px;"
          >
            Reset
          </button>
        </form>
      </div>
  <!-- ##################################### FORM TO CREATE NOTE  ######################################### -->
    </div>

    <div class="container  mt-4 mb-3 " id="cards">
      <!-- ########################################  CARDS  ##############################################  -->
    <?php
        $sql="SELECT * FROM `usernote`;";
        $notes=mysqli_query($conn,$sql);

        // !$notes ||
        if( mysqli_num_rows($notes)==0)
        {
            print "<h2>No Notes to show</h2>";
        }
        else{
            
            while($n=mysqli_fetch_assoc($notes)){
                print '<div class="card bg-light mb-3 note" style="margin-left:15px;margin-top:10px">
                <div class="card-header">'.$n['title'].'</div>
                <div class="card-body">
                <span>'.$n['timestamp'].'</span>
                  <p class="card-text">
                    '.$n['note'].'
                  </p>
                  <button class="btn btn-outline-info mr-5 mt-4 updatebtn" data-toggle="modal" data-target="#updateModal" data-id='.$n['id'].'>Edit</button>
                  <form action="index.php" method="POST" id="delete_form" style="display: inline;">
                    <input type="hidden" id="deletenote_id" name="deletenote_id" value='.$n['id'].'>
                  <button class="btn btn-outline-info ml-4 mt-4 deletebtn" data-id='.$n['id'].' type="submit">Delete</button>
                </form>
                </div>
              </div>';
            }
        }
    ?>

<!-- ########################################  CARDS  ###################################################-->
    </div>
<!-- ############################################## FOOTER ################################################ -->
<hr>
<footer class="container">
    <p class="float-right"><a href="#">Back to top</a></p>
    <p>© 2019-2020 Beutiful Note, Inc. · <a href="#">Privacy</a> · <a href="#">Terms</a></p>
  </footer>

<!-- ############################################## FOOTER ################################################ -->


<!--########################################### Update Modal ################################################-->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
  <form action="index.php" method="POST">
  <div class="form-group">
    <label for="updated_title">Title</label>
    <input type="text" class="form-control" id="updated_title" name="updated_title">
  </div>

  <div class="form-group">
    <label for="updated_note">Note</label>
    <textarea class="form-control" id="updated_note" rows="3" name="updated_note" style="height: 416px;"></textarea>
  </div>
  <input type="hidden" name="note_id" id="note_id" value="">
  <button type="submit" class="btn btn-primary">Update</button>
</form>
      </div>
    </div>
  </div>
</div>
<!--########################################### Update Modal ################################################-->

<script>
let updatebtns=document.getElementsByClassName('updatebtn');
updatebtns=Array.from(updatebtns);
updatebtns.forEach(element =>{

  element.addEventListener('click',(e)=>{
    card=e.target.parentNode.parentNode;
    
    //getting previous information of the note to be updated
    let title=card.getElementsByTagName('div')[0].innerText;
    let note=e.target.previousElementSibling.innerText;
    let btn_id=e.target.getAttribute('data-id');

    updated_title.value=title;
    updated_note.value=note;
    note_id.value=btn_id;
    
  });

})

</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</body>
</html>

