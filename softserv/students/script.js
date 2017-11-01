/*jslint devel: true */
/*jslint browser: true*/
/*global $, jQuery, alert*/
/*Calling text_convert and getting zone information*/

var students = [];

function generate_list() {
    "use strict";
    var str = students;
    
    $('#list-students').append(str);
	var student_str;
	$.each(students, function(utorid, data) {
		student_str = "<td>" + utorid + "</td>" + "<td>" + data.firstname + "</td>" + "<td>" + data.lastname + "</td>";
		student_str = "<tr>" + student_str + "</tr>";
		str += student_str;
	})
	$("#list-students").empty();
	$("#list-students").append(str);
}

function getstudents() {
    "use strict";
    console.log("hey");

    $.getJSON("../php/getstudents.php", function(data) {
        console.log("success!");
    }).done(function(data) {
		console.log(data);
		students = data;
        generate_list();
        console.log("done");
    }).fail(function(data) {
        console.log("error");
    }).always(function(data) {
        console.log("complete");
    });
}

function insertstudent() {
	var fieldvals = [];
	fieldvals[0] = $("#newstudent-utorid").val();
	fieldvals[1] = $("#newstudent-firstname").val();
	fieldvals[2] = $("#newstudent-lastname").val();
	fieldvals[3] = $("#newstudent-password").val();
	
	var param = {
		fieldvals:fieldvals
	}
	
	console.log(param);
	
	$.getJSON("../php/insertstudent.php", param, function(data) {
        console.log("success!");
    }).done(function(data) {
		console.log(data);
        console.log("done");
		getstudents();
    }).fail(function(data) {
        console.log("error");
    }).always(function(data) {
        console.log("complete");
    });
}
$(document).ready(function() {
    "use strict";
	//loadnav();
	//introanimation();
    getstudents();
});