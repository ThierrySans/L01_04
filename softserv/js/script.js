var navApp = angular.module('navApp', ['ngRoute']);

    // configure our routes
    navApp.config(function($routeProvider) {
        $routeProvider.when('/', {
						templateUrl : 'pages/home.html',
						controller  : 'mainController'
					})
					.when('/prof-students', {
						templateUrl : 'pages/prof-students.html',
						controller  : 'prof-studentsController'
					})
					.when('/prof-newproblemset', {
						templateUrl : 'pages/prof-newproblemset.html',
						controller  : 'prof-newproblemsetController'
					})
					.when('/prof-problemsets', {
						templateUrl : 'pages/prof-problemsets.html',
						controller  : 'prof-problemsetsController'
					})
			        .when('/prof-viewproblemset', {
						templateUrl : 'pages/prof-viewproblemset.html',
						controller  : 'prof-viewproblemsetController'
					})
					.when('/student-problemsets', {
						templateUrl : 'pages/student-problemsets.html',
						controller : 'student-problemsetsController'
					})
					.when('/student-viewproblemset', {
						templateUrl : 'pages/student-viewproblemset.html',
						controller : 'student-viewproblemsetController'
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
		getData: function(){
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
		getData: function(){
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
        $scope.message = 'Everyone come and see how good I look!';
		
		$scope.profnav = function() {
			window.location.href = "../softserv/#!prof-students";
		}
		

		$scope.studnav = function() {
			// login edit start ------------------------------------------
			var config = {
				params: {
					username: $scope.username,
					password: $scope.password
				},
				headers : {'Accept' : 'application/json'}
			}


			$http.get("php/login.php",config).then(function(data) {
				console.log("getting login status",data);
				$scope.loginSuccess = data.data;
				console.log("login status: ",$scope.loginSuccess);

				if ($scope.loginSuccess === 0){ // strcmp result is 0
				console.log("successful login!");
				window.location.href = "../softserv/#!student-problemsets";
				accountService.setData($scope.username);
			}
			});
			
			// login edit end ------------------------------

		}

    });

    // *****************************************
	// *****************************************
	// PROFESSOR ADDING STUDENTS
	// *****************************************
	// *****************************************
	navApp.controller('prof-studentsController', function($scope, $http) {
        // create a message to display in our view
        $scope.getstudents = function() {
			$http.get("php/getstudents.php").then(function(data) {
				console.log("getting students");
				$scope.students = data.data;
				console.log($scope.students);
				//$scope.$apply();
			});	
		}	
		
		$scope.addstudent = function () {
			var config = {
				params: {
					utorid: $scope.utorid,
					firstname: $scope.firstname,
					lastname: $scope.lastname,
					password: $scope.password
				},
				headers : {'Accept' : 'application/json'}
			}
			console.log("called this function");
			$http.get("php/insertstudent.php", config).then(function(data) {
				console.log(data);
				$scope.getstudents();
				//$scope.$apply();
			});
			
		}
		$scope.getstudents();
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
		
		/*
		*/
		$scope.getUnits = function () {
			console.log("called this function");
			$http.get("php/getunits.php").then(function(data) {
				console.log(data);
				$scope.units = data.data;
				//$scope.$apply();
			});
			
		}
		$scope.getUnits();
		/*
		function to generate a question field group
		with a question field, and answer field.
		*/
		$scope.genQuestionField = function(num) {
			var qLabel = "<label for='question" + num + "'>Question " + num + "</label>";
			var qTextArea = "<textarea class='form-control' rows='5' ng-model='(questions[" + num + "]).question'></textarea>";
			var qFormGroup = "<div class='form-group' id='question" + num + "'>" + qLabel + qTextArea + "</div>";
			
			var aLabel = "<label for='answer" + num + "'>Answer " + num + "</label>";
			var aTextArea = "<input type='text' class='form-control' ng-model='(questions[" + num + "]).answer'></input>";
			var aFormGroup = "<div class='form-group' id='answer" + num + "'>" + aLabel + aTextArea + "</div>";
		  
			var deleteButton = "<button type='button' onclick='deletequestion(" + num + ")'>Delete</button>";
			
			var string = qFormGroup + aFormGroup;
			
			return string;
		}
		
		/*
		function to add question field groups.
		*/
		$scope.addquestion = function() {
			
			$scope.numquestions += 1;
			$scope.questions[$scope.numquestions] = {
				question: "",
				answer: ""
			};
			var string = $scope.genQuestionField($scope.numquestions);
			$("#question-container").append($compile(string)($scope));
			
		}
		
		$scope.addproblemset = function() {
	
			//Create an array of valid questions and answers
			$scope.validquestions = [];
			//Pass this array, and other data to PHP to update database
			
			for (var i=1; i<$scope.questions.length; i++){
				//Checks if question & answer is empty
				var question = ($scope.questions[i]).question;
				var answer = ($scope.questions[i]).answer;
				//If both are non-empty, then add to the questions database
				if (/\S/.test(question)) {
					if (/\S/.test(answer)) {
						var questionSet = {question: question,
										   answer: answer}
						$scope.validquestions.push(questionSet);
					}
				}
			}
			var config = {
				params: {
					unitid: $scope.unitid,
					problemsetname: $scope.problemsetname,
					datedue: $scope.datedue,
					questions: angular.toJson($scope.validquestions)
				},
				headers : {'Accept' : 'application/json'}
			}
				
			$http.get("php/insertproblemset.php", config).then(function(data) {
				console.log(data);
			});
		
			
		}
		
	});	
	// *****************************************
	// *****************************************
	// PROBLEM SETS DISPLAY AND ADDING UNITS
	// *****************************************
	// *****************************************
	navApp.controller('prof-problemsetsController', function($scope, $http, dataService) {
		$scope.getproblemsets = function() {
			$http.get("php/getproblemsetinfo.php").then(function(data) {
				console.log("getting problem set info");
				$scope.unitproblemsets = data.data;
				console.log($scope.unitproblemsets);
				//$scope.$apply();
			});	
		}
		$scope.viewproblemset = function(id) {
			console.log("from problemsets page, the id ps id", id);
			dataService.setData(id);
			console.log(dataService);
			window.location.href = "../softserv/#!prof-viewproblemset";
		}
		$scope.getproblemsets();
	});

    navApp.controller('student-problemsetsController', function($scope, $http, dataService, accountService) {
    		$scope.user = accountService.getData();
		console.log("accout user is",$scope.user);
    	
		$scope.getproblemsets = function() {
			$http.get("php/getproblemsetinfo.php").then(function(data) {
				console.log("getting problem set info");
				$scope.unitproblemsets = data.data;
				console.log($scope.unitproblemsets);
				//$scope.$apply();
			});	
		}
		$scope.viewproblemset = function(id) {
			console.log("from problemsets page, the id ps id", id);
			dataService.setData(id);
			console.log(dataService);
			window.location.href = "../softserv/#!student-viewproblemset";
		}
		$scope.getproblemsets();
	});
	
    // *****************************************
	// *****************************************
	// PROBLEM SET VIEW
	// *****************************************
	// *****************************************
	navApp.controller('prof-viewproblemsetController', function($scope, $http, dataService) {
		$scope.problemsetid = dataService.getData();
		console.log("problemsetid",$scope.problemsetid);
		$scope.getquestions = function() {
			var config = {
				params: {
					problemsetid: $scope.problemsetid
				},
				headers : {'Accept' : 'application/json'}
			}
			console.log("config",config);
			$http.get("php/getproblemset.php",config).then(function(data) {
				console.log("getting problem set questions",data);
				$scope.problemset = data.data;
				console.log("problemset",$scope.problemset);
				//$scope.$apply();
			});	
		}
		$scope.getquestions();
	});
	
	// *****************************************
	// *****************************************
	// PROBLEM SET VIEW FOR STUDENTS
	// *****************************************
	// *****************************************
	navApp.controller('student-viewproblemsetController', function($scope, $http, dataService, accountService) {
		$scope.user = accountService.getData();
		console.log($scope.user);
		$scope.problemsetid = dataService.getData();
		console.log("problemsetid",$scope.problemsetid);
		$scope.getquestions = function() {
			var config = {
				params: {
					problemsetid: $scope.problemsetid
				},
				headers : {'Accept' : 'application/json'}
			}
			console.log("config",config);
			$http.get("php/getproblemset.php",config).then(function(data) {
				console.log("getting problem set questions",data);
				$scope.problemset = data.data;
				console.log("problemset",$scope.problemset);
				//$scope.$apply();
			});	
		}
		$scope.getquestions();
		
		//INCOMPLETE 
		//INCOMPLETE
		//INCOMPLETE
		//INCOMPLETE
		// needs to record the results somewhere

		$scope.checkanswers = function() {
			var config = {
				params: {
					answer: $scope.answer,
					realanswer: $scope.problemset.answer
				},
				headers : {'Accept' : 'application/json'}
			}
			for (i=0; i<answer.length; i++) {
				if (answer == realanswer) {
					console.log("right");
				} else {
					console.log("wrong");
				}
			}
		}
	});