<html>

<head>
    <title>XX Discussion</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/extra-style.css">
    <script src="<?php echo base_url(); ?>assets/js/jquery-3.6.0.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/maintain-scroll.js"></script>
    <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
    <script src="<?php echo base_url(); ?>application/third_party/ckeditor/ckeditor.js"></script>
</head>

<body class="d-flex flex-column min-vh-100" style="padding-top: 100px;">
    <nav class="navbar fixed-top navbar-expand-lg navbar-light mb-4" style="background-color: #c0dffa;">
        <span class="navbar-brand mb-0 h1">XX Discussion</span>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <?php if ($this->session->userdata('logged_in')) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(); ?>home">
                            <ion-icon size="large" name="home-outline"></ion-icon>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(); ?>profile">
                            <ion-icon size="large" name="person-circle-outline"></ion-icon>
                        </a>
                    </li>
                <?php endif; ?>
                </li>
            </ul>
            <ul class="navbar-nav my-lg-0">
                <?php if (!$this->session->userdata('logged_in')) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(); ?>users/login"> Login </a>
                    </li>
                <?php endif; ?>
                <?php if ($this->session->userdata('logged_in')) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(); ?>setting">
                            <ion-icon size="large" name="settings-outline"></ion-icon>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(); ?>users/logout">
                            <ion-icon size="large" name="log-out-outline"></ion-icon>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
        <?php if ($this->session->userdata('logged_in')) : ?>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="text" name="search" id="search_text" placeholder="Search Posts" aria-label="Search">
                <button class="btn btn-outline-primary my-2 my-sm-0" id="searchbtn" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Toggle Result</button>
            </form>
        <?php endif; ?>
    </nav>
    <div class="container fixed-top" style="margin-top: 80px;">
        <div class="collapse" id="collapseExample">
            <div class="card card-body" id="result">
            </div>
        </div>
    </div>

    <?php if ($this->session->userdata('logged_in')) : ?>
        <script>
            $(document).ready(function() {
                load_data();

                function load_data(query) {
                    $.ajax({
                        url: "<?php echo base_url(); ?>ajax/fetch",
                        method: "GET",
                        data: {
                            query: query
                        },
                        success: function(response) {
                            $('#result').html("");
                            if (response == "No Data Found") {
                                $('#result').html(response);
                            } else {
                                var obj = JSON.parse(response);
                                if (obj.length > 0) {
                                    var items = [];
                                    $.each(obj, function(i, val) {
                                        let $titlelink = $("<a href=\"https://infs3202-54d402db.uqcloud.net/zhxia/home/read_post/" + val.id + "\">" + val.title + "</a>");
                                        items.push($titlelink);
                                        items.push($("<div>").text(val.author).css("margin-bottom", "10px"));
                                    });
                                    $('#result').append.apply($('#result'), items);
                                } else {
                                    $('#result').html(response);
                                };
                            };
                        }
                    });
                }
                $('#search_text').keyup(function() {
                    var search = $(this).val();
                    if (search != '') {
                        load_data(search);
                    } else {
                        load_data();
                    }
                });
            });
        </script>
    <?php endif; ?>