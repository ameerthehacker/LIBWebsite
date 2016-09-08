$(function () {

    var ajaxError = { title: "Internal Error!", message: 'Unable to perform a ajax request', style: 'error', location: 'tc' };

    var formUsersAdd = $("#form-users-add");
    var formBooksAdd = $("#form-books-add");
    var formJournalsAdd = $("#form-journals-add");
    var formUsersUpdate = $("#form-users-update");
    var formBooksUpdate = $("#form-books-update");
    var formJournalsUpdate = $("#form-journals-update");
    var formUsersCSV = $("#form-users-csv");
    var formBooksCSV = $("#form-books-csv");
    var formBooksIssue = $("#form-books-issue");
    var formBooksReturn = $("#form-books-return");
    var formAdminsChangePassword = $("#form-admins-change-password");
    var formJournalsUpdatePDF = $("#form-journals-update-pdf");
    var formJorunalsDownload = $("#form-journals-download");

    var fileUsersCSV = $("#file-users-csv");
    var fileBooksCSV = $("#file-books-csv");
    var fileJournalsPDF = $("#file-journals-pdf");
    var fileJournalsUpdatePDF = $("#file-journals-update-pdf");

    var labelUsersCSV = $("#label-users-csv");
    var labelBooksCSV = $("#label-books-csv");
    var labelJournalsPDF = $("#label-journals-pdf");
    var labelJorunalsUpdatePDF = $("#label-journals-update-pdf");

    var textBooksIssueDate = $("#text-books-issue-date");
    var textBooksIssueID = $("#text-books-issue-id");
    var textUsersIssueID = $("#text-users-issue-id");
    var textBooksReturnID = $("#text-books-return-id");
    var textJournalsAuthors = $("#text-journals-authors");

    var btnBooksAdd = $("#btn-books-add");
    var btnBooksDelete = $("#btn-books-delete");
    var btnBooksSelectAll = $("#btn-books-selectall");
    var btnBooksInvert = $("#btn-books-invert");
    var btnBooksUpdate = $("#btn-books-update");
    var btnBooksIssue = $("#btn-books-issue");
    var btnBooksReturn = $("#btn-books-return");
    var btnBooksRenew = $("#btn-books-renew");
    var btnAdminsChangePassword = $("#btn-admins-change-password");

    var btnUsersAdd = $("#btn-users-add");
    var btnUsersBrowseCSV = $("#btn-users-browse-csv");
    var btnBooksBrowseCSV = $("#btn-books-browse-csv");
    var btnUsersCSV = $("#btn-users-csv");
    var btnBooksCSV = $("#btn-books-csv");
    var btnJournalsPDF = $("#btn-journals-pdf");
    var btnUsersDelete = $("#btn-users-delete");
    var btnUsersSelectAll = $("#btn-users-selectall");
    var btnUsersInvert = $("#btn-users-invert");
    var btnUsersUpdate = $("#btn-users-update");
    var btnJournalsUpdatePDF = $("#btn-journals-update-pdf");
    var btnJournalsChangePDF = $("#btn-journals-change-pdf");

    var btnJournalsAdd = $("#btn-journals-add");
    var btnJournalsDelete = $("#btn-journals-delete");
    var btnJournalsUpdate = $("#btn-journals-update");
    var btnJournalsSelectAll = $("#btn-journals-selectall");
    var btnJournalsInvert = $("#btn-journals-invert");
    var btnJournalsBrowseUpdatePDF = $("#btn-journals-browse-update-pdf");
    var btnJournalsDownload = $("#btn-journals-download");

    var modalUsersUpdate = $("#modal-users-update");
    var modalBooksUpdate = $("#modal-books-update");
    var modalJournalsUpdate = $("#modal-journals-update");

    var libBooks = $("#libbooks");
    var libUsers = $("#libusers");
    var libJournals = $("#libjournals");

    var libBooksRow = $(".libbooks-row");
    var libUsersRow = $(".libusers-row");
    var libJournalsRow = $(".libjournals-row");

    var suggestJournalsAuthors = $("#suggest-journals-authors");

    var selectedUser = {};
    var selectedBook = {};
    var selectedJournal = {};
    var availableBooks = [];

    libBooks.dataTable();
    libUsers.dataTable();
    libJournals.dataTable();

    formAdminsChangePassword.ajaxForm();

    formUsersAdd.ajaxForm();
    formBooksAdd.ajaxForm();
    formJournalsAdd.ajaxForm();
    formUsersUpdate.ajaxForm();
    formJournalsUpdate.ajaxForm();
    formJournalsUpdatePDF.ajaxForm();
    formUsersCSV.ajaxForm();
    formJorunalsDownload.ajaxForm();

    formBooksCSV.ajaxForm();
    formBooksIssue.ajaxForm();
    formBooksReturn.ajaxForm();

    textBooksIssueDate.datepicker({
        dateFormat: 'yy-mm-dd'
    });

    btnBooksRenew.on('click', function (evt) {
        formBooksReturn.ajaxSubmit({
            url: 'scripts/php/books/renew.php',
            success: function (response) {
                response = jQuery.parseJSON(response);
                $.growl(response);
            }, error: function () {
                $.growl(ajaxError);
            }
        });
    });

    textBooksIssueID.on('keyup', function (evt) {
        $.ajax({
            url: 'scripts/php/books/detail.php',
            method: 'get',
            data: { id: textBooksIssueID.val() },
            success: function (response) {
                response = jQuery.parseJSON(response);
                if (response.found) {
                    $("#d-bookname").text(response.book.bookname);
                    $("#d-author").text(response.book.author);
                    $("#d-publication").text(response.book.publication);
                    $("#d-price").text(response.book.price);
                    $("#d-status").text(response.book.status);
                    if (response.book.status == "Available") {
                        $("#row-books-details").addClass("success")
                    }
                    else {
                        $("#row-books-details").addClass("danger")
                    }
                    $("#div-books-details").css({ 'display': 'block', 'visibility': 'visible' });
                }
                else {
                    $("#div-books-details").css({ 'display': 'none', 'visibility': 'hidden' });
                    $("#row-books-details").removeClass();
                }
            }, error: function () {
                $.growl(ajaxError);
            }
        });
    });

    textUsersIssueID.on('keyup', function (evt) {
        $.ajax({
            url: 'scripts/php/users/detail.php',
            method: 'get',
            data: { id: textUsersIssueID.val() },
            success: function (response) {
                response = jQuery.parseJSON(response);
                if (response.found) {
                    $("#d-username").text(response.user.username);
                    $("#d-userid").text(response.user.id);
                    $("#d-department").text(response.user.dept);
                    $("#d-category").text(response.user.category);
                    $("#div-users-details").css({ 'display': 'block', 'visibility': 'visible' });
                }
                else {
                    $("#div-users-details").css({ 'display': 'none', 'visibility': 'hidden' });
                }
            }, error: function () {
                $.growl(ajaxError);
            }
        });
    });

    textJournalsAuthors.on('keyup', function (evt) {
        var listOfAuthors = textJournalsAuthors.val();
        var authors = listOfAuthors.split(",");
        if (listOfAuthors != "") {
            $.ajax({
                url: 'scripts/php/users/getusernames.php',
                method: 'post',
                data: { id: authors },
                success: function (response) {
                    response = jQuery.parseJSON(response);
                    if (response.found) {
                        suggestJournalsAuthors.css({ 'visibility': 'visible', 'display': 'block' });
                        suggestJournalsAuthors.children().text(response.authors);
                    }
                    else {
                        suggestJournalsAuthors.children().text("");
                        suggestJournalsAuthors.css({ 'visibility': 'hidden', 'display': 'none' });
                    }
                },
                error: function (error) {
                    $.growl(ajaxError);
                }
            });
        }
        else {
            suggestJournalsAuthors.children().text("");
            suggestJournalsAuthors.css({ 'visibility': 'hidden', 'display': 'none' });
        }
    });


    textBooksReturnID.on('keyup', function (evt) {
        $.ajax({
            url: 'scripts/php/books/detail.php',
            method: 'get',
            data: { id: textBooksReturnID.val() },
            success: function (response) {
                response = jQuery.parseJSON(response);
                if (response.found && response.book.status != "Available") {
                    $("#r-bookname").text(response.book.bookname);
                    $("#r-author").text(response.book.author);
                    $("#r-publication").text(response.book.publication);
                    $("#r-price").text(response.book.price);

                    $("#r-username").text(response.book.username);
                    $("#r-userid").text(response.book.status);
                    $("#r-department").text(response.book.dept);
                    $("#r-category").text(response.book.category);

                    $("#div-return-details").css({ 'display': 'block', 'visibility': 'visible' });
                }
                else {
                    $("#div-return-details").css({ 'display': 'none', 'visibility': 'hidden' });
                }
            }, error: function () {
                $.growl(ajaxError);
            }
        });
    });

    btnBooksReturn.on('click', function (evt) {
        formBooksReturn.ajaxSubmit({
            url: 'scripts/php/books/return.php',
            success: function (response) {
                response = jQuery.parseJSON(response);
                $.growl(response);
            }, error: function () {
                $.growl(ajaxError);
            }
        });
    });

    btnUsersBrowseCSV.on('click', function (evt) {
        fileUsersCSV.trigger('click');
    });

    btnBooksBrowseCSV.on('click', function (evt) {
        fileBooksCSV.trigger('click');
    });
    btnJournalsPDF.on('click', function (evt) {
        fileJournalsPDF.trigger('click');
    });
    btnJournalsDownload.on('click',function(evt){
        formJorunalsDownload.ajaxSubmit({
            success:function(response){
                response=jQuery.parseJSON(response);
                $.growl(response);
                if(!response.error){
                    window.open('scripts/php/journals/download.php?filename='+response.filename,'_self');
                }
            },
            error:function(){
                $.growl(ajaxError);
            }
        });
    });

    fileUsersCSV.on('change', function (evt) {
        labelUsersCSV.text(fileUsersCSV[0].files[0].name);
    });

    fileBooksCSV.on('change', function (evt) {
        labelBooksCSV.text(fileBooksCSV[0].files[0].name);
    });
    fileJournalsPDF.on('change', function (evt) {
        labelJournalsPDF.text(fileJournalsPDF[0].files[0].name);
    });
    fileJournalsUpdatePDF.on('change', function (evt) {
        labelJorunalsUpdatePDF.text(fileJournalsUpdatePDF[0].files[0].name);
    });

    btnBooksIssue.on('click', function (evt) {
        formBooksIssue.ajaxSubmit({
            success: function (response) {
                response = jQuery.parseJSON(response);
                $.growl(response);
            }, error: function () {
                $.growl(ajaxError);
            }
        });
    });

    btnUsersCSV.on('click', function (evt) {
        formUsersCSV.ajaxSubmit({
            success: function (response) {
                response = jQuery.parseJSON(response);
                $.growl(response);
            }, error: function () {
                $.growl(ajaxError);
            }
        });
    });

    btnBooksCSV.on('click', function (evt) {
        formBooksCSV.ajaxSubmit({
            success: function (response) {
                response = jQuery.parseJSON(response);
                $.growl(response);
            }, error: function () {
                $.growl(ajaxError);
            }
        });
    });

    libUsersRow.on('dblclick', function (evt) {
        var fields = [];
        $(this).children('.field').each(function () {
            fields.push($(this).text());
        });
        selectedUser = fields[1];
        $("#username").val(fields[0]);
        $("#userid").val(fields[1]);
        $("#dept").children('option').each(function () {
            if ($(this).text() == fields[2]) {
                $(this).attr('selected', 'selected');
            }
        });
        $("#category").children('option').each(function () {
            if ($(this).text() == fields[3]) {
                $(this).attr('selected', 'selected');
            }
        });
        modalUsersUpdate.modal('show');
    });

    libBooksRow.on('dblclick', function (evt) {
        var fields = [];
        $(this).children('.field').each(function () {
            fields.push($(this).text());
        });
        selectedBook = fields[1];
        $("#bookname").val(fields[0]);
        $("#bookid").val(fields[1]);
        $("#author").val(fields[2]);
        if (fields[3] != "N/A") {
            $("#publication").val(fields[3]);
        }
        $("#price").val(fields[4]);
        modalBooksUpdate.modal('show');
    });

    libJournalsRow.on('dblclick', function (evt) {
        var fields = [];
        $(this).children('.field').each(function () {
            fields.push($(this).text());
        });
        selectedJournal = $(this).attr('field-id');
        $("#journalname").val(fields[0]);
        $("#journaltitle").val(fields[1]);
        $("#journalmonth").children('option').each(function () {
            if ($(this).text() == fields[3]) {
                $(this).attr('selected', 'selected');
            }
        });
        var academicyear = fields[4].split("-");
        $("#journalyearfrom").val(academicyear[0]);
        $("#journalyearto").val(academicyear[1]);
        $("#journalissue").val(fields[5]);
        $("#journalvolume").val(fields[6]);
        $("#journalimpact").val(fields[7]);

        $.ajax({
            url: 'scripts/php/journals/getauthor.php',
            method: 'post',
            data: { id: selectedJournal },
            success: function (response) {
                response = jQuery.parseJSON(response);
                if (response.found) {
                    $("#journalauthors").val(response.authors);
                    modalJournalsUpdate.modal('show');
                    $("#journalauthors").on('keyup', function (evt) {
                        var listOfAuthors = $("#journalauthors").val();
                        var authors = listOfAuthors.split(",");
                        var suggestJournalsAuthors = $("#suggest-journals-authors-for-update");
                        if (listOfAuthors != "") {
                            $.ajax({
                                url: 'scripts/php/users/getusernames.php',
                                method: 'post',
                                data: { id: authors },
                                success: function (response) {
                                    response = jQuery.parseJSON(response);
                                    if (response.found) {
                                        suggestJournalsAuthors.css({ 'visibility': 'visible', 'display': 'block' });
                                        suggestJournalsAuthors.children().text(response.authors);
                                    }
                                    else {
                                        suggestJournalsAuthors.children().text("");
                                        suggestJournalsAuthors.css({ 'visibility': 'hidden', 'display': 'none' });
                                    }
                                },
                                error: function (error) {
                                    $.growl(ajaxError);
                                }
                            });
                        }
                        else {
                            suggestJournalsAuthors.children().text("");
                            suggestJournalsAuthors.css({ 'visibility': 'hidden', 'display': 'none' });
                        }
                    });
                    $("#journalauthors").trigger('keyup');
                }
            },
            error: function (error) {
                $.growl(ajaxError);
            }
        });

    });

    btnUsersInvert.on('click', function (evt) {
        var libUsersCheckBox = $(".libusers-checkbox");
        libUsersCheckBox.each(function () {
            if ($(this).is(" :checked") && $(this).css('visibility') == 'visible') {
                $(this).prop('checked', false);
            }
            else {
                $(this).prop('checked', true);
            }
        });
    });

    btnUsersUpdate.on('click', function (evt) {
        formUsersUpdate.ajaxSubmit({
            data: { id: selectedUser }, success: function (response) {
                response = jQuery.parseJSON(response);
                $.growl(response);
            }
        });
    });
    btnBooksUpdate.on('click', function (evt) {
        formBooksUpdate.ajaxSubmit({
            data: { id: selectedBook }, success: function (response) {
                response = jQuery.parseJSON(response);
                $.growl(response);
            }
        });
    });
    btnUsersSelectAll.on('click', function (evt) {
        var libUsersCheckBox = $(".libusers-checkbox");
        libUsersCheckBox.each(function () {
            if ($(this).css('visibility') == 'visible') {
                $(this).prop('checked', true);
            }
        });
    });

    btnBooksInvert.on('click', function (evt) {
        var libBooksCheckBox = $(".libbooks-checkbox");
        libBooksCheckBox.each(function () {
            if ($(this).is(" :checked") && $(this).css('visibility') == 'visible') {
                $(this).prop('checked', false);
            }
            else {
                $(this).prop('checked', true);
            }
        });
    });

    btnUsersDelete.on('click', function () {
        var checked = [];
        var libUsersCheckBox = $(".libusers-checkbox");
        libUsersCheckBox.each(function () {
            if ($(this).is(" :checked")) {
                checked.push($(this).attr('field-id'));
            }
        });
        $.ajax({
            url: 'scripts/php/users/delete.php', method: 'POST', data: { 'checked': checked }, success: function (response) {
                response = jQuery.parseJSON(response);
                $.growl(response);
                if (!response.error) {
                    setTimeout(function () {
                        window.location.reload(true);
                    }, 2000);
                }
            }, error: function () {
                $.growl({ title: "Internal Error!", message: 'Unable to perform a ajax request', style: 'error', location: 'tc' });
            }
        });
    });

    btnBooksSelectAll.on('click', function (evt) {
        var libBooksCheckBox = $(".libbooks-checkbox");
        libBooksCheckBox.each(function () {
            if ($(this).css('visibility') == 'visible') {
                $(this).prop('checked', true);
            }
        });
    });
    btnBooksDelete.on('click', function () {
        var checked = [];
        var libBooksCheckBox = $(".libbooks-checkbox");
        libBooksCheckBox.each(function () {
            if ($(this).is(" :checked")) {
                checked.push($(this).attr('field-id'));
            }
        });
        $.ajax({
            url: 'scripts/php/books/delete.php', method: 'POST', data: { 'checked': checked }, success: function (response) {
                response = jQuery.parseJSON(response);
                $.growl(response);
                if (!response.error) {
                    setTimeout(function () {
                        window.location.reload(true);
                    }, 2000);
                }
            }, error: function () {
                $.growl(ajaxError);
            }
        });
    });

    btnJournalsSelectAll.on('click', function (evt) {
        var libJournalsCheckBox = $(".libjournals-checkbox");
        libJournalsCheckBox.each(function () {
            if ($(this).css('visibility') == 'visible') {
                $(this).prop('checked', true);
            }
        });
    });

    btnJournalsInvert.on('click', function (evt) {
        var libJournalsCheckBox = $(".libjournals-checkbox");
        libJournalsCheckBox.each(function () {
            if ($(this).is(" :checked") && $(this).css('visibility') == 'visible') {
                $(this).prop('checked', false);
            }
            else {
                $(this).prop('checked', true);
            }
        });
    });

    btnJournalsBrowseUpdatePDF.on('click', function (evt) {
        fileJournalsUpdatePDF.trigger('click');
    });

    btnJournalsChangePDF.on('click', function (evt) {
        selectedJournal = $(this).attr('journal-id');
    });

    btnUsersAdd.on('click', function (evt) {
        formUsersAdd.ajaxSubmit({
            success: function (response) {
                response = jQuery.parseJSON(response);
                $.growl(response);
            }
        });
    });

    btnJournalsUpdatePDF.on('click', function (evt) {
        formJournalsUpdatePDF.ajaxSubmit({
            data: { 'id': selectedJournal },
            success: function (resp) {
                resp = jQuery.parseJSON(resp);
                $.growl(resp);

            }, error: function () {
                $.growl(ajaxError);
            }
        });
    });

    btnJournalsDelete.on('click', function (evt) {
        var checked = [];
        var libJournalsCheckBox = $(".libjournals-checkbox");
        libJournalsCheckBox.each(function () {
            if ($(this).is(" :checked")) {
                checked.push($(this).attr('field-id'));
            }
        });
        $.ajax({
            url: 'scripts/php/journals/delete.php', method: 'POST', data: { 'checked': checked }, success: function (response) {
                response = jQuery.parseJSON(response);
                $.growl(response);
                if (!response.error) {
                    setTimeout(function () {
                        window.location.reload(true);
                    }, 2000);
                }
            }, error: function () {
                $.growl({ title: "Internal Error!", message: 'Unable to perform a ajax request', style: 'error', location: 'tc' });
            }
        });
    });

    btnBooksAdd.on('click', function (evt) {

        formBooksAdd.ajaxSubmit({
            success: function (response) {

                response = jQuery.parseJSON(response);
                $.growl(response);
            }
        });
    });

    btnAdminsChangePassword.on('click', function (evt) {
        formAdminsChangePassword.ajaxSubmit({
            success: function (response) {
                response = jQuery.parseJSON(response);
                $.growl(response);
            },
            error: function () {
                $.growl(ajaxError);
            }
        });
    });

    btnJournalsAdd.on('click', function (evt) {
        formJournalsAdd.ajaxSubmit({
            success: function (response) {
                response = jQuery.parseJSON(response);
                $.growl(response);
            }
        });
    });

    btnJournalsUpdate.on('click', function (evt) {
        formJournalsUpdate.ajaxSubmit({
            data: { 'id': selectedJournal },
            success: function (response) {
                response = jQuery.parseJSON(response);
                $.growl(response);
            },
            error: function (error) {
                $.growl(ajaxError);
            }
        });
    });

});