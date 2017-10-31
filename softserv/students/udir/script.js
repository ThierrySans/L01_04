/*jslint devel: true */
/*jslint browser: true*/
/*global $, jQuery, alert*/
/*Calling text_convert and getting zone information*/

var units = [];

function generate_list() {
    "use strict";
    var str = units;
    
    $('#list-units').append(str);
	var unit_str;
	$.each(units, function(id, data) {
		unit_str = "<td>" + data.name + "</td>" + "<td>" + data.start + "</td>" + "<td>" + data.end + "</td>";
		unit_str = "<tr>" + unit_str + "</tr>";
		str += unit_str;
	})
	$("#list-units").empty();
	$("#list-units").append(str);
}

function getunits() {
    "use strict";
    console.log("hey");

    $.getJSON("../../php/getunits.php", function(data) {
        console.log("success!");
    }).done(function(data) {
		console.log(data);
		units = data;
        generate_list();
        console.log("done");
    }).fail(function(data) {
        console.log("error");
    }).always(function(data) {
        console.log("complete");
    });
}

function insertunit() {
	var fieldvals = [];
	fieldvals[0] = $("#newunit-name").val();
	fieldvals[1] = $("#newunit-start").val();
	fieldvals[2] = $("#newunit-end").val();
	
	var param = {
		fieldvals:fieldvals
	}
	
	console.log(param);
	
	$.getJSON("../../php/insertunit.php", param, function(data) {
        console.log("success!");
    }).done(function(data) {
		console.log(data);
        console.log("done");
		getunits();
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
    getunits();
});