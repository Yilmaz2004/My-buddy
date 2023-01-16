<link rel="stylesheet" type="text/css" href="../css/style.css">
<body>
<form method="post" action="php/register.php">
    <section class="vh-100 gradient-custom">
        <div class="container  h-100">
            <div class=" h-100">
                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                    <div class="card-body  text-center">
                        <div class="mb-md-5 ">
                            <h2 class="fw-bold mb-1 text-uppercase">register</h2>
                            <p class="text-white-50 mb-4">Please sign up!</p>
                            <div class="form-outline form-white mb-5">
                                <th> firstname</th>
                                <input type="text" name="firstname" placeholder="firstname"
                                       class="form-control form-control-lg" required/>
                            </div>
                            <div class="form-outline form-white mb-5">
                                <th> insertion</th>
                                <input type="text" name="insertion" placeholder="insertion"
                                       class="form-control form-control-lg"/>

                            </div>
                            <div class="form-outline form-white mb-5">
                                <th> lastname</th>
                                <input type="text" name="lastname" placeholder="lastname"
                                       class="form-control form-control-lg" required/>

                            </div>
                            <div class="form-outline form-white mb-5">
                                <th> email</th>
                                <input type="email" name="email" placeholder="email"
                                       class="form-control form-control-lg" required/>
                            </div>
                            <?php
                            if (isset($_SESSION['melding'])) {
                                echo '<p style = "color:red;">' . $_SESSION['melding'] . '</p>';
                                unset($_SESSION['melding']);
                            }
                            ?>

                            <div class="form-outline form-white mb-5">
                                <th> password</th>
                                <input type="password" name="password" placeholder="password"
                                       class="form-control form-control-lg" required/>
                            </div>
                            <div class="form-outline form-white mb-5">
                                <th> repeat password</th>
                                <input type="password" name="passwordrepeat" placeholder="password"
                                       class="form-control form-control-lg" required/>
                            </div>

                            <button class="btn btn-outline-light btn-lg px-5"
                                  type="submit">sign up
                            </button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>
