$(document).ready(function () {
    $('#example').DataTable({
        processing: true,
        ajax: {
            url:'./Inventory.php',
            type:'POST',
            datatype: 'json',

        },
        columns: [
            {
                'render': function(data, type, row, meta){
                    return '<span class="input-group-btn"><div class="dropdown">'
                        +'<button type="button" class="btn btn-dark c-btn-square" data-toggle="dropdown">'
                        +'<i class="glyphicon glyphicon-tasks"></i>'
                        +'<span class="caret"></span>'
                        +'</button>'
                        +'<ul class="dropdown-menu" role="menu">'
                        +'<li>'
                        +'<a href="javascript:showEditForm(' + row.req_id + ', \'' + row.requested_by + '\', \'' + row.item + '\');">Edit</a>'
                        +'</li>'
                        +'<li class="divider"></li>'
                        +'<li>'
                        +'<a href="Inventory.php?id=' + row.req_id + '" onclick="return confirm(\'Are you sure to delete?\')">Delete</a>'
                        +'</li>'
                        +'</ul>'
                        +'</div></span>';
                }
            },
            { data: 'requested_by' },
            { data: 'item' },
            { data: 'value' },
        ],
    });
});

/*
 Shows the Add form
 */
function showAddForm(id) {
    document.getElementById("addForm").style.display = "block";
    document.getElementById("dbTable").style.display = "none";
}

/*
 Shows the edit form
 */
function showEditForm(id, name, items) {
    document.getElementById("editForm").style.display = "block";
    document.getElementById("addForm").style.display = "none";
    document.getElementById("dbTable").style.display = "none";
    var itemsArr = items.split(',');

    $('#user1').val(name);
    $('#items1').val(itemsArr);
    $('#updateId').val(id);
}

/*
 Shows the Dropdown in Add Form
 */
function addDropDown() {
    document.getElementById('generate').onclick = function() {
        var values = ["Pen", "Printer", "Marker", "Scanner", "Clear Tape", "Standing Table", "Shredder", "Thumbtack", "Paper Clip", "A4 Sheet", "Notebook", "Chair"];
        var select = document.createElement("select");
        select.name = "items[]";
        select.id = "items";
        select.className = "form-control";

        for (const val of values)
        {
            var option = document.createElement("option");
            option.value = val;
            option.text = val.charAt(0).toUpperCase() + val.slice(1);
            select.appendChild(option);
        }

        var label = document.createElement("label");
        label.innerHTML = "Requested Items : "
        label.htmlFor = "items";
        var br = document.createElement("br");

        document.getElementById("container").appendChild(label).appendChild(select);
        document.getElementById("container").appendChild(br);
    }
}

