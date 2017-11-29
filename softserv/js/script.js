
var navApp = angular.module('navApp', ['ngRoute']);

// configure our routes and corresponding controller
navApp.config(function($routeProvider) {
    $routeProvider.when('/', {
            templateUrl: 'pages/home.html',
            controller: 'mainController'
        })
        .when('/prof-students', {
            templateUrl: 'pages/prof-students.html',
            controller: 'prof-studentsController'
        })
        .when('/prof-newproblemset', {
            templateUrl: 'pages/prof-newproblemset.html',
            controller: 'prof-newproblemsetController'
        })
        .when('/prof-problemsets', {
            templateUrl: 'pages/prof-problemsets.html',
            controller: 'prof-problemsetsController'
        })
        .when('/prof-grades-problemsets', {
            templateUrl: 'pages/prof-grades-problemsets.html',
            controller: 'prof-grades-problemsetsController'
        })
        .when('/prof-viewproblemset', {
            templateUrl: 'pages/prof-viewproblemset.html',
            controller: 'prof-viewproblemsetController'
        })
        .when('/student-problemsets', {
            templateUrl: 'pages/student-problemsets.html',
            controller: 'student-problemsetsController'
        })
        .when('/student-viewproblemset', {
            templateUrl: 'pages/student-viewproblemset.html',
            controller: 'student-viewproblemsetController'
        })
        .when('/prof-studentproblemsetgrades', {
            templateUrl: 'pages/prof-studentproblemsetgrades.html',
            controller: 'prof-studentproblemsetgradesController'
        })
        .when('/prof-badges', {
            templateUrl: 'pages/prof-badges.html',
            controller: 'prof-badgesController'
        });
});
//PASSING DATA SERVICE
navApp.service('dataService', function() {
    var data = {
        problemsetid: '0'
    };
    return {
        setData: function(newObj) {
            data.problemsetid = newObj;
        },
        getData: function() {
            return data.problemsetid;
        }
    };

});

//PASSING ACCOUNT SERVICE
navApp.service('accountService', function() {
    var data = {
        utorid: ''
    };
    return {
        setData: function(newObj) {
            data.utorid = newObj;
        },
        getData: function() {
            return data.utorid;
        }
    };

});
// *****************************************
// *****************************************
// HOME PAGE CONTROLLER
// *****************************************
// *****************************************
navApp.controller('mainController', function($scope, $http, accountService) {
    // create a message to display in our view
    //$scope.message = 'Everyone come and see how good I look!';

    $scope.profnav = function() {
        window.location.href = "../softserv/#!prof-students";
    }


    $scope.studnav = function() {
        if ($scope.username != "" && $scope.password != "") {
            var config = {
                params: {
                    username: $scope.username,
                    password: $scope.password
                },
                headers: {
                    'Accept': 'application/json'
                }
            }


            $http.get("php/login.php", config).then(function(data) {
                //console.log("getting login status", data);
                $scope.loginSuccess = data.data;
                //console.log("login status: ", $scope.loginSuccess);

                // Successul login, jump to student-problemsets page
                if ($scope.loginSuccess === 0) {
                    window.location.href = "../softserv/#!student-problemsets";
                    accountService.setData($scope.username);
                }
            });
        }

    }

});

// *****************************************
// *****************************************
// PROFESSOR ADDING STUDENTS
// *****************************************
// *****************************************
navApp.controller('prof-studentsController', function($scope, $http, accountService) {
    // get students data
    $scope.getstudents = function() {
        $http.get("php/getstudents.php").then(function(data) {
            //console.log("getting students");
            //console.log("whats going on", data);
            $scope.students = data.data;
            //console.log($scope.students);
            //$scope.$apply();
        });
    }

    // add a student
    $scope.addstudent = function() {
        var config = {
            params: {
                utorid: $scope.utorid,
                firstname: $scope.firstname,
                lastname: $scope.lastname,
                password: $scope.password
            },
            headers: {
                'Accept': 'application/json'
            }
        }
        //console.log("called this function");
        $http.get("php/insertstudent.php", config).then(function(data) {
            //console.log(data);
            $scope.getstudents();
            //$scope.$apply();
        });

    }
    $scope.getstudents();

    // jump to prof-studentproblemsetgrades page
    $scope.viewstudentgrade = function(utorid) {
        accountService.setData(utorid);
        window.location.href = "../softserv/#!prof-studentproblemsetgrades";

    }
});
// *****************************************
// *****************************************
// PROFESSOR ADDING PROBLEM SETS
// *****************************************
// *****************************************
navApp.controller('prof-newproblemsetController', function($scope, $http, $compile) {
    $scope.numquestions = 1;
    $scope.questions = [];
    $scope.questions[1] = {
        question: "",
        answer: ""
    };
    $scope.units;

    // get units from database
    $scope.getUnits = function() {
        //console.log("called this function");
        $http.get("php/getunits.php").then(function(data) {
            //console.log(data);
            $scope.units = data.data;
            //$scope.$apply();
        });

    }
    $scope.getUnits();
    /*
    function to generate a question field group
    with a question field, variable field and answer field.
    */
    $scope.genQuestionField = function(num) {
        var qLabel = "<label for='question" + num + "'>Question " + num + "</label>";
        var qTextArea = "<textarea class='form-control' rows='5' ng-model='(questions[" + num + "]).question'></textarea>";
        var qFormGroup = "<div class='form-group' id='question" + num + "'>" + qLabel + qTextArea + "</div>";

        var vLabel = "<label for='variables" + num + "'>Variables " + num + "</label>";
        var vTextArea = "<textarea class='form-control' rows='3' ng-model='(questions[" + num + "]).variables'></textarea>";
        var vFormGroup = "<div class='form-group' id='variables" + num + "'>" + vLabel + vTextArea + "</div>";

        var aLabel = "<label for='answer" + num + "'>Answer " + num + "</label>";
        var aTextArea = "<input type='text' class='form-control' ng-model='(questions[" + num + "]).answer'></input>";
        var aFormGroup = "<div class='form-group' id='answer" + num + "'>" + aLabel + aTextArea + "</div>";

        var deleteButton = "<button type='button' onclick='deletequestion(" + num + ")'>Delete</button>";

        var string = "<div style='border: 1px solid #EEEEEE; padding: 10px; margin: 10px'>" + qFormGroup + vFormGroup + aFormGroup + "</div>";

        return string;
    }

    /*
    function to add question field groups.
    */
    $scope.addquestion = function() {

        $scope.numquestions += 1;
        $scope.questions[$scope.numquestions] = {
            question: "",
            variables: "",
            answer: ""
        };
        var string = $scope.genQuestionField($scope.numquestions);
        $("#question-container").append($compile(string)($scope));

    }

    // add problem set
    $scope.addproblemset = function() {

        //Create an array of valid questions, variables and answers
        $scope.validquestions = [];
        //Pass this array, and other data to PHP to update database

        for (var i = 1; i < $scope.questions.length; i++) {
            //Checks if question, variable & answer is empty
            var question = ($scope.questions[i]).question;
            var variables = ($scope.questions[i]).variables;
            var answer = ($scope.questions[i]).answer;
            //If both are non-empty, then add to the questions database
            if (/\S/.test(question)) {
                if (/\S/.test(answer)) {
                    var questionSet = {
                        question: question,
                        variables: variables,
                        answer: answer
                    }
                    $scope.validquestions.push(questionSet);
                }
            }
        }
        //console.log("valid questions", $scope.validquestions);
        var config = {
            params: {
                unitid: $scope.unitid,
                problemsetname: $scope.problemsetname,
                datedue: $scope.datedue,
                questions: angular.toJson($scope.validquestions)
            },
            headers: {
                'Accept': 'application/json'
            }
        }

        // passing problem set data to database
        $http.get("php/insertproblemset.php", config).then(function(data) {
            //console.log(data);
        });


    }

    /*
     *Adds a new unit into the database
     */
    $scope.addunit = function() {
        var config = {
            params: {
                unitname: $scope.unitname
            },
            headers: {
                'Accept': 'application/json'
            }
        }
        // passing unit data to database
        $http.get("php/insertunit.php", config).then(function(data) {
            //console.log(data);
        });
        // update the units in the display
        $scope.getUnits();
    }

});

// *****************************************
// *****************************************
// PROFESSORS PROBLEM SET GRADES FOR STUDENT
// *****************************************
// *****************************************
navApp.controller('prof-studentproblemsetgradesController', function($scope, $http, dataService, accountService) {

    $scope.user = accountService.getData();

    // get all grades of one student
    $scope.getproblemsets = function() {
        var config = {
            params: {
                username: $scope.user
            },
            headers: {
                'Accept': 'application/json'
            }
        }
        $http.get("php/retrievegradesall_student.php", config).then(function(data) {
            //console.log("getting problem set info");
            $scope.unitproblemsets = data.data;
            //console.log($scope.unitproblemsets);
            //$scope.$apply();
        });
    }
    $scope.getproblemsets();
});

// *****************************************
// *****************************************
// PROFESSORS PROBLEM SETS DISPLAY (VIEWING ALL)
// *****************************************
// *****************************************
navApp.controller('prof-problemsetsController', function($scope, $http, dataService) {
    // get al problem sets
    $scope.getproblemsets = function() {
        $http.get("php/getproblemsetinfo.php").then(function(data) {
            //console.log("getting problem set info");
            $scope.unitproblemsets = data.data;
            //console.log($scope.unitproblemsets);
            //$scope.$apply();
        });
    }

    // view one specific problem set, jump to prof=viewproblemset page
    $scope.viewproblemset = function(id) {
        //console.log("from problemsets page, the id ps id", id);
        dataService.setData(id);
        //console.log(dataService);
        window.location.href = "../softserv/#!prof-viewproblemset";
    }


    $scope.getproblemsets();



    /*
    This function deletes a problem set with the given id
    */
    $scope.deleteproblemset = function(id) {
        //console.log("deleting problem set with id ", id);
        var config = {
            params: {
                problemsetid: id
            },
            headers: {
                'Accept': 'application/json'
            }
        }
        // passing problem set id to database for deletion
        $http.get("php/deleteproblemset.php", config).then(function(data) {
            //console.log(data);
        });
        $scope.getproblemsets();
    }

});

// *****************************************
// *****************************************
// (MULTIPLE) PROBLEM SET VIEW FOR STUDENTS
// *****************************************
// *****************************************
navApp.controller('student-problemsetsController', function($scope, $http, dataService, accountService) {
    $scope.user = accountService.getData();
    //console.log("accout user is", $scope.user);
    // get all problem set data for this student
    $scope.getproblemsets = function() {
        var config = {
            params: {
                username: $scope.user
            },
            headers: {
                'Accept': 'application/json'
            }
        }
        $http.get("php/retrievegradesall_student.php", config).then(function(data) {
            //console.log("getting problem set info");
            //console.log(data);
            $scope.unitproblemsets = data.data;
            //console.log($scope.unitproblemsets);
            //$scope.$apply();
        });
    }
    // view one specific problem set for this student, jump to student-view problemset page
    $scope.viewproblemset = function(id) {
        //console.log("from problemsets page, the id ps id", id);
        dataService.setData(id);
        //console.log(dataService);
        window.location.href = "../softserv/#!student-viewproblemset";
    }
    $scope.getproblemsets();


});

// *****************************************
// *****************************************
// (SINGLE) PROBLEM SET VIEW FOR PROFESSORS
// *****************************************
// *****************************************
navApp.controller('prof-viewproblemsetController', function($scope, $http, dataService) {
    $scope.problemsetid = dataService.getData();
    //console.log("problemsetid", $scope.problemsetid);

    // get the questions for the specific problem set
    $scope.getquestions = function() {
        var config = {
            params: {
                problemsetid: $scope.problemsetid
            },
            headers: {
                'Accept': 'application/json'
            }
        }
        //console.log("config", config);
        // get data of this problem set
        $http.get("php/getproblemset_prof.php", config).then(function(data) {
            //console.log("getting problem set questions", data);
            $scope.problemset = data.data;
            //console.log("problemset", $scope.problemset);
            //$scope.$apply();
        });
    }

    // get the student grades for the problem set
    $scope.retrievegrades = function() {
        var config = {
            params: {
                problemsetid: $scope.problemsetid
            },
            headers: {
                'Accept': 'application/json'
            }
        }
        //console.log("config", config);
        // get grades for all students for this problem set
        $http.get("php/retrievegradesall_problemset.php", config).then(function(data) {
            //console.log("getting problem set grades for this problem set", data);
            $scope.problemsetgrades = data.data;
            //console.log("problemset", $scope.problemsetgrades);
            //$scope.$apply();
        });
    }

    /*
    This function grabs all grades of students separated by interval with
    each being 20% in length. It then generates a graph of student performance.
    */
    $scope.graphgrades = function() {
        var intervalgrades = [];
        var config = {
            params: {
                problemsetid: $scope.problemsetid
            },
            headers: {
                'Accept': 'application/json'
            }
        }
        $http.get("php/retrievegradesdistribution.php", config).then(function(data) {
            $scope.intervalgrades = data.data;

            //parsing the interval grades array into regular JS array
            $.each($scope.intervalgrades, function(range, numstudents) {
                var new_arr = [range, numstudents];
                intervalgrades.push(new_arr);
            });
            //graphing the grades distribution
			/*
			This function draws the distribution graph. It takes as input
			data from the web service that returns grades separated by intervals.
			*/
			console.log(intervalgrades);
			google.charts.load('current', {
            packages: ['corechart', 'bar']
			});
			google.charts.setOnLoadCallback(drawTrendLines);
			function drawTrendLines() {
				var data = new google.visualization.DataTable();
				data.addColumn('string', 'Grade');
				data.addColumn('number', 'Number of Students');
				data.addRows(intervalgrades);

				var options = {
					title: 'Student Grades for Problem Set',
					hAxis: {
						title: 'Achieved Grade (%)',
					},
					vAxis: {
						title: 'Number of Students'
					}
				};

				var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
				chart.draw(data, options);
			}
            
        });

    }

    $scope.getquestions();
    $scope.retrievegrades();
    $scope.graphgrades();
});

// *****************************************
// *****************************************
// (SINGLE) PROBLEM SET VIEW FOR STUDENTS
// *****************************************
// *****************************************
navApp.controller('student-viewproblemsetController', function($scope, $http, dataService, accountService) {
    $scope.show_mark = false;
    $scope.user = accountService.getData();
    //console.log($scope.user);
    $scope.problemsetid = dataService.getData();
    //console.log("problemsetid", $scope.problemsetid);

    $scope.stuAnswer = [];

    // get questions in this problem set
    $scope.getquestions = function() {
        var config = {
            params: {
                problemsetid: $scope.problemsetid
            },
            headers: {
                'Accept': 'application/json'
            }
        }
        //console.log("config", config);
        // get data of this problem set for this student
        $http.get("php/getproblemset_student.php", config).then(function(data) {
            //console.log("getting problem set questions", data);
            $scope.problemset = data.data;
            console.log("problemset", data);
            //$scope.$apply();
        });
    }
    $scope.getquestions();

    // compare student's solution to real answer and calcualte the grade
    $scope.checkanswers = function() {
        var stuAnsIter = 0;
        var countCorrectAnswer = 0;
        var str = "";
        $.each($scope.problemset, function(qid, qdata) {

            var result = "incorrect";
            //console.log("Comparing answers");
            if ($scope.stuAnswer[stuAnsIter] == qdata.answer) {
                result = "correct";
                countCorrectAnswer += 1;
            }

            var answerStr = "<tr><td>" + $scope.stuAnswer[stuAnsIter] + "</td><td>" + qdata.answer + "</td><td>" + result + "</td></tr>";
            str += answerStr;
            stuAnsIter += 1;
        });

        $scope.mark = countCorrectAnswer / $scope.stuAnswer.length;
        $scope.show_mark = true;

        // display the mark
        $("#display-answers").empty();
        $("#display-answers").append(str);

        //Setting up data to send to ssend
        //$scope.user for utorid
        //$scope.problemsetid for problemsetid
        $scope.updatemark = function() {
            var config = {
                params: {
                    username: $scope.user,
                    problemsetid: $scope.problemsetid,
                    mark: $scope.mark
                },
                headers: {
                    'Accept': 'application/json'
                }
            }
            //console.log("config", config);
            // passing grade to database for update
            $http.get("php/storegrades.php", config).then(function(data) {
                //console.log("storing the grades", data);
                //$scope.$apply();
            });
        }
        $scope.updatemark();

    }
});

// *****************************************
// *****************************************
// PROFESSOR BADGES INSERTION
// *****************************************
// *****************************************
navApp.controller('prof-badgesController', function($scope, $http, dataService, accountService) {
    $scope.badgequalificationlabel = "Minimum Course Average:";
    $scope.badge2 = false;
    // there are 3 type of badges
    $scope.badgeTypeChange = function() {
        if ($scope.badgetype == "1") {
            $scope.badgequalificationlabel = "Minimum Course Average:";
            $scope.badge2 = false;
        } else if ($scope.badgetype == "2") {
            $scope.badgequalificationlabel = "Minimum Problem Set Average:";
            $scope.badge2 = true;
        } else {
            $scope.badgequalificationlabel = "Minimum Number of Problem Sets Completed:";
            $scope.badge2 = false;
        }
        //console.log($scope.badgetype);
    }
});