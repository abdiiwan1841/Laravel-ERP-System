/*=========================================================================================
    File Name: app-users.js
    Description: Users page
    --------------------------------------------------------------------------------------
    Item Name: Frest HTML Admin Template
    Version: 1.0
    Author: PIXINVENT
    Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/
$(document).ready(function () {

    // variable declaration
    var defaultTable;

    //datatable initialization
    if ($("#default-app-datatable").length > 0) {
        defaultTable = $("#default-app-datatable").DataTable({
            responsive: true,
        });
    };

    //Start users index page datatable filters
    // page users list verified filter
    $("#default-datatable-userCreateDate").on("change", function () {
        var usersVerifiedSelect = $("#default-datatable-userCreateDate").val();
        console.log(usersVerifiedSelect);
        defaultTable.columns([3]).search(usersVerifiedSelect).draw();
        $("#default-datatable-role option").removeAttr('selected');
    });

    // page users list role filter
    $("#default-datatable-role").on("change", function () {
        var usersRoleSelect = $("#default-datatable-role").val();
        // console.log(usersRoleSelect);
        // defaultTable.columns([6]).search( usersRoleSelect ? '^'+usersRoleSelect+'$' : '', true, false).draw();
        defaultTable.columns([5]).search(usersRoleSelect).draw();
        $("#default-datatable-role option").removeAttr('selected');
    });

    // page users list status filter
    $("#default-datatable-status").on("change", function () {
        var usersStatusSelect = $("#default-datatable-status").val();
        // console.log(usersStatusSelect);
        defaultTable.columns([7]).search(usersStatusSelect).draw();
        $("#default-datatable-role option").removeAttr('selected');
    });

    // page users list status filter
    $("#default-datatable-department").on("change", function () {
        var usersDepartmentSelect = $("#default-datatable-department").val();
        // console.log(usersStatusSelect);
        defaultTable.columns([6]).search(usersDepartmentSelect).draw();
        $("#default-datatable-role option").removeAttr('selected');
    });

    // page users list clear filter
    $(".default-datatable-clear").on("click", function(){
        defaultTable.search("").draw();
        // defaultTable.columns([5]).search("").draw();
        // defaultTable.columns([7]).search("").draw();
        $("#default-datatable-userCreateDate").pickadate('clear');
        $("#default-datatable-role option").removeAttr('selected');
    })
    //End users index page datatable filters
});
