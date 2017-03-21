<html>
  <head>
    <title>Worksheet Generator</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>

  <body>
    <!-- BEGIN FORM -->
    <div class="container">
      <h1 class="page-header">Word Problem Worksheet Generator</h1>
      <form action="generate_worksheet.php" method="post">
        <div class="form-group">
          <label for="worksheet_title">Worksheet Title</label>
          <input class="form-control" type="text" id="worksheet_title" name="worksheet_title" required>
        </div>

        <div class="checkbox">
          <label>
            <input type="checkbox" name="randomize"> Randomize problem order
          </label>
        </div>

        <hr>
        <div id="problem_set_container"></div>
        <button id="add_problem_set" class="btn btn-default">Add Problem Set</button>
        <hr>

        <input class="btn btn-primary" type="submit" value="Generate">
      </form>
    </div>
    <!-- END FORM -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.4/lodash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <!-- BEGIN INPUT TEMPLATING -->
    <script type="text/template" id="problem_set_template">
      <div class="panel panel-default">
        <div class="panel-body">

          <div class="col-sm-4">
            <div class="form-group">
              <label>Type</label>
              <select name="problem_set[<%= id %>][type]" class="form-control">
                <option value="addition">Addition</option>
                <option value="subtraction">Subtraction</option>
                <option value="multiplication">Multiplication</option>
              </select>
            </div>
          </div>

          <div class="col-sm-4">
            <div class="form-group">
              <label>Number of Problems</label>
              <input type="number" class="form-control" name="problem_set[<%= id %>][num_problems]" value="5" min="1" step="1">
            </div>
          </div>


          <div class="col-sm-4">
            <div class="form-group">
              <label>Operand Digits</label>
              <div class="input-group">
                <input type="number" class="form-control" name="problem_set[<%= id %>][oper_1_digits]" value="2" min="1" max="5" step="1">
                <span class="input-group-addon" id="basic-addon1">by</span>
                <input type="number" class="form-control" name="problem_set[<%= id %>][oper_2_digits]" value="3" min="1" max="5" step="1">
              </div>
            </div>
          </div>
        </div>

        <div class="panel-footer text-right">
          <% if (id > 0) { %>
            <button class="remove_problem_set btn btn-danger btn-xs">Remove</button>
          <% } %>
        </div>
      </div>
    </script>
    <!-- END INPUT TEMPLATING -->

    <script>
      (function($) {
        var count = 0;

        $(document).ready(function() {
          var $problemTypeTemplate = $('#problem_set_template'),
              compiledTemplate = _.template($problemTypeTemplate.text()),
              $problemTypeButton = $('#add_problem_set');

          addInput(compiledTemplate);

          $problemTypeButton.on('click', function(e) {
            e.preventDefault();
            addInput(compiledTemplate);
          });

          $('body').on('click', '.remove_problem_set', function(e) {
            e.preventDefault();
            $(this).parents('.panel.panel-default').remove();
          });
        });

        function addInput(template) {
          var $problemTypeContainer = $('#problem_set_container');
          $problemTypeContainer.append(template({"id": count}));
          count++;
        }
      }(jQuery));
    </script>
  </body>
</html>
