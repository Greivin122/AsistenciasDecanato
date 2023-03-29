$(document).ready(function () {
    $('#students-table').DataTable();
});

function edit_student(_this) {
    //get the closest of clicked edit button
    var tr = $(_this).closest("tr");
    //get the index of row
    var rowindex = tr.index();
    //Index of row
    console.log(rowindex)
}