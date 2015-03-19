<html>
<head>
    <title>Banco Alimentario</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.95.3/css/materialize.min.css">
    <!-- Compiled and minified JavaScript -->
    <script type="text/javascript" src ="https://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.95.3/js/materialize.min.js"></script>
    </head>
    <body>
    <style>
    .contenedor {
        width:85%;
        margin-left:10px;
        margin-right:10px;
    }
    table {
        border:1px solid black;
        width:80%;
        padding:2%;
        margin:2%;
        max-width:50%    
    }
    table {
        border-collapse: collapse;
    }

    table, td, th {
        border: 1px solid black;
    }

    </style>
    <div class="contenedor">
        <?php echo $html ?>
    </div>
    <?php echo date('d/m/Y') ?>
    </body>
    <script>
    $(document).ready(function(){
        $('table').addClass('bordered')
    })
    </script>
</html>

