<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Buffalo Lab Redqueen</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">

    <!-- Add custom CSS here -->
    <link href="/css/sb-admin.css" rel="stylesheet">
    <link rel="stylesheet" href="/font-awesome/css/font-awesome.min.css">
  </head>

  <body>

    <div id="wrapper">

      <!-- Sidebar -->
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="{{ url.get({ 'for': 'dashboard' }) }}">Redqueen</a>
        </div>

        {% if session.has('token') %}
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse navbar-ex1-collapse">
          <ul class="nav navbar-nav side-nav">
            <li><a href="{{ url.get({ 'for': 'dashboard' }) }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li><a href="{{ url.get({ 'for': 'member_index' }) }}"><i class="fa fa-users"></i> Members</a></li>
            <li><a href="{{ url.get('card/index') }}"><i class="fa fa-credit-card"></i> Cards</a></li>
            <li><a href="{{ url.get({ 'for': 'log_index' }) }}"><i class="fa fa-tasks"></i> Logs</a></li>
          </ul>

          <ul class="nav navbar-nav navbar-right navbar-user">
            <li class="dropdown user-dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> {{ session.token['email'] }} <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="{{ url.get('security/logout') }}"><i class="fa fa-power-off"></i> Log Out</a></li>
              </ul>
            </li>
          </ul>
        </div><!-- /.navbar-collapse -->
        {% endif %}
      </nav>

      <div id="page-wrapper">
        {{ content() }}
      </div><!-- /#page-wrapper -->

    </div><!-- /#wrapper -->

    <!-- JavaScript -->
    <script src="/js/jquery-1.10.2.js"></script>
    <script src="/js/bootstrap.js"></script>

    <!-- Page Specific Plugins -->
    <script src="/js/tablesorter/jquery.tablesorter.js"></script>
    <script src="/js/tablesorter/tables.js"></script>

  </body>
</html>
