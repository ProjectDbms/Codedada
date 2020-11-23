<!DOCTYPE html>
<html lang="en">
<head>
<title>Codedada - JoinContest</title>
	<?php
		session_start();
		include_once("includes/db_connection.php");
		if(!(isset($_SESSION["username"]))) {
			header("location: login.php");
		}
        include("includes/header.php");
        if(isset($_GET['contestId'])) {
            $contest_id = $_GET['contestId'];
            if(isset($_SESSION["is_registered_$contest_id"])) {
                
            } else {
                echo "<script>
                    window.alert('You did\'nt register for the contest');
                    window.location.href = 'contest.php';
                </script>";
            }
        } else {
            header("location: contest.php");
        }
    ?>
    <style type="text/css">
    	.fcn-grid {
    position: relative;
    flex: 1 0 auto;
    min-width: 960px;
    height: calc(100vh - 3.7rem);
    height: calc(100vh - 3.79rem);
    background-color: #15141f;
}
.fcn-slot.fcn-slot--no-left-neighbor {
    padding-left: 0;
}
.fcn-slot.fcn-slot--no-bottom-neighbor {
    padding-bottom: 0;
}
.fcn-slot.fcn-slot--no-top-neighbor {
    padding-top: 0;
}
.fcn-component {
    display: flex;
    flex-direction: column;
    height: 100%;
    width: 43%;
    float: left;
    position: relative;
    overflow-wrap: break-word;
    overflow-y: auto;
    padding-left: 10px;
}

.fcnn-component {
	display: flex;
    flex-direction: column;
    height: 100%;
    width: 57%;

    position: relative;
}

element.style {
    position: absolute;
    inset: 0% 66.6667% 0% 0%;
    display: block;
}
    </style>
</head>
<body>
    <?php include("includes/navbar_contest.php"); ?>
    <div class="container-fluid">
    	<?php if(isset($_GET['contestId']) && isset($_GET['problems'])) { ?>
    		<div class="question-table mt-5">
	            <?php
	                $q_sql = "SELECT * FROM question WHERE contest_id=$contest_id";
	                $result = mysqli_query($conn, $q_sql);
	                if($result) {
	                    $questions = mysqli_fetch_all($result, MYSQLI_ASSOC);
	                } else {
	                    echo "<script>
	                        window.alert('Something went wrong');
	                    </script>";
	                }
	            ?>
	            <table class="table table-bordered">
	                <thead class="thead-dark">
	                    <tr>
	                        <th style="width:70%">Question</th>
	                    	<th style="width:10%">Points</th>
	                    	<th style="width:10%">Level</th>
	                    	<th style="width:10%">Users</th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <?php foreach($questions as $question) { ?>
	                    	<tr>
	                    		<td>
	                    			<a href="join_contest.php?contestId=<?php echo $contest_id; ?>&readQuestion=<?php echo $question['question_id'] ?>"><?php echo $question['question_name'] ?></a>
	                    		</td>
	                    		<td>	
	                    			<?php 
	                    				$question_id = $question['question_id'];
	                    				$tc_sql = "SELECT points FROM testcase WHERE question_id=$question_id";
	                    				$ts_result = mysqli_query($conn, $tc_sql);
	                    				$testcases = mysqli_fetch_all($ts_result, MYSQLI_ASSOC);
	                    				$points = 0;
	                    				foreach ($testcases as $testcase) {
	                    					$points += $testcase['points'];
	                    				}
	                    				echo $points;
	                    			?>
	                    		</td>
	                    		<td>
	                    			<?php echo $question['level']; ?>
	                    		</td>
	                    		<td>
	                    			Users
	                    		</td>
	                    	</tr>
	                    <?php } ?>
	                </tbody>
	            </table>
	        </div>
    	<?php } ?>
    </div>

	<?php if(isset($_GET['contestId']) && isset($_GET['readQuestion'])) { ?>
		<?php
			$contest_id = $_GET['contestId'];
			$question_id = $_GET['readQuestion'];
            $q_sql = "SELECT * FROM question WHERE contest_id=$contest_id AND question_id=$question_id";
            $result = mysqli_query($conn, $q_sql);
            if($result) {
                $question = mysqli_fetch_assoc($result);
                // print_r($question);
                $question_id = $question['question_id'];
                $question_desc = $question['question_description'];
                $question_name = $question['question_name'];
                $level = $question['level'];
            } else {
                echo "<script>
                    window.alert('Something went wrong');
                    window.location.href = 'join_contest.php?contestId=<?php echo $contest_id; ?>&problems=<?php echo $contest_id ?>';
                </script>";
            }
        ?>
        <div class="fcn-grid" style="background-color: red;">
        	<div class="fcn-component" style="background-color: #fff;">
        		<div class="heading" style="background-color: #f6f5fa; /*overflow-wrap: break-word;*/height: auto; /*min-height: 50px;*/ margin-left: -10px; padding: 5px 5px; margin-bottom: 20px;"><h2><?php echo $question_name; ?></h2></div>
        		<!-- <div class="col col-xs-12 col-md-5" style="/*background-color: red; overflow: scroll*/"> -->
        			<!-- <div class="question-div">
	            		<div class="card">
							<div class="card-body">
								<h5 class="card-title"><?php echo $question_name; ?></h5>
								<p class="card-text"><?php echo $question_desc; ?></p>
								<a class="card-link">Card link</a>
								<a class="card-link">Another link</a>
							</div>
						</div>
	            	</div> -->
	            	<p>
	            		<?php echo $question_desc; ?>
	            	</p>

        		</div>
        		<div class="fcnn-component" style="background-color: lightblue;">
        			<?php
        				include('ide.php');
        			?>
        		</div>
        </div>
	<?php } ?>
    	<!-- -- -->
    <?php
        if(isset($_GET['problems'])) {
            echo "<script type='text/javascript'>
                activate('nav1');
            </script>";
        }
        if(isset($_GET['users'])) {
            echo "<script type='text/javascript'>
                activate('nav3');
            </script>";
        }
    ?>
    <script type="text/javascript">
    	// console.log($("#run-btn"));
    	$("#run-btn").click(function(argument) {
    		if (sourceEditor.getValue().trim() === "") {
		        alert("Error Source code can't be empty!");
		        return;
		    } else {
		        // $runBtn.addClass("loading");
		        // console.log(sourceEditor.getValue().trim());
		        
		    }
    	});
    </script>
</body>
</html>