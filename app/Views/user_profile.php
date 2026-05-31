<body>

<div class="container py-4">

    <h2 class="mb-4 text-center">User Profiles</h2>

    <div class="row">

        <!-- FORM -->
        <div class="col-md-4 mb-4">

            <h5 class="mb-3">Add User</h5>

            <form action="<?= base_url('users/upload') ?>"
                  method="post"
                  enctype="multipart/form-data">

                <?= csrf_field() ?>

                <div class="mb-3">
                    <input type="text"
                           name="name"
                           class="form-control"
                           placeholder="Name"
                           required>
                </div>

                <div class="mb-3">
                    <input type="email"
                           name="email"
                           class="form-control"
                           placeholder="Email"
                           required>
                </div>

                <div class="mb-3">
                    <input type="file"
                           name="avatar"
                           class="form-control"
                           required>
                </div>

                <button type="submit"
                        class="btn btn-primary w-100">
                    Save
                </button>

            </form>

        </div>

        <!-- USERS -->
        <div class="col-md-8">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h5 class="mb-0">Users</h5>

                <form method="get" class="d-flex gap-2">

                    <input type="text"
                           name="search"
                           class="form-control form-control-sm"
                           placeholder="Search">

                    <button type="submit"
                            class="btn btn-outline-secondary btn-sm">
                        Search
                    </button>

                </form>

            </div>

            <table class="table table-bordered align-middle">

                <thead>
                    <tr>
                        <th width="80">Avatar</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th width="100" class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if(!empty($users)): ?>

                        <?php foreach($users as $user): ?>

                            <tr>

                                <td>

                                    <?php if(!empty($user['avatar'])): ?>

                                        <img src="<?= base_url($user['avatar']) ?>"
                                             width="50"
                                             height="50"
                                             class="rounded-circle">

                                    <?php else: ?>

                                        No Image

                                    <?php endif; ?>

                                </td>

                                <td>
                                    <?= esc($user['name']) ?>
                                </td>

                                <td>
                                    <?= esc($user['email']) ?>
                                </td>

                                <td class="text-center">

                                    <a href="<?= base_url('users/delete/' . $user['id']) ?>"
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Delete this user?')">

                                        Delete

                                    </a>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="4" class="text-center">
                                No users found.
                            </td>
                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

            <div class="d-flex justify-content-center">
                <?= $pager->links() ?>
            </div>

        </div>

    </div>

</div>

</body>