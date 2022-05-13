<?php 
    require_once $_SERVER['DOCUMENT_ROOT'].'/student grader/src/index/display-info.php';

    $assignment = new Assignment();

    $id = isset($_GET['assignment']) && !empty($_GET['assignment']) ? $_GET['assignment'] : 0;
    $students_assignment = $assignment->display($id);
?>

<!DOCTYPE html> 
<html>
    <head>
        <title>Student Grading System</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <!-- Latest compiled and minified CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
        <link rel="stylesheet" href="css/index.css">

        <style>
            body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
        </style>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.js" integrity="sha512-sn/GHTj+FCxK5wam7k9w4gPPm6zss4Zwl/X9wgrvGMFbnedR8lTUSLdsolDRBRzsX6N+YgG6OWyvn9qaFVXH9w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        <script type="text/javascript">
            window.html2canvas = html2canvas;
            window.jsPDF = window.jspdf.jsPDF;
        </script>
        <script src="js/pdf.js"></script>
    </head>
    <body>
        <!-- page content -->
        <div class="container-fluid page-content" id="page-content">

            <!-- header -->
            <div id="header">
                <div class="assignment-name-section input-group justify-content-center" style="margin-bottom: 5px;">
                    <h1 class="assignment-name text-capitalize text-center"><?php echo $students_assignment['assignment_name']; ?></h1>

                    <div class="btn-group teacher-view">
                        <button type="button" class="btn btn-light" style="font-size: 13px;">GO TO</button>
                        <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="visually-hidden">Toggle Dropdown</span>
                        </button>
                        <ul class="dropdown-menu bg-dark" style="max-height: 400px;overflow-y: auto;">
                            <?php 
                                $assignment->assignment_names();
                            ?>
                        </ul>
                    </div>
                </div>

                <h4 class="assignment-url text-center"><a href="<?php echo $students_assignment['assignment_url']; ?>"><?php echo $students_assignment['assignment_url']; ?></a></h4>

                <h3 class="course-name text-center text-uppercase"><?php echo $students_assignment['course_name']; ?></h3>
                <br>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="students-name">Student's Name</span>
                                <input type="text" class="form-control" placeholder="Input student's name" aria-label="Input student's name" aria-describedby="students-name">
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="students-name">Final Letter Grade</span>
                                <input type="text" class="form-control" placeholder="Input Grade" aria-label="Input student's name" aria-describedby="students-name">
                            </div>
                        </div>
                    </div>
                </div>
                <br>

                <!-- main -->
                <div class="border main-body">
                    
                    <!-- new question -->
                    <div class="new-question-container">
                        <button role="" class="btn btn-light create-question fw-bold no-show"><i class="fas fa-plus"></i> Create New Criteria</button>

                        <!-- new question template -->
                        <div class="border new-question-template new-question-template-origo d-none">
                            <div class="new-question-header">
                                <div class="input-group mb-3 dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                    <input type="text" class="form-control new-question-no bg-light" placeholder="X" aria-label="X" maxlength="6">
                                    <input type="text" class="form-control new-question-text bg-light" placeholder="New Question text goes here" aria-label="New Question text goes here">
                                    <span class="visually-hidden">Toggle Dropdown</span>
                                </div>

                               <!--  <button type="button" class="btn btn-light" style="font-size: 13px;">GO TO</button>
                                <button type="button" class="btn btn-secondary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="visually-hidden">Toggle Dropdown</span>
                                </button> -->
                                <ul class="dropdown-menu bg-dark" style="max-height: 400px;overflow-y: auto;">
                                    <?php 
                                        $assignment->assignment_names();
                                    ?>
                                </ul>
                            </div>

                            <!-- grades -->
                            <div class="new-question-grades container-fluid">
                                <div class="row">
                                    <!-- grade criteria -->
                                    <div class="col-4">
                                        <button onclick="create_newfield(this)" role="button" class="btn btn-warning text-center text-white remark no-show">SIMPLE <i class="fas fa-plus"></i></button>
                                        <div class="input-group mb-3 new-question-field">
                                            <div class="input-group-text">
                                                <input onchange="activate_grade(this)" class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input"> <span class="grade-simple"><b>E »</b></span>
                                            </div>

                                            <textarea oninput="auto_resize(this)" class="form-control bg-light" aria-label="With textarea" placeholder="Criteria description goes here"></textarea>
                                        </div>
                                    </div>
                                    <!-- END grade criteria -->

                                    <!-- grade criteria -->
                                    <div class="col-4">
                                        <button onclick="create_newfield(this)" role="button" class="btn btn-primary text-center text-white remark no-show">A BIT BETTER <i class="fas fa-plus"></i></button>
                                        <div class="input-group mb-3 new-question-field">
                                            <div class="input-group-text">
                                                <input onchange="activate_grade(this)" class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input"> <span class="grade-better"><b>C »</b></span>
                                            </div>

                                            <textarea oninput="auto_resize(this)" class="form-control bg-light" aria-label="With textarea" placeholder="Criteria description goes here"></textarea>
                                        </div>
                                    </div>
                                    <!-- END grade criteria -->

                                    <!-- grade criteria -->
                                    <div class="col-4">
                                        <button onclick="create_newfield(this)" role="button" class="btn btn-success text-center text-white remark no-show">CLEAR AND DETAILED <i class="fas fa-plus"></i></button>
                                        <div class="input-group mb-3 new-question-field">
                                            <div class="input-group-text">
                                                <input onchange="activate_grade(this)" class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input"> <span class="grade-detailed"><b>A »</b></span>
                                            </div>

                                            <textarea oninput="auto_resize(this)" class="form-control bg-light" aria-label="With textarea" placeholder="Criteria description goes here"></textarea>
                                        </div>
                                    </div>
                                    <!-- END grade criteria -->

                                    <!-- grade criteria -->
                                    <div class="col-12 border-bottom">
                                        <button onclick="create_newfield(this)" role="button" class="btn btn-danger text-center text-white remark no-show"><i class="fas fa-plus"></i></button>
                                        <div class="input-group mb-3 new-question-field">
                                            <div class="input-group-text">
                                                <input onchange="activate_grade(this)" class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input"> <span class="grade-failure"><b>F »</b></span>
                                            </div>

                                            <textarea oninput="auto_resize(this)" class="form-control bg-light" aria-label="With textarea" placeholder="Criteria description goes here"></textarea>
                                        </div>
                                    </div>
                                    <!-- END grade criteria -->
                                    <!-- <hr class="col-12"> -->

                                    <!-- feed forward -->
                                    <div class="col-12 container-fluid feed-forward-container" style="margin-top: 10px;">
                                        <div class="row">
                                            <div class="col-12 col-md-6">
                                                <div class="input-group mb-3 new-question-field">
                                                    <div class="input-group-text">
                                                        <input class="form-check-input mt-0" type="checkbox" value="" aria-label="How to go from E - C"> <span><b>[E - C] </b></span>
                                                    </div>

                                                    <textarea class="form-control bg-light" aria-label="With textarea" placeholder="How to go from E - C"></textarea>
                                                </div>
                                            </div>

                                            <div class="col-12 col-md-6">
                                                <div class="input-group mb-3 new-question-field">
                                                    <div class="input-group-text">
                                                        <input class="form-check-input mt-0" type="checkbox" value="" aria-label="How to go from C - A"> <span><b>[C - A] </b></span>
                                                    </div>

                                                    <textarea class="form-control bg-light" aria-label="With textarea" placeholder="How to go from C - A"></textarea>
                                                </div>
                                            </div>

                                            <!-- student feedback -->
                                            <div class="col-12 container-fluid" style="padding-top: 5px;padding-bottom: 0;margin-bottom: 0">
                                                <div class="mb-3 row">
                                                    <p class="text-center fw-bold col-12" style="font-size: 18px;">Comments</p>
                                                    <div class="col-12 col-md-6">
                                                        <div onclick="create_newfield(this)" class="make-field d-flex justify-content-center teacher-view">
                                                            <p class="text-center" style="cursor: pointer;">Student <i class="fas fa-circle-plus" style="margin-left: 2px;"></i></p>
                                                        </div>
                                                        <div class="mb-3" style="padding-bottom: 0 !important;">
                                                            <textarea class="form-control bg-light" aria-label="With textarea" placeholder="Extra-Comment for the Student"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 col-md-6">
                                                        <div onclick="create_newfield(this)" class="make-field d-flex justify-content-center">
                                                            <p class="text-center teacher-view" style="cursor: pointer;">Teacher <i class="fas fa-circle-plus" style="margin-left: 2px;"></i></p>
                                                        </div>

                                                        <div class="mb-3" style="padding-bottom: 0 !important;">
                                                            <textarea class="form-control bg-light" aria-label="With textarea" placeholder="Extra-Comment for the Teacher"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END student feed back -->

                                            <!-- student feedback -->
                                            <!-- <div class="col-12">
                                                <div class="mb-3">
                                                    <textarea class="form-control bg-light" aria-label="With textarea" placeholder="Feeback for the Student"></textarea>
                                                </div>
                                            </div> -->
                                            <!-- END student feed back -->

                                            <!-- teacher feedback -->
                                            <!-- <div class="col-12">
                                                <div class="mb-3">
                                                    <textarea class="form-control bg-light" aria-label="With textarea" placeholder="Private notes"></textarea>
                                                </div>
                                            </div> -->
                                            <!-- END teacher feed back -->
                                        </div>
                                    </div>
                                    <!-- END feed forward -->
                                </div>
                            </div>
                            <!-- END grades -->
                        </div>
                        <!-- END new question template -->
                    </div>
                    <!-- END new question -->

                    <!-- questions -->
                    <div class="question-container">
                        <!-- question -->
                        <?php 
                            // display assignment questions
                            $assignment->show_questions($students_assignment['questions']);
                        ?>
                    </div>
                    <!-- END questions -->
                </div>
                <!-- END main -->

                <div class="teacher-view" style="float: right;margin-bottom: 10px;">
                    <button role="button" class="btn btn-primary" id="submit">Submit <i class="fas fa-send"></i></button>
                </div>
            </div>
            <!-- END header -->

        </div>
        <!-- END page content -->

        <!-- jQuery library -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        
        <!-- Latest compiled JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

        <!-- font awesome library -->
        <script src="https://kit.fontawesome.com/6030f7206a.js" crossorigin="anonymous"></script>

        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script> -->
        <!-- <script src="https://unpkg.com/jspdf@latest/dist/jspdf.umd.min.js"></script> -->
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script> -->

        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js" integrity="sha256-c3RzsUWg+y2XljunEQS0LqWdQ04X1D3j22fd/8JCAKw=" crossorigin="anonymous"></script> -->
 
        <script src="js/new-question.js"></script>
        <script src="js/index.js"></script>
    </body>

</html>