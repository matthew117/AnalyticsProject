$(function() {
	d3.csv("data/school_data.csv", function(data) {
		data.forEach(function(d, i) {
			var $row = $("#schools").append("<tr><td>" + d.establishmentName + "</td></tr>");
		});
	});
});
