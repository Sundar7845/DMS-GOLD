var FromDate;
var ToDate;
var date = new Date();
var startdate;
var enddate;
var dtCustomer;
var baseurl = window.location.origin;

$(document).ready(function () {
    FromDate = moment();
    ToDate = moment();

    $("#reportrange").daterangepicker(
        {
            autoUpdateInput: false,
            showCustomRangeLabel: false, // ❌ remove custom option
            alwaysShowCalendars: false, // ❌ hide calendar
            opens: "left",
            ranges: {
                Today: [moment(), moment()],
                Yesterday: [
                    moment().subtract("days", 1),
                    moment().subtract("days", 1),
                ],
                "Last 7 Days": [moment().subtract("days", 6), moment()],
                // "Last 30 Days": [moment().subtract("days", 29), moment()],
                // "This Month": [
                //     moment().startOf("month"),
                //     moment().endOf("month"),
                // ],
                // "Last Month": [
                //     moment().subtract("month", 1).startOf("month"),
                //     moment().subtract("month", 1).endOf("month"),
                // ],
            },
            FromDate: moment(),
            ToDate: moment(),
        },
        getDate,
    );

    getDate(FromDate, ToDate);

    //dealer list
    customerList();
    customerLogList();
});

function getDate(start, end) {
    startdate = start.format("YYYY-MM-DD");
    enddate = end.format("YYYY-MM-DD");
    if (dtCustomer) {
        dtCustomerLog.draw();
    }
    $("#reportrange span").html(
        start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY"),
    );
}
$("#user_filter,#from_date,#to_date").change(function () {
    dtCustomerLog.draw();
});
function customerList() {
    dtCustomer = $("#customers-table").DataTable({
        processing: true,
        serverSide: true,
        // responsive: true,
        order: [[4, "ASC"]],
        bDestroy: true,
        ajax: {
            url: "customerdata",
        },
        fnRowCallback: serialNoCount,
        columns: [
            {
                data: null,
            },
            {
                data: "name",
            },
            {
                data: "mobile",
            },
            {
                data: "zone",
            },
            {
                data: "login_at",
            },
        ],
    });
}

function customerLogList() {
    dtCustomerLog = $("#customerslog-table").DataTable({
        processing: true,
        serverSide: true,
        order: [[4, "desc"]],
        bDestroy: true,
        ajax: {
            url: "customerlogdata",
            data: function (d) {
                d.user_id = $("#user_filter").val(); // user filter
                d.from_date = startdate;
                d.to_date = enddate;
            },
        },
        columns: [
            { data: "id" },
            { data: "name" },
            { data: "mobile" },
            { data: "zone" },
            { data: "login_at" },
            { data: "logout_at" },
        ],
    });
}
