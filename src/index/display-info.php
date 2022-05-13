<?php 
	class Assignment
	{	
		private $assignments;

		function __construct()
		{
			$source = file_get_contents($_SERVER['DOCUMENT_ROOT']."/student grader/assignment.json");

			if ($source === false) {
			    return;
			}

			$this->assignments = json_decode($source, true);
		}

		public function display($assignment_id = 0){
			$assignments = $this->assignments;

			if(count($assignments)==0)
				return;

			if($assignment_id!= 0 && !isset($assignments[$assignment_id]))
				return;

			$assignment = $assignments[$assignment_id];

			return $assignment;
		}

		public function assignment_names(){
			$assignments = $this->assignments;

			foreach ($assignments as $key => $assignment) {
				$assignment_name = $assignment['assignment_name'];
		?>		
	            <li><a class="dropdown-item text-capitalize text-white" href="/student grader?assignment=<?php echo $key; ?>"><?php echo $assignment_name; ?></a></li>
	            <li><hr class="dropdown-divider"></li>
		<?php
			}
		}

		public function show_questions($questions){
			$grades = $this->grades();

			foreach ($questions as $q_key => $question) {
				$position = $question['position'];
				$question_text = $question['text'];
				$feedback = $question['feedback'];
				$feed_forward = isset($question['feedforward']) ? $question['feedforward'] : [];
				$extra_comments = isset($question['extra_comments']) ? $question['extra_comments'] : [];
		?>
				<!-- question -->
                <div class="border question-template container-fluid">
                    <div class="row">
                    	<!-- <b>$position.</b>  -->
                        <div class="col-12 question"><h5 class="bg-secondary text-capitalize text-white"><span><?php echo $question['position'].'.) '; ?></span><span><?php echo "<span class='question-text teacher-view'>$question_text</span>"; ?></span></h5></div>

                        <?php 
                        // foreach ($feedback as $fb_key => $fb_value) {
                        foreach ($grades as $fb_key => $fb_value) {
                        	if(!isset($feedback[strtoupper($fb_key)]))
                        		continue;

                        	$fb_value = $feedback[$fb_key];
                        	$grade_feedback = $fb_value;
                        	$fb_key = strtoupper($fb_key);
                        ?>
	                        <div class="col-12 <?php echo $fb_key=='F' ? 'col-lg-12' : 'col-md-6 col-lg-4'; ?>">
	                            <div class="input-group mb-3" style="width: 100%">
	                                <div class="input-group-text teacher-view bg-<?php echo $grades[$fb_key]; ?>" style="width: 100%;border-radius: 0">
	                                    <b><span class="student-grade text-capitalize"><?php echo $fb_key; ?></span></b>
	                                </div>

	                                <div style="width: 100%">
		                            <?php
		                            foreach ($grade_feedback as $gfb_key => $gfb_value) {
		                            	$place_holder = 'Student';

		                            	if(strtolower($gfb_key)=='teacher'){
		                            		$place_holder = 'Teacher';
		                            	}

		                            	$for_teacher = $place_holder=='Teacher' ? 'teacher-view' : '';

		                            	echo "<p class='bg-light fw-bold teacher-view' style='margin: 0;padding-left: 5px;'>$place_holder Feedback</p>";

		                            	$user_feedback = '';

		                            	// $only_studentfeedback = !is_array($gfb_value) && strtolower($gfb_key)!='student' && strtolower($gfb_key)!='teacher';

		                            	// if($only_studentfeedback){
		                            		// foreach ($grade_feedback as $key => $value) {
		                            		// 	$user_feedback .= $value;

		                            		// 	if($key!=count($grade_feedback) - 1){
		                            		// 		$user_feedback .= "\n";
		                            		// 	}
		                            		// }
		                            	// }

		                            	$place_holder .= ' Feedback';
		                            	$cs = strtolower($place_holder).'-feedback';

		                            	if(is_array($gfb_value)){
		                            		foreach ($gfb_value as $key => $value) {
		                            ?>
					                            <div class="input-group mb-3 d-flex <?php echo $for_teacher; ?>" style="margin: 0 !important;width: 100%">
													<span style="border-radius: 0px;" class="input-group-text fw-bold bg-<?php echo $grades[$fb_key]; ?>">»</span>
					                                <textarea cols="<?php echo $fb_key=="F" ? '165' : '43'; ?>" class="form-control bg-<?php echo $grades[$fb_key].' '.$cs; ?>" aria-label="<?php echo $place_holder; ?>" placeholder="<?php echo $place_holder; ?>"><?php echo $value; ?></textarea>
					                            </div>
		                            <?php	
		                            		}
		                            	}
		                            	// if($only_studentfeedback)
		                            	// 	{ break; } 
		                        	}
		                            ?>
		                        	</div>
	                            </div>
	                        </div>
                        <?php
                    	}

                    	$this->feed_forward($feed_forward);
                    	$this->extra_comments($feedback);
                    	$this->generalextra_comments($extra_comments);
                        ?>
                    </div>
                </div>
                <!-- END question -->
                <hr>
		<?php
			}
		}

		private function grades(){
			return array('E' => 'warning', 'C' => 'primary', 'A' => 'success', 'F' => 'danger');
		}

		private function extra_comments($feedback){
			if(!isset($feedback['extra_comments']))
				return;

			$extra_comments = $feedback['extra_comments'];

			if($extra_comments==0)
				return;
		?>
			<!-- student feedback -->
            <div class="col-12 container-fluid" style="padding-top: 5px;padding-bottom: 0;margin-bottom: 0">
                <div class="mb-3 row">
                	<p class="text-center fw-bold col-12" style="font-size: 18px;">Extra Comments</p>
            		<?php
            		foreach ($extra_comments as $key => $extra_comment) {
            			$for = 'Student';

            			if(strtolower($key)=='teacher')
            				$for = 'Teacher';

            			$comments = '';
            		?>

            		<div class="col-12 col-md-6 <?php echo $for=='Teacher' ? 'teacher-view' : ''; ?>">
            			<p class="text-center teacher-view"><?php echo $for; ?></p>
							<?php
	            			foreach ($extra_comment as $value) {
							?>
		                		<div class="mb-3" style="padding-bottom: 0 !important;">
		                			<textarea class="form-control bg-light" aria-label="With textarea" placeholder="Extra-Comment for the <?php echo $for; ?>"><?php echo $value; ?></textarea>
		                    	</div>
	                		<?php
	                		}
	                		?>
	                </div>

                	<?php
                	}
                	?>
                </div>
            </div>
            <!-- END student feed back -->
		<?php
		}

		private function feed_forward($feed_forward){
			if($feed_forward == 0)
				return;
		?>
            <div class="col-12 container-fluid" style="padding-top: 5px;">
                <div class="row">
                	<p class="text-center fw-bold col-12" style="font-size: 18px;">Feed Forward</p>
            		<?php
            		foreach ($feed_forward as $key => $feedback) {
            			$for = 'Student';

            			if(strtolower($key)=='teacher')
            				$for = 'Teacher';
            		?>
            			<div class="col-12 container-fluid <?php echo $for=='Teacher' ? 'teacher-view' : ''; ?>">
            				<div class="row">
	            				<p class="col-12 text-center teacher-view"><?php echo $for; ?></p>

			            		<?php
				            		if(is_array($feedback)){
			            				foreach ($feedback as $tag => $value) {
			            		?>
			            					<!-- <?php //echo ($for=='Teacher' ? '' : 'input-group').' mb-3'; ?> -->
			            					<div class="<?php echo $tag=='all' ? 'col-12' : 'col-6' ?> mb-3">
				            					<?php
				            					// if(!is_numeric($tag)){
				            					?>
													<!-- <span class="input-group-text"><?php echo $tag; ?></span> -->
												<?php
												// }
												?>
						                		<textarea class="form-control bg-light" aria-label="With textarea"><?php echo $value; ?></textarea>
			                				</div>
						        <?php
			            				}
			            			}
			                	?>
		                	</div>
		                </div>
                	<?php
                	}
                	?>
                </div>
            </div>
		<?php
		}

		private function generalextra_comments($extra_comments){
			if($extra_comments==0)
				return;
		?>
            <div class="col-12 border-top container-fluid" style="padding-top: 10px;">
                <div class="row">
                	<p class="text-center fw-bold col-12" style="font-size: 18px;">Extra Comments</p>
            		<?php
            		foreach ($extra_comments as $key => $extra_comment) {
            			$for = 'Student';

            			if(strtolower($key)=='teacher')
            				$for = 'Teacher';
            		?>
            			<div class="col-12 col-md-6 <?php echo $for=='Teacher' ? 'teacher-view' : ''; ?>">
            				<p class="text-center teacher-view"><?php echo $for; ?></p>

		            		<?php
			            		if(is_array($extra_comment)){
		            				foreach ($extra_comment as $tag => $value) {
										?>
		            					<div class="mb-3">
					                		<textarea class="form-control bg-light" aria-label="With textarea"><?php echo $value; ?></textarea>
		                				</div>
					                	<?php
		            				}
		            			}
		                	?>
		                </div>
                	<?php
                	}
                	?>
                </div>
            </div>
		<?php
		}
	}
?>