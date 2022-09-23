<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta name="description" content="technical-documentation">
    <title>Easybazar Documentation</title>
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.min.css')}}">
<style>
div.grid-container {
  display: grid;
  grid-template-columns: 200px 1fr;
  grid-template-areas: "navbar content";
  grid-gap: 40px;
}
nav#navbar {
  grid-area: navbar;
  position: fixed;
}
nav#navbar a {
  display: block;
  border: 1px solid black;
  padding: 5px;
  margin: 10px 0;
  text-decoration: none;
  background-color: AntiqueWhite;
  color: black;
  border-radius: 20px;
  text-align: center;
}
nav#navbar a:hover {
  color: blue;
}
main#main-doc {
  grid-area: content;
  padding-right: 50px;
}
nav header {
  font-size: 1.1em;
}
main header {
  font-size: 2.5em;
  margin-top: 40px;
  margin-bottom: 40px;
}

main p {
  padding-left: 20px;
}

code {
  background-color: #eaeaea;
  display: block;
  text-align: left;
  white-space: pre;
  padding: 15px;
  margin-left: 20px;
  margin-top: 30px;
  margin-bottom: 30px;
}
@media only screen and (max-width: 680px) {
  div.grid-container {
    grid-template-columns: 1fr;
    grid-template-areas: "navbar" 
                         "content";
  }
  nav#navbar {
    width: 96.5%;
    position: absolute;
  }
  nav#navbar header {
    text-align: center;
  }
  main#main-doc {
    position: relative;
    margin-top: 200px;
  }
}
@media only screen and (max-width: 460px) {
  main#main-doc {
    width: 75%;
  }
  code {
    word-break: break-word;
  }
}
</style>
</head>
<body>
<?php
$roles              = userRolePermissionArray();
$tab_index          = 1;
$row = $row ?? [];
?>
<section id="basic-form-layouts">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card card-success min-height">
                <div class="card-content collapse show">
                    <div class="card-body">
                        {!!$row->DESCRIPTION!!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="{{asset('assets/vendors/js/vendors.js')}}"></script>
<script>
</script>
</body>
</html>
