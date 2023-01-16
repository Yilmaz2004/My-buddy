<section class="vh-100 gradient-custom">
    <div class="container py-5 h-100">
        <div class="">
            <div class="card bg-dark text-white" style="border-radius: 1rem;">
                <div class="card-body p-5 text-center">
                    <div class="mb-md-5 mt-md-5 pb-5">

                        <div class="container mt-3">
                            <h2>groep toevoegen</h2>
                            <form action="php/group_insert.php" method="POST" enctype="multipart/form-data">
                                <div class="mb-3 mt-3">
                                    <label>Naam:</label>
                                    <input type="text" class="form-control" placeholder="Enter name" name="name"
                                           required>
                                </div>
                                <div class="mb-3 mt-3">
                                    <label>beschrijving:</label>
                                    <input type="text" class="form-control" placeholder="Enter description"
                                           name="description" required>
                                </div>
                                <div class="mb-3 mt-3">
                                    <label>afbeelding:</label>
                                    <input type="file" class="form-control" placeholder="Enter picture" name="picture"
                                           required>
                                </div>
                                <button name="submit" type="submit" class="btn btn-success">Toevoegen</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>