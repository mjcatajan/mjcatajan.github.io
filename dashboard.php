<?php
 session_start();

require_once 'classes/database-query.php';
require_once 'classes/utility.class.php';
	

// GET USER'S INFORMATION VIA SESSION ID
$query = new Query;
$userID = $_SESSION['id_user'];
$userInfo = $query->getRow("SELECT * FROM users WHERE id_user = ?", ["$userID"]);

// VERIFY USER'S STATUS / AUTHENTICATION
$getAuthStatus = $query->verifyAuthUser($userID);
if($getAuthStatus){
    $authStatus    = $getAuthStatus['verify'];
    if($authStatus == 2){$authIcon = '<span><img src="badges/admin-check.png" alt="" class="badges"></span>';}elseif($authStatus == 1){$authIcon = '<span><img src="badges/verified-check.png" alt="" class="badges"></span>';}else{$authIcon = null;}
}

// RETRIEVES THE USER'S DISPLAY PICTURE AND COVER PHOTO
$utility = new Utility;
$userPic = $utility->retrievePic($userInfo[0]['gender'], $userInfo[0]['dp'], $userInfo[0]['cover']);
$pathUserDp = $userInfo[0]['gender']."/".$userPic[0];

?>

<!DOCTYPE HTML>


<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <link rel="stylesheet" type="text/css" href="css/homepage-navbar.css">
        <link rel="stylesheet" type="text/css" href="css/dashboard.css">
        
        <title>Admin Dashboard | Gamingcomm</title>
        <link rel="icon" href="icons/logo.png">


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    </head>

    <body>

    <style> /* FOR TRIGGERING JS MENU DROPDOWN */
		.show {
			display: block;
		}
	</style>
    
    <div class="overlay-modal-1">
        <div class="wrapper-view-user">
            <div class="view-user-container">

                <div class="view-header-title">
                    <span>View User</span>
                    <img src="icons/close.png" alt="">
                </div>

                <div class="body-viewuser-container">
                    <div class="IMGF01">
                        <div class="IMGF01-COVER" >
                            <img src="pictures/Female/chun li.jpg" alt="">
                        </div>
                        <div class="IMGF01-DP">
                            <img src="pictures/Female/chun li.jpg" alt="">
                        </div>
                    </div>

                    <div class="NAME01">
                        <span></span>
                        <p></p>
                    </div>
            
                    <div class="ELEMENTS01">
                        <div><label>Posts</label> <br> <span id="view-posts-count">13</span></div>
                        <div><label>Games</label> <br> <span>200</span></div>
                        <div><label>Following</label> <br> <span>139</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="overlay-updateuser">
        <div class="updateuser-container">
            <div style="display: flex; justify-content: space-between; border-bottom: 1px solid #fff">
                <div></div>
                <div style="padding-bottom: 10px; ">
                    <h2 style="color:#2FF761">Update User</h2>
                </div>
                <div>
                    <span><img src="icons/close.png" alt="" style="width: 15px; height: 15px; object-fit: cover; position: relative; top: 10px; filter: invert(1) "></span>
                </div>
            </div>
               
            <div style="padding-top: 20px; display: grid; grid-template-columns: 1fr 1fr; column-gap: 30px;">
                <label for="update_firstname">Firstname</label>
                <label for="update_lastname">Lastname</label>
                <input type="text" id="update_firstname" style="padding: 5px 15px; border-radius: 5px; ">
                <input type="text" id="update_lastname" style="padding: 5px 15px; border-radius: 5px; ">
            </div>

            <div style="padding: 20px 150px; display: grid; grid-template-columns: 1fr; column-gap: 30px;">
                <label for="update_email">Email</label>
                <input type="text" id="update_email" style="padding: 5px 15px; border-radius: 5px; ">
            </div>

            <div style="display: flex; justify-content: center; padding-top: 20px;">
                <button id="cancelUpdateUser" style="background: transparent; color: #2FF761; border: none; ">Cancel</button>
                <button id="confirmUpdateUser" style="padding: 12px 12px; background-color: #2FF761; border: none; margin-left: 3%; border-radius: 5px; ">Update</button>
            </div>
        </div>
    </div>

    <div class="overlay-deletecomment">
        <div class="deleteAlertComment">
            <div style="width: 100%; text-align: center; padding: 15px; border-bottom: 1px solid #fff; display: flex; justify-content: space-between;" >
                
                <div></div>

                <h2 id="confirmTitle"></h2>

                <div>
                    <span><img src="icons/close.png" alt="" style="width: 15px; height: 15px; object-fit: cover; filter: invert(1); position: relative; top: 5px;" ></span>
                </div>
            </div>
            
            <div style="width: 100%; padding: 15px; font-size: 15px;">
                <p id="confirmMsg"></p>

                <div style="width: 100%; padding: 15px; display: flex; justify-content: end;  ">
                    <button id="cancelDeleteComment"style="color: #2FF761; background-color: transparent; border: none; padding: 12px 12px; cursor: pointer; "> Cancel </button>
                    <button id="confirmDeleteComment" style="padding: 0px 40px; background-color:#2FF761; border: none; border-radius: 5px; cursor: pointer;" > Delete </button>
                </div>
            </div>
        </div>
    </div>

    <div class="overlay-viewpost">
        <div style="padding: 20px; position: fixed; top: 10%; left: 30%; background: #484848; width: 40%; min-height: 500px; color: #fff" >
            <div style="text-align: center;  border-bottom: 1px solid #fff; display: flex; justify-content: space-between;">
                <div></div>
                <h2 style="color:#2FF761">View Post</h2>
                <span><img src="icons/close.png" id="close-viewpost" alt="" style="width: 15px; height: 15px; object-fit: cover; position: relative; top: 10px; filter: invert(1); cursor: pointer;"></span>
            </div>
            <div style="display: flex; justify-content: center; padding: 20px; " >
                <div style="display: flex; ">
                    <p style="font-weight: 700;">Name: </p>
                    <p id="post_username" style="padding: 0 15px; "></p>
                </div>

                <div style="display: flex; padding-left: 20px; ">
                    <p  style="font-weight: 700">Date Posted: </p>
                    <p id="post_date" style="padding: 0 15px; ">January 15, 2023</p>
                </div>
            </div>

            <div style="display: flex; padding: 0 0 20px 0; justify-content: center;">
                <p  style="font-weight: 700">Game: </p>
                <p id="post_game" style="padding: 0 15px; "></p>
            </div>

            <div style="padding: 20px 50px; border: 1px solid #fff; border-radius: 5px; min-height: 300px;  ">
                <div>
                    <p  style="font-weight: 700">Title: </p>
                    <p id="post_title"></p>
                </div>

                <div style="margin-top: 35px; width: 100%; word-break: break-all; ">
                    <p style="font-weight: 700">Content: </p>
                    <p id="post_content"></p>
                </div>
            </div>
        </div>
    </div>

        <div class="overlay">
            <div class="overlay-unclickable">
            <header>
            <div class="navbar-brandlogo">
                <img src="icons/logo.png">
                <a href="homepage.php" class="brand">GAMING<span>comm</span></a>
            </div>

            <div class="list-of-header-buttons">
                <div class="container-list-header-buttons">
                    <div class="header-button-1">
                        <img src="icons/hot-sale.png" alt="">
                    </div>

                    <div class="header-button-2">
                        <img src="icons/games.png" alt="">
                    </div>

                    <div class="header-button-3">
                        <img src="icons/magnifying-glass.png" alt="">
                    </div>
                </div>
            </div>

            <div class="wrapper-dropdown stayput" onclick="closeandopen()" id="clicks">
                <div class="container-dropdown stayput" id="clicks">
                    <div>
                        <img src="pictures/<?php echo $pathUserDp?>" alt="" class="dropdown-image stayput" id="clicks">
                    </div>
                    <div class="dropdown-user-info stayput" id="clicks">
                        <span class="stayput" id="clicks"><?php echo $userInfo[0]['first_name']." ".$userInfo[0]['last_name']?></span>
                        <img src="icons/arrow-down-white.png" alt="" class="dropdown-arrow stayput" id="clicks rotateArrowMenu">
                    </div>
                </div>
                <div class="container-links" id="toggleOpenClose">
                        <?php 
                            if(!empty($authStatus)){
                                if($authStatus == 2){ echo '<a href="dashboard.php" style="color: #2FF761 !important; "><img src="icons/security.png" alt="" class="stayput fix-icon-dropdown "> Admin Dashboard</a>';}
                            }
                        ?>
                        <a href="viewprofile.php"><img src="icons/user.png" alt="" class="stayput fix-icon-dropdown "> View Profile</a>
                        <a href="#"><img src="icons/settings.png" alt="" class="stayput fix-icon-dropdown "> Settings</a>
                        <a href="#"><img src="icons/support.png" alt="" class="stayput fix-icon-dropdown "> Get Support</a>
                        <a href="includes/logout.php"><img src="icons/logout.png" alt="" class="stayput fix-icon-dropdown">Log Out</a>
                </div>
            </div>
            </header>
            </div>

            <div class="admin-dash">
                <div class="dashboard">
                    <div class="dash-list">
                        <div class="dash-content-1" >
                            <h2 class="dash-head">User counts</h2>
                            <h1 id="userCount"></h1>
                        </div>
                        <div class="dash-content-2">
                            <h2 class="dash-head">Post counts</h2>
                            <h1 id="postCount"></h1>
                        </div>
                        <div class="dash-content-3">
                            <h2 class="dash-head">Game counts</h2>
                            <h1 id="gameCount"></h1>
                        </div>
                    </div>
                </div>

                <div class="table-wrapper">
                    <div class="table-user">
                        <h2 id="account">Accounts Management</h2>
                        <input type="text" id="mySearch" placeholder="Search..." title="Type in a name">

                        <table id="userTable" class="table-user-data">
                        
                        </table>

                    </div>

                    <div class="table-post">
                        <h2 id="post">Posts Management</h2>
                        <input type="text" id="mySearch1" onkeyup="myFunctionPost()" placeholder="Search.." title="Type in a name">

                        <table id="postTable" class="table-post-data" >
                            
                            
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
    </body>
</html>

<script src="js/compose-post.js?<?php echo time();?>"></script>

<script>
    $(document).ready(function(){

        $(".header-button-2").click(function(){
            location.href="homepage.php";
         });

        $.ajax({
            url: "includes/server-process/dashboard-process.php",
            method: "POST",
            data: {showUserData: ''},
            cache: false,
            success: function(data){
                $("#userTable").html(data);
            }
        })

        $.ajax({
            url: "includes/server-process/dashboard-process.php",
            method: "POST",
            data: {showPostData: ''},
            cache: false,
            success: function(data){
                $("#postTable").html(data);
            }
        })

        $.ajax({
            url: "includes/server-process/dashboard-process.php",
            method: "POST",
            data: {showUserCount: ''},
            cache: false,
            success: function(data){
                $("#userCount").text(data);
            }

        })

        $.ajax({
            url: "includes/server-process/dashboard-process.php",
            method: "POST",
            data: {showPostCount: ''},
            cache: false,
            success: function(data){
                $("#postCount").text(data);
            }

        })

        $.ajax({
            url: "includes/server-process/dashboard-process.php",
            method: "POST",
            data: {showGameCount: ''},
            cache: false,
            success: function(data){
                $("#gameCount").text(data);
            }

        })

        $(document).on("click", ".action-button-1", function(){

            let view_id = this.id;
            
            $.ajax({
                url: "includes/server-process/dashboard-process.php",
                method: "POST",
                data: {view_userprofile: '', view_id: view_id},
                dataType: "json",
                cache: false,
                success: function(data){
                    
                    $(".NAME01 span").text(data[1]);
                    $(".NAME01 p").text(data[2]);
                    $(".IMGF01-COVER img").attr("src", "pictures/"+data[4]);
                    $(".IMGF01-DP img").attr("src", "pictures/"+data[3]);
                    $("#view-posts-count").text(data[0]);

                    $(".wrapper-view-user").fadeIn("slow").show();
                    $(".overlay-modal-1").fadeIn("slow").show();
                }
            });

           
        }).on("click", ".view-header-title img", function(){
            $(".wrapper-view-user").fadeOut("slow").hide();
            $(".overlay-modal-1").fadeOut("slow").hide();
        });

        $(document).on("click", ".action-button-3", function(){
            var delete_id = this.id;
            var savepos = $(document).scrollTop();
            
            $('#confirmTitle').text('Update User');
            $("#confirmMsg").text('Are you sure you want to delete this user? Deleting this user means permanently removing it on your database.');
            $(".overlay-deletecomment").show();

            $("#confirmDeleteComment").click(function(){
                $.ajax({
                url: "includes/server-process/dashboard-process.php",
                method: "POST",
                data: {deleteUser: '', delete_id: delete_id},
                cache: false,
                success: function(data){
                    location.reload();
                    $(document).scrollTop(savepos)
                }
                });
            });

            $("#cancelDeleteComment").click(function(){
                $(".overlay-deletecomment").hide();
            })
        });

        $('#mySearch').keyup(function(){
           
            var search = $(this).val();
            
            if($.trim(search).length > 0){
               
                $.ajax({
                    url: "includes/server-process/dashboard-process.php",
                    method: "POST",
                    data: {searchAccManagement: '', search: search},
                    cache: false,
                    success: function(data){
                        $("#userTable").html(data);
                    }
                });

            }else{
                $.ajax({
                url: "includes/server-process/dashboard-process.php",
                method: "POST",
                data: {showUserData: ''},
                cache: false,
                success: function(data){
                    $("#userTable").html(data);
                }
                });
            }
            
        });

        $('#mySearch1').keyup(function(){
           
           var search = $(this).val();
           
           if($.trim(search).length > 0){
              
               $.ajax({
                   url: "includes/server-process/dashboard-process.php",
                   method: "POST",
                   data: {searchPostManagement: '', search: search},
                   cache: false,
                   success: function(data){
                       $("#postTable").html(data);
                   }
               });

           }else{
                $.ajax({
                    url: "includes/server-process/dashboard-process.php",
                    method: "POST",
                    data: {showPostData: ''},
                    cache: false,
                    success: function(data){
                        $("#postTable").html(data);
                    }
                })
           }
           
       });

       $(document).on("click", ".action-button-2", function(){

            var update_id_user = this.id;

            $.ajax({
                   url: "includes/server-process/dashboard-process.php",
                   method: "POST",
                   data: {deliverable: 'updateuser_populate', update_id_user: update_id_user},
                   dataType: "json",
                   cache: false,
                   success: function(data){
                      $(".overlay-updateuser").show();
                      $("#update_firstname").val(data[0]);
                      $("#update_lastname").val(data[1]);
                      $("#update_email").val(data[2]);
                    }
            });

            $("#confirmUpdateUser").click(function(){
                
                var firstname = $("#update_firstname").val();
                var lastname  = $("#update_lastname").val();
                var email     = $("#update_email").val();

                var savepos   = $(document).scrollTop();

                $.ajax({
                   url: "includes/server-process/dashboard-process.php",
                   method: "POST",
                   data: {deliverable: 'update_user', confirmUpdateId: update_id_user, firstname: firstname, lastname: lastname, email: email},
                   cache: false,
                   success: function(data){

                      if(data == 'successUpdateUser'){

                        $(".overlay-updateuser").hide();

                        location.reload();
                        $(document).scrollTop(savepos);

                      }

                }
                });
            });

            $("#cancelUpdateUser").click(function(){
                $(".overlay-updateuser").hide();
            });
       });

       $(document).on("click", ".post-action-button-1", function(){

            var id_post = this.id;

            $.ajax({
                   url: "includes/server-process/dashboard-process.php",
                   method: "POST",
                   data: {deliverable: 'view_post', id_post: id_post},
                   dataType: "json",
                   cache: false,
                   success: function(data){
                        $(".overlay-viewpost").show();
                        $("#post_username").text(data[0]);
                        $("#post_date").text(data[1]);
                        $("#post_game").text(data[2]);
                        $("#post_title").text(data[3]);
                        $("#post_content").text(data[4]);
                    }
            });

            $("#close-viewpost").click(function(){
                $(".overlay-viewpost").hide();
            });
       });

       $(document).on("click", ".post-action-button-3", function(){
            var delete_post_id = this.id;
            var savepos = $(document).scrollTop();

            $('#confirmTitle').text('Delete Post');
            $("#confirmMsg").text('Are you sure you want to delete this post? Deleting this post means permanently removing it on your database.');
            $(".overlay-deletecomment").show();

            $("#cancelDeleteComment").click(function(){
                $(".overlay-deletecomment").hide();
            });

            $("#confirmDeleteComment").click(function(){

                $.ajax({
                   url: "includes/server-process/dashboard-process.php",
                   method: "POST",
                   data: {deliverable: 'delete_post', delete_post_id: delete_post_id},
                   cache: false,
                   success: function(data){

                    if(data == 'successDeletePost'){
                        location.reload();
                        $(document).scrollTop(savepos);
                    }
                    
                    
                }
                });

            });
           
        });
        

       

    });
</script>
