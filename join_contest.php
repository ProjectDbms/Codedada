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
    <link rel="stylesheet" href="assets/css/timeTo.css?q=<?php echo time(); ?>" type="text/css">
	<script type="text/javascript" src="assets/js/jquery-time-to.js"></script>
    <script type="text/javascript">
		function countdownCalc(startTime, el) {
			$(el).timeTo({
				timeTo: new Date(new Date(startTime)),
				theme: "black",
				displayCaptions: true,
				fontSize: 21,
				captionSize: 10,
				callback: function() {
					window.location.href = "contest.php";
				}
			});
		}
	</script>
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
		    margin-bottom: -50rem;
		    position: relative;
		}

		.comp-heading {
			background-color: #f6f5fa;
			/*overflow-wrap: break-word;*/
			height: auto; 
			/*min-height: 50px;*/
			margin-left: -10px; 
			padding: 5px 5px; 
			margin-bottom: 20px;
		}
		.loader {
		  border: 16px solid #f3f3f3;
		  border-radius: 50%;
		  border-top: 16px solid #3498db;
		  width: 100px;
		  height: 100px;
		  -webkit-animation: spin 2s linear infinite; /* Safari */
		  animation: spin 2s linear infinite;
		}

		/* Safari */
		@-webkit-keyframes spin {
		  0% { -webkit-transform: rotate(0deg); }
		  100% { -webkit-transform: rotate(360deg); }
		}

		@keyframes spin {
		  0% { transform: rotate(0deg); }
		  100% { transform: rotate(360deg); }
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
	            <h3 style="color: red;">Ends In</h3>
	            <div class="content" style="/*position: sticky; float: left; margin-bottom: -2rem;*/">
	            	<div id="timer"></div><br>
	            </div>
	            <?php
	            	$c_sql = "SELECT * FROM contest WHERE contest_id=$contest_id";
	                $c_result = mysqli_query($conn, $c_sql);
	                $c_contest = mysqli_fetch_assoc($c_result);
					// $present_contest_id = $contest['contest_id'];
					// print_r($c_contest);
					$entime = $c_contest['end_time'];
					$contest_end_time = date("M d Y H:i:s", strtotime($entime))." UTC+5:30";
					echo "<script>countdownCalc('$contest_end_time','#timer');</script>";
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
        <div class="fcn-grid" style="/*background-color: red;*/">
        	<div class="fcn-component" style="background-color: #fff;">
        		<!-- <div class="comp-heading" style=""><h2><?php echo $question_name; ?></h2></div> -->
        		<div class="card text-white bg-primary mr-3 mt-1">
        			<div class="card-header bg-dark"><?php echo $question_name; ?></div>
					<div class="card-body">
        				<?php echo $question_desc; ?>
	            	</div>
	            </div>
        	</div>
    		<div class="fcnn-component" style="/*background-color: lightblue;*/">
    			<div class="ide" style="height: 67%; position: relative;">
    				<?php
    					include('ide.php');
    				?>
    			</div>
    			<div class="buttons-out" style="/*background-color: blue;*/ margin-bottom: 0px; height: 33%;">
    				<div class="buttons" style="background-color: black; height: 20%; padding-top: 2px;">
    					<button class="btn btn-primary" id="run-btn" style="float: left; margin-left: 40px;">Run</button>
    					<select name="lang" id="lang" class="form-control" style="width: 150px; float: left; margin-left: 290px;">
    						<option value="C">C</option>
    						<option value="CPP14">C++ 14</option>
    						<option value="JAVA8">Java 8</option>
    						<option value="PYTHON">Python 2</option>
    						<option value="PYTHON3">Python 3</option>
    						<option value="JAVASCRIPT_NODE">Javascript(NodeJS)</option>
    					</select>
    					<button class="btn btn-danger" id="submit-btn" style="float: right; margin-right: 40px;">Submit</button>
    				</div>
    				<div class="output-input" style="clear: both; /*background-color: green;*/ height: 80%; background-color: #272822;">
    					<div class="input" style="float: left; width: 46%; margin-left: 20px;">
    						<label style="color: white;">Input</label><br>
    						<textarea rows="7" class="form-control" id="in" style="font-size: 12px; font-weight: 600;"></textarea>
    					</div>
    					<div class="output" id="outId" style="float: right; width: 46%; margin-right: 20px;">
    						<label style="color: white;">Output</label><br>
    						<textarea rows="7" class="form-control" id="out" style="font-size: 12px; font-weight: 600;" readonly></textarea>
    						<div class="loader" style="display: none;"></div>
    					</div>
    				</div>
    			</div>
    		</div>
        </div>
	<?php } ?>

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
    	c_temp = '#include <stdio.h>\n\
int main() {\n\
	\n\
	return 0;\n\
}';
		cpp_temp  = '#include <iostream>\n\
using namespace std;\n\
int main() {\n\
	\n\
	return 0;\n\
}';
		java_temp = 'public class Main {\n\
	public static void main(String[] args) {\n\
		System.out.println("Hello, World");\n\
	}\n\
}';
		pyth3_temp = 'print("Hello, World")';
		pyth_temp = 'print "Hello, World"';
		node_temp = 'console.log("Hello, World")';
		var language = "C";
		var lang = $("#lang");
		$(lang).on('change', function() {
			language = lang.val();
			if(language == "C" || language == "CPP14") {
				editor.session.setMode("ace/mode/c_cpp");
			} else if(language == "JAVA8") {
				editor.session.setMode("ace/mode/java");
			} else if(language == "PYTHON" || language == "PYTHON3") {
				editor.session.setMode("ace/mode/python");
			} else if(language == "JAVASCRIPT_NODE") {
				editor.session.setMode("ace/mode/javascript");
			}
			if(language == "C" && (editor.session.getValue()==java_temp || editor.session.getValue() == cpp_temp || editor.session.getValue() == pyth3_temp || editor.session.getValue() == pyth_temp || editor.session.getValue() == node_temp)) {
				editor.session.setValue(c_temp);	
			} else if(language == "CPP14" && (editor.session.getValue()==java_temp || editor.session.getValue() == c_temp || editor.session.getValue() == pyth3_temp || editor.session.getValue() == pyth_temp || editor.session.getValue() == node_temp)) {
				editor.session.setValue(cpp_temp);
			} else if(language == "JAVA8" && (editor.session.getValue()==cpp_temp || editor.session.getValue() == c_temp || editor.session.getValue() == pyth3_temp || editor.session.getValue() == pyth_temp || editor.session.getValue() == node_temp)) {
				editor.session.setValue(java_temp);
			} else if(language == "PYTHON" && (editor.session.getValue()==cpp_temp || editor.session.getValue() == c_temp || editor.session.getValue() == pyth3_temp || editor.session.getValue() == java_temp || editor.session.getValue() == node_temp)) {
				editor.session.setValue(pyth_temp);
			} else if(language == "PYTHON3" && (editor.session.getValue()==cpp_temp || editor.session.getValue() == c_temp || editor.session.getValue() == pyth_temp || editor.session.getValue() == java_temp || editor.session.getValue() == node_temp)) {
				editor.session.setValue(pyth3_temp);
			} else if(language == "JAVASCRIPT_NODE" && (editor.session.getValue()==cpp_temp || editor.session.getValue() == c_temp || editor.session.getValue() == pyth_temp || editor.session.getValue() == java_temp || editor.session.getValue() == pyth3_temp)) {
				editor.session.setValue(node_temp);
			}
		});
    	$("#run-btn").click(function() {
    		console.log("run");
    		$("#out").css("display", "none");
    		$(".loader").css("display", "block");
    		var code = editor.session.getValue();
    		var object = {
    			"type": "run",
    			"code": code,
    			"lang": language,
    			"input": $("#in").val()
    		}
    		$("#out").val("");
    		$.ajax({
				url: "compile.php",
				method: "post",
				data: object,
				success: function(res) {
					if(res) {
						// console.log(res);
						// processResponse(res);
						var obj = JSON. parse(res)
						// console.log(obj.compile_status);
						$("#out").css("display", "block");
    					$(".loader").css("display", "none");
						if(obj.compile_status != "OK") {
							$("#out").val(obj["compile_status"]);
							// console.log(obj.compile_status);
						} else {
							// var html = $.parseHTML(obj["run_status"]["output"]);
							$("#out").val(obj["run_status"]["output"]);
							// console.log($(html).text());
							// console.log($.parseHTMl(obj["run_status"]["output"]));
						}
					} else {
						window.alert("Error in sending code");
					}
				}
			});
    	});
    </script>
</body>
</html>