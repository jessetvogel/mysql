$(document).ready(function () {

  load_databases();

  $('#input_database').change(function () {
    $(this).find('option:selected').each(function () {
      load_tables($(this).text());
    });
  });

});

function menu_add_item(item, callback) {
  $('#menu').append($('<li>').append($('<a>').text(item).attr('href', '#').click(function () { $(this).addClass('active'); callback(); })));
}



function load_databases() {
  $.ajax({
    url: 'php/databases.php'
  }).done(function(data) {
    var databases = JSON.parse(data);
    $('#input_database').html('<option></option>');
    for(var i = 0;i < databases.length;i ++) {
      $('#input_database').append($('<option>').text(databases[i]));
    }
  });
}

function load_tables(database) {
  $.ajax({
    url: 'php/tables.php?database=' + database
  }).done(function(json) {
    var data = JSON.parse(json);
    $('#menu').html('');
    for(var i = 0;i < data.length;i ++) {
      (function(table) {
        menu_add_item(table, function () { load_table(database, table); });
      })(data[i]);
    }
  });
}

function load_table(database, table) {
  $.ajax({
    url: 'php/table.php?database=' + database + '&table=' + table
  }).done(function(json) {
    var data = JSON.parse(json);
    var t = $('<table>').addClass('table').addClass('table-striped');
    var thead = $('<thead>');
    var tr = $('<tr>');
    for(var i = 0;i < data['fields'].length;i ++)
      tr.append($('<th>').text(data['fields'][i]['Field']));
    thead.append(tr);
    t.append(thead);
    if(data['data'] != undefined) {
      var tbody = $('<tbody>');
      for(var i = 0;i < data['data'].length;i ++) {
        var tr = $('<tr>');
        for(var field in data['data'][i])
          tr.append($('<td>').text(data['data'][i][field]));
          tbody.append(tr);
      }
      t.append(tbody);
    }
    $('#content')
      .html('')
      .append($('<h1>').text(table))
      .append(t);
  });
}
