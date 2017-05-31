$(document).ready(function () {
    var doTable = function (response) {
        var bodyTable = $('.tableSkills').find('tbody');
        var html = '';

        for (var i in response) {

            html += '<tr>';
            html += '<td><input type="checkbox" id="skill-' + response[i].id + '" /></td>';
            html += '<td>' + response[i].id + '</td>';
            html += '<td>' + response[i].name + '</td>';
            html += '<td>' + response[i].type + '</td>';
            html += '</tr>';
        }

        bodyTable.html(html);
    };

    var getSkills = function () {
        var url = webroot + 'admin/skills/get-skills';

        $.post(url, function (e) {
            if (e.result.status == 'success') {
                doTable(e.result.data);
            }
        }, 'json');
    };

    var filterSkills = function (likeName) {
        var url = webroot + 'admin/skills/filter-skills';
        var data = {
            likeName: likeName
        };

        $.post(url, data, function (e) {
            if (e.result.status == 'success') {
                doTable(e.result.data);
            }
        }, 'json');
    };

    $('.input-search-skills').on('keyup', function (e) {
        if (e.keyCode === 13) {
            filterSkills($(this).val());
        }
    });

    getSkills();
});