<form method="post" action="php/login.php">
    <section class="vh-100 gradient-custom ">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="card bg-dark text-white" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <div class="mb-md-5 mt-md-5 pb-5">
                            <?php
                            if (isset($_SESSION['melding'])) {
                                echo '<p style = "color:red;">' . $_SESSION['melding'] . '</p>';
                                unset($_SESSION['melding']);
                            }
                            ?>
                            <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
                            <p class="text-white-50 mb-5">Please enter your login and password!</p>
                            <div class="form-outline form-white mb-5">
                                <input type="email" name="email" placeholder="email"
                                       class="form-control form-control-lg" required/>

                            </div>
                            <div class="form-outline form-white mb-5">
                                <input type="password" name="password" placeholder="password"
                                       class="form-control form-control-lg" required/>

                            </div>
                            <button class="btn btn-outline-light btn-lg px-5" type="submit">Login</button>

                            <button class="btn btn-outline-light btn-lg px-5"
                                    onclick="window.location.href='index.php?page=register'" type="submit">sign up
                            </button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</form>