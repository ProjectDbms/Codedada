<script type="text/javascript">
    var id = "";
    function activate(elementId) {
        if(id != "") {
            document.getElementById(id).classList.remove('active');
            id = elementId;
            document.getElementById(id).classList.add('active');
        } else {
            id = elementId;
            document.getElementById(id).classList.add('active');
        }
    }
</script>

<nav class="navbar navbar-expand-lg navbar-dark bg-success">
    <a class="navbar-brand" href="index.php"><img src="assets/images/programming.png" alt="icon" height="30px" width="30px"> Codedada</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <!-- <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li> -->
            <li class="nav-item" id="nav1">
                <a class="nav-link" href="#" onclick="activate(this.parentElement.id)">Problems</a>
            </li>
            <li class="nav-item" id="nav2">
                <a class="nav-link" href="#" onclick="activate(this.parentElement.id)">Contests</a>
            </li>
            <li class="nav-item" id="nav3">
                <a class="nav-link" href="#" onclick="activate(this.parentElement.id)">Users</a>
            </li>
            <!-- <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Dropdown
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li> 
            <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
            </li> -->
        </ul>

        <ul class="navbar-nav ml-auto" style="margin-right: 5rem;">
            <li class="nav-item dropdown active">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo $_SESSION["username"]; ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Profile</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Logout</a>
                </div>
            </li>
        </ul>

    <!--<form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form> -->
    </div>
</nav>