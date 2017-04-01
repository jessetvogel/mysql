$(document).ready(function () {
  initialize();
});

function initialize() {
  check_login(function() {
    $.ajax({
      url: 'html/index.html'
    }).done(function (data) {
      $('body').prepend(data);

      load_databases();

      $('#input_database').change(function () {
        $(this).find('option:selected').each(function () {
          load_tables($(this).text());
        });
      });

      $('#logout').click(function () {
        $.ajax({
          url: 'php/logout.php'
        }).done(function () {
          location.reload();
        });
      });
    });
  });
}

function check_login(callback) {
  $.ajax({
    url: 'php/check_login.php'
  }).done(function (data) {
    if(data == "true")
      callback();
    else {
      login(data);
    }
  })
}

function menu_add_item(item, callback) {
  $('#table_list').append($('<li>').append($('<a>').text(item).attr('href', '#').click(function () { $(this).addClass('active'); callback(); })));
}

function login(message) {
  $('body').append($('<div>').attr('id', 'login'));
  $.ajax({
    url: 'html/login.html'
  }).done(function(data) {
    $('#login').css({opacity: 0}).html(data).animate({opacity: 1}, 500);
    $('#login #login_message').html(message);
    $('#login form').submit(function (e) {
      e.preventDefault();
      var host = $('#input_host').val();
      var username = $('#input_username').val();
      var password = $('#input_password').val();
      $.ajax({
        url: 'php/login.php',
        type: 'post',
        data: {
          host: host,
          username: username,
          password: password
        }
      }).done(function (data) {
        if(data == "true") {
          $('#login').animate({opacity: 0}, 500, function() { $(this).remove(); });
          initialize();
        }
        else {
          $('#login_message').html(data);
        }
      });
    });
  });
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
    $('#table_list').html('');
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
