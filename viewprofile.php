<?php

	session_start();

	require_once 'classes/database-query.php';
    require_once 'classes/utility.class.php';

	// GET USER'S INFORMATION VIA SESSION ID
	$query = new Query;
	$userID = $_SESSION['id_user'];
	$userInfo = $query->getRow("SELECT * FROM users WHERE id_user = ?", ["$userID"]);

    // COUNT USER'S POSTS
    $postsCount = $query->countRow("id_user", "posts", [$userID]);

    // GET USER'S COUNTRY
    $utility = new Utility;
	$country = $utility->getCountry($userInfo[0]['country']);

	// VERIFY USER'S STATUS / AUTHENTICATION
	$getAuthStatus = $query->verifyAuthUser($userID);
	if($getAuthStatus){
		$authStatus    = $getAuthStatus['verify'];
		$bigAuthStatus = $getAuthStatus['verify'];
		$idAuth 	   = $getAuthStatus['id_user'];
		if($authStatus == 2){$authIcon = '<span><img src="badges/admin-check.png" alt="" class="badges" style="position: relative; top: 2px !important"></span>';}elseif($authStatus == 1){$authIcon = '<span><img src="badges/verified-check.png" alt="" class="badges"></span>';}else{$authIcon = '';}
		if($bigAuthStatus == 2){$bigAuthIcon = '<img src="badges/admin-check.png" alt="" class="badge">';}elseif($bigAuthStatus == 1){$bigAuthIcon = '<img src="badges/verified-check.png" alt="" class="badge';}else{$bigAuthIcon = '';}
	}

	// RETRIEVES THE USER'S DISPLAY PICTURE AND COVER PHOTO
	$userPic 		= $utility->retrievePic($userInfo[0]['gender'], $userInfo[0]['dp'], $userInfo[0]['cover']);
	$pathUserDp 	= $userInfo[0]['gender']."/".$userPic[0];
	$pathUserCover 	= $userInfo[0]['gender']."/".$userPic[1];
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $userInfo[0]['first_name']." ".$userInfo[0]['last_name']." | Gamingcomm"; ?></title>
    <link rel="icon" href="icons/logo.png">

    <link rel="stylesheet" type="text/css" href="css/homepage-navbar.css">
    <link rel="stylesheet" type="text/css" href="css/viewprofile.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<body>

    <style> /* FOR TRIGGERING JS MENU DROPDOWN */
        .show {
            display: block;
        }
    </style>

<div class="wrapper-error-modal">
	<div class="container-error-modal">
		<div class="error-content">
		</div>
	</div>
</div>

<div class="wrapper-success-modal">
	<div class="container-success-modal">
		<div class="success-content">
		</div>
	</div>
</div>

<div class="overlay-deletemodal">
	<div class="deleteAlertModal">
		<div style="width: 100%; text-align: center; padding: 15px; border-bottom: 1px solid #fff; display: flex; justify-content: space-between;" >
			
			<div></div>

			<h2 >Delete this post?</h2>

			<div>
				<span><img src="icons/close.png" alt="" style="width: 15px; height: 15px; object-fit: cover; filter: invert(1); position: relative; top: 5px;" ></span>
			</div>
		</div>
		
		<div style="width: 100%; padding: 15px; font-size: 15px;">
			<p>Are you sure you want to delete this post? Deleting this post means permanently removing it on your account.</p>

			<div style="width: 100%; padding: 15px; display: flex; justify-content: end;  ">
				<button id="cancelDeletePost"style="color: #2FF761; background-color: transparent; border: none; padding: 12px 12px; cursor: pointer; "> Cancel </button>
				<button id="confirmDeletePost" style="padding: 0px 40px; background-color:#2FF761; border: none; border-radius: 5px; cursor: pointer;" > Delete </button>
			</div>
		</div>
	</div>
</div>

<div class="overlay-deletecomment">
	<div class="deleteAlertComment">
		<div style="width: 100%; text-align: center; padding: 15px; border-bottom: 1px solid #fff; display: flex; justify-content: space-between;" >
			
			<div></div>

			<h2 >Delete this comment?</h2>

			<div>
				<span><img src="icons/close.png" alt="" style="width: 15px; height: 15px; object-fit: cover; filter: invert(1); position: relative; top: 5px;" ></span>
			</div>
		</div>
		
		<div style="width: 100%; padding: 15px; font-size: 15px;">
			<p>Are you sure you want to delete this comment? Deleting this comment means permanently removing it on your account.</p>

			<div style="width: 100%; padding: 15px; display: flex; justify-content: end;  ">
				<button id="cancelDeleteComment"style="color: #2FF761; background-color: transparent; border: none; padding: 12px 12px; cursor: pointer; "> Cancel </button>
				<button id="confirmDeleteComment" style="padding: 0px 40px; background-color:#2FF761; border: none; border-radius: 5px; cursor: pointer;" > Delete </button>
			</div>
		</div>
	</div>
</div>

<!-- FOR CREATING POSTS -->
<div class="wrapper-modal">
		<div class="wrapper-inside-modal">
			<div class="modal-title">
				<p>Create Post</p>
				<div><img src="icons/close.png"></div>
			</div>

			<div class="modal-user-name">
				<img src="pictures/<?php echo $pathUserDp?>" class="createpost-dp">
				<p><?php echo $userInfo[0]['first_name']." ".$userInfo[0]['last_name']?> <?php if(!empty($authIcon)){echo $authIcon;}?> </p>
			</div>

			<div class="modal-content-firstrow">
				<input type="text" placeholder="Insert a post title" id="title_post">
			</div>

			<div class="modal-content-secondrow">
				<div class="editable-div" contentEditable="true" id="content_post">
					<p class="placeholder-post" id="content-placeholder">Hey <?php echo $userInfo[0]['first_name']?>, What's on your mind?</p>
				</div>
			</div>

			<div class="modal-title-game">
				<p>Add a game for your post:</p>
				<div id="selected-title-games"></div>
				<input type="text" id="title_game">
				<div id="show-title-games">
				</div>
			</div>

			<div class="modal-button">
				<button id="button-post">Post</button>
			</div>
		</div>
</div>

<!-- FOR UPDATE POST MODAL -->
<div class="FF601">
		<div class="FF602">
			<div class="FF603">
				<p>Update Post</p>
				<div><img src="icons/close.png"></div>
			</div>

			<div class="FF604">
				<img src="pictures/<?php echo $pathUserDp?>" class="FF6041">
				<p><?php echo $userInfo[0]['first_name']." ".$userInfo[0]['last_name']; ?> <?php if(!empty($authIcon)){echo $authIcon;}?></p>
			</div>

			<div class="FF605">
				<input type="text" placeholder="Insert a post title" id="update_title_post">
			</div>

			<div class="FF606">
				<div class="FF6061" contentEditable="true" id="update_content_post">
					<p class="FF6062" id="update_content_placeholder">Hey <?php echo $userInfo[0]['first_name']?>, What's on your mind?</p>
				</div>
			</div>

			<div class="FF607">
				<p>Add a game for your post:</p>
				<div id="update_selected_title_games"></div>
				<input type="text" id="update_title_game">
				<div id="update_show_title_games" >
				</div>
			</div>

			<div class="FF608">
				<button>Update Post</button>
			</div>
		</div>
</div>
    
    <header>
        <div class="navbar-brandlogo">
            <img src="icons/logo.png">
            <a href="#" class="brand">GAMING<span>comm</span></a>
        </div>

        <div class="list-of-header-buttons">
            <div class="container-list-header-buttons">
                <div class="header-button-1">
                    <img src="icons/hot-sale.png" alt="">
                </div>

                <div id="returnhomepage" class="header-button-2">
                    <img  src="icons/games.png" alt="">
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

    

    <div class="wrapper-viewprofile">
        <div class="section-1">
           <div class="cover-photo">
                <div class="img-container">
                    <img src="pictures/<?php echo $pathUserCover?>" alt=""> 
                </div>

                <div class="display-picture">
                    <div class="ellipse-picture">
                        <img src="pictures/<?php echo $pathUserDp?>" alt="">
                    </div>
               </div>
           </div>
           
        </div>

        <div class="section-2">
            <div class="username">
                <p><?php echo $userInfo[0]['first_name']." ".$userInfo[0]['last_name']?> <?php if(!empty($bigAuthIcon)){echo $bigAuthIcon;}?></p>
            </div>
            <div class="labels">
                <div class="labels-1-1">
                    <span>Posts</span>
                </div>

                <div class="labels-1-1">
                    <span>Games</span>
                </div>

                <div class="labels-1-1">
                    <span>Following</span>
                </div>

                <div class="labels-count-1-1">
                    <span><?php echo $postsCount ?></span>
                </div>

                <div class="labels-count-1-1">
                    <span>1000</span>
                </div>

                <div class="labels-count-1-1">
                    <span>10000</span>
                </div>      
            </div>
        </div>

        <div class="section-3">

            <div class="left">
                <div class="left-info-container">
                    <p class="intro">INTRO</p>
                    <div class="bio">
                        <p><?php echo $userInfo[0]['bio'];?></p>
                    </div>

                    <div class="joineddate">
                        <p>Joined: <span><?php echo $userInfo[0]['date_joined']?></span></p>
                    </div>

                    <div class="address">
                        <img src="icons/location.png" alt="">
                        <p>Lives in <span><?php echo $country; ?></span></p>
                    </div>

                    <div class="favgame">
                        <img src="icons/console.png" alt="">
                        <p>Favorite game is <span>Overwatch 2</span></p>
                    </div>

                    <div class="intro-edit-button">
                        <button>Edit Details</button>
                    </div>
                </div>
            </div>

            <div class="right">
                <div class="right-container">
                    <div class="compose-post">
                        <div class="compose-post-content">
                            <img src="pictures/<?php echo $pathUserDp; ?>">
                            <input type="text" id="toggle-modal-post" placeholder="What's on your mind, <?php echo $userInfo[0]['first_name']?>?">
                        </div>
                    </div>
                </div>
                
                <div class="load-new-post">
				</div>

                <div class="load-posts-here" style="margin-bottom: 10px;"> 
                </div> 
           
            </div>
        </div>

    </div>
    
</body>
</html>

<script type="text/javascript" src="js/compose-post.js"></script>

<script>

function reloadCenter(){
	let id = "<?php echo $_SESSION['id_user'];?>";
	$.ajax({
		url: "includes/server-process/loadself-post.ajax.php",
		type: "POST",
		cache: false,
		data : {id: id},
		success: function(data){
			$(".load-posts-here").html(data);
		}
	});
}

$("#returnhomepage").click(function(){
	location.href="homepage.php";
});

$(document).ready(function(){
	let id = "<?php echo $_SESSION['id_user'];?>";
	$.ajax({
		url: "includes/server-process/loadself-post.ajax.php",
		type: "POST",
		cache: false,
		data : {id: id},
		success: function(data){
			$(".load-posts-here").html(data);
		}
	});
});

$("#title_game").keyup(function(){
	let verify_title    	= '';
	let search_game_title 	= $("#title_game").val();

	if(search_game_title !== ""){
		$.ajax({
			url: "includes/server-process/createpost-ajax.php",
			type: "POST",
			data: {
				verify_title: verify_title,
				search_game_title: search_game_title
			},
			cache: false,
			success: function(data){
				$("#show-title-games").html(data);
				$("#show-title-games").show();
			}
		});
	}else{
		$("#show-title-games").hide();
	}

});


$("#show-title-games").click(function(){

	let game__id 	= $("#show-title-games a").attr('id');
	var game__name 	= $("#show-title-games a").text();

	$("#selected-title-games").text(game__name);
	$("#selected-title-games").show();
	$("#title_game").val(game__name);
	$("#show-title-games").hide();

	$("#selected-title-games").click(function(){
		$("#selected-title-games").empty();
		$("#title_game").val("");
	});

});

$("#button-post").click(function(){
	$(".container-error-modal").hide();

	let id_user			= " <?php echo $userInfo[0]['id_user']; ?> ";
	let name 			= " <?php echo $userInfo[0]['first_name']; ?> ";

	let game_id 		= $("#show-title-games a").attr('id');

	let content 		= $("#content_post").text();
	let title_post 		= $("#title_post").val();
	let title_game 		= $("#title_game").val();
	
	if($.trim(content) != "Hey "+name+", What's on your mind?"){
		if($.trim(title_post).length > 0 && $.trim(title_game).length > 0 && $.trim(content).length > 0){
			
			$.ajax({
				url: "includes/server-process/createpost-ajax.php",
				type: "POST",
				data: {
					content: content,
					title_post: title_post,
					title_game: title_game,
					id_user: id_user,
					name: name
				},
				cache: false,
				success: function(data){
					
					if(data == "errorNoGame"){
						$(".container-error-modal").fadeIn(400).show();
						$(".error-content").html("<p><span>ERROR</span> Please select a game.</p>")
					}

					if(data == "errorTitleLength"){
						$(".container-error-modal").fadeIn(400).show();
						$(".error-content").html("<p><span>ERROR</span> Title length does not meet the condition.</p>")
					}

					if(data == "errorContentLength"){
						$(".container-error-modal").fadeIn(400).show();
						$(".error-content").html("<p><span>ERROR</span> Post content length does not meet the condition.</p>")
					}

					if(data == "errorSameContent"){
						$(".container-error-modal").fadeIn(400).show();
						$(".error-content").html("<p><span>ERROR</span> Please fill-in the given field for content.</p>")
					}

					if(data == "successCreatePost"){
						$("#content_post").text("");
						$("#content-placeholder").text("Hey "+name+", What's on your mind?");
						$("#title_post").val("");
						$("#title_game").val("");
						$("#selected-title-games").empty();

						$(".wrapper-modal").hide();
						$(".wrapper-viewprofile").css("filter","");
						$(".container-error-modal").hide();

						location.href="viewprofile.php";
					}
				}
			});

		}else{
			$(".container-error-modal").fadeIn(400).show();
			$(".error-content").html("<p><span>ERROR</span> Fill-in all the required details.</p>")
		}

	}
	
});

$(".container-error-modal").click(function(){
	$(".container-error-modal").fadeOut(400).hide();
});

	
$(document).on("click", ".more-option", function(e){

    let id = $(this).attr('id');

    if(this.id == id){
        $(this).find(".whole-absolute-lists-container").fadeIn(200).show();
        $(this).addClass('openedOptions');

        if($(this).hasClass('openedOptions')){
            $(this).find(".whole-absolute-lists-container").fadeIn(200).hide();
            $(this).removeClass('openedOptions');
        }

    }
});

$(document).on("click", ".deletePost", function(e){

	let user_id  = "<?php echo $_SESSION['id_user'] ?>";
	let deleteId = this.id;
	let savepos  = $('.center').scrollTop();

	let deliverable = "homepage";

	$(".overlay-deletemodal").show();

	$("#confirmDeletePost").click(function(){
		
		$.ajax({
		url: "includes/server-process/crud-post.ajax.php",
		type: "POST",
		data: {
			deleteId: deleteId,
			user_id: user_id,
			deliverable: deliverable
		},
		cache: false,
		success: function(data){

			if(!data.includes('error')){
				$('.center').scrollTop(savepos);
				reloadCenter();

				$(".container-success-modal").fadeIn(400).show();
				$(".success-content").html("<p><span>SUCCESS</span> Successfully deleted your post.</p>");
				$(".overlay-deletemodal").hide();
			}
			
		}

	});
	
});

$("#cancelDeletePost").click(function(){
	$(".overlay-deletemodal").hide();
})

});

$(".container-success-modal").click(function(){
    $(".container-success-modal").fadeOut(400).hide();
});

$(".container-success-modal").click(function(){
    $(".container-success-modal").fadeOut(400).hide();
});

// FOR UPDATE POST
$("#update_title_game").keyup(function(){
    let verify_title_update    	= '';
    let search_game_title 		= $("#update_title_game").val();

    if(search_game_title !== ""){
        $.ajax({
            url: "includes/server-process/createpost-ajax.php",
            type: "POST",
            data: {
                verify_title_update: verify_title_update,
                search_game_title: search_game_title
            },
            cache: false,
            success: function(data){
                $("#update_show_title_games").html(data);
                $("#update_show_title_games").show();
            }
        });
    }else{
        $("#show-title-games").hide();
    }

});

$("#update_show_title_games").click(function(){

	let game__id 	= $("#update_show_title_games a").attr('id');
	var game__name 	= $("#update_show_title_games a").text();

	$("#update_selected_title_games").text(game__name);
	$("#update_selected_title_games").show();
	$("#update_title_game").val(game__name);
	$("#update_show_title_games").hide();

	$("#update_selected_title_games").click(function(){
	$("#update_selected_title_games").empty();
	$("#update_title_game").val("");
	});

});

$(document).on("click", ".updatePost", function(e){
	
	let user_id  = "<?php echo $_SESSION['id_user'] ?>";
    let updateId = this.id;

	$(".FF608 button").attr('id', updateId);

	$.ajax({
		url: "includes/server-process/crud-post.ajax.php",
		type: "POST",
		data: {
			updateId: updateId,
			user_id: user_id
		},
		dataType: "json",
		cache: false,
		success: function(data){
			$("#update_title_post").val(data['title']);
			$("#update_content_post").text(data['content']);
			$("#update_selected_title_games").text(data['game']);
            $("#update_selected_title_games").show();

			$("#update_selected_title_games").click(function(){
			$("#update_selected_title_games").empty();
			$("#update_title_game").val("");
			});
			
			$(".wrapper-viewprofile").css("filter","blur(5px)");
			$(".FF601").fadeIn(400).show();

		}
	});
});

$(".FF608 button").click(function(){
	
	var updated_title   = $("#update_title_post").val();
	var updated_content = $("#update_content_post").text();
	var updated_game    = $("#update_selected_title_games").text();


	let name 		 = " <?php echo $userInfo[0]['first_name']; ?> ";
	let id_user		 = " <?php echo $userInfo[0]['id_user']; ?> ";
	let id_post 	 =  this.id;

	let deliverable  = 'viewprofile';

	if($.trim(updated_content) != "Hey "+name+", What's on your mind?"){
        if($.trim(updated_title).length > 0 && $.trim(updated_game).length > 0 && $.trim(updated_content).length > 0){
            
            $.ajax({
                url: "includes/server-process/createpost-ajax.php",
                type: "POST",
                data: {
                    updated_content: updated_content,
                    updated_title: updated_title,
                    updated_game: updated_game,
                    id_user: id_user,
                    name: name,
					id_post: id_post,
					deliverable: deliverable
                },
                cache: false,
                success: function(data){
                    
                    if(data == "errorNoGame"){
                        $(".container-error-modal").fadeIn(400).show();
                        $(".error-content").html("<p><span>ERROR</span> Please select a game.</p>")
                    }

                    if(data == "errorTitleLength"){
                        $(".container-error-modal").fadeIn(400).show();
                        $(".error-content").html("<p><span>ERROR</span> Title length does not meet the condition.</p>")
                    }

                    if(data == "errorContentLength"){
                        $(".container-error-modal").fadeIn(400).show();
                        $(".error-content").html("<p><span>ERROR</span> Post content length does not meet the condition.</p>")
                    }

                    if(data == "errorSameContent"){
                        $(".container-error-modal").fadeIn(400).show();
                        $(".error-content").html("<p><span>ERROR</span> Please fill-in the given field for content.</p>")
                    }

                    if(!data.includes('error')){
                        $("#update_content_post").text("");
                        $("#update_content_placeholder").text("Hey "+name+", What's on your mind?");
                        $("#update_title_post").val("");
                        $("#update_title_game").val("");
                        $("#update_selected-title-games").empty();

                        $(".FF601").hide();
                        $(".overlay").css("filter","");
                        $(".container-error-modal").hide();

                        $(".load-posts-here").hide().html(data).fadeIn('slow');

						$(".container-success-modal").fadeIn(400).show();
						$(".success-content").html("<p><span>SUCCESS</span> Successfully updated your post.</p>");
                    }
                }
            });

        }else{
            $(".container-error-modal").fadeIn(400).show();
            $(".error-content").html("<p><span>ERROR</span> Fill-in all the required details.</p>")
        }

    }


});

$(document).on("keypress", "#empty_add_comment", function(ev){
	
	var content = $(this).text();
	var id_user = "<?php echo $_SESSION['id_user']; ?>"
	var id_post = $(this).next("#hidden_id_post").text();

	var savepos = $('.center').scrollTop();


	var keycode = (ev.keyCode ? ev.keyCode : ev.which);


	if(keycode == '13'){

		if($.trim(content).length > 0){

			$.ajax({
			url: "includes/server-process/crud-post.ajax.php",
			type: "POST",
			data: {
				id_post: id_post,
				content: content,
				id_user: id_user,
				commentToEmpty: ''
			},
			cache: false,
			success: function(data){
				
				$('.center').scrollTop(savepos);
				reloadCenter();

			}
			});

		}else{
			return
		}
	}
});

$(document).on("keypress", "#add_comment", function(ev){
	
	var content = $(this).text();
	var id_user = "<?php echo $_SESSION['id_user']; ?>"
	var id_post = $(this).siblings("#hidden_id_post1").text();

	var savepos = $('.center').scrollTop();

	var keycode = (ev.keyCode ? ev.keyCode : ev.which);


	if(keycode == '13'){

		if($.trim(content).length > 0){

			$.ajax({
			url: "includes/server-process/crud-post.ajax.php",
			type: "POST",
			data: {
				id_post: id_post,
				content: content,
				id_user: id_user,
				commentToExist: ''
			},
			cache: false,
			success: function(data){
				
				
				$('.center').scrollTop(savepos);
				reloadCenter();

			}
			});

		}else{
			return
		}
	}
});

$(document).on("mouseenter", ".load_comment_container", function(){
	$(".comments_more_icon").fadeIn(200, "slow").show();

}).on("mouseleave", ".load_comment_container", function(){
	$(".comments_more_icon").hide();
});

$(document).on("click", ".comments_more_icon", function(){
	
	
	var id_comment = this.id;
	var deleteComment = '';
	var savepos = $('.center').scrollTop();

	$(".overlay-deletecomment").show();

	$("#confirmDeleteComment").click(function(){

		$.ajax({
		url: "includes/server-process/crud-post.ajax.php",
			type: "POST",
			data: {
				id_comment: id_comment,
				deleteComment: deleteComment,
			},
			cache: false,
			success: function(data){
				
				reloadCenter();
				$('.center').scrollTop(savepos);
				$(".overlay-deletecomment").hide();

				$(".container-success-modal").fadeIn(400).show();
				$(".success-content").html("<p><span>SUCCESS</span> Successfully deleted your comment.</p>");
			}
		});

	});

	$("#cancelDeleteComment").click(function(){

		$(".overlay-deletecomment").hide();
	});

});


</script>