<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile Upload</title>

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-5">

    <h2 class="mb-4">Profile Upload & Pagination</h2>

    <!-- Success Message -->
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- Error Messages -->
    <?php if(session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">

                <?php foreach(session()->getFlashdata('errors') as $error): ?>

                    <li><?= esc($error) ?></li>

                <?php endforeach; ?>

            </ul>
        </div>
    <?php endif; ?>

    <div class="row">

        <!-- Upload Form -->
        <div class="col-md-4">

            <div class="card shadow-sm p-4">

                <h4>Create Profile</h4>

                <hr>

                <form action="<?= base_url('users/upload') ?>"
                      method="post"
                      enctype="multipart/form-data">

                    <?= csrf_field() ?>

                    <!-- Name -->
                    <div class="mb-3">
                        <label class="form-label">Name</label>

                        <input type="text"
                               name="name"
                               class="form-control"
                               value="<?= old('name') ?>"
                               required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">Email</label>

                        <input type="email"
                               name="email"
                               class="form-control"
                               value="<?= old('email') ?>"
                               required>
                    </div>

                    <!-- Avatar -->
                    <div class="mb-3">
                        <label class="form-label">Avatar</label>

                        <input type="file"
                               name="avatar"
                               class="form-control"
                               required>
                    </div>

                    <button type="submit"
                            class="btn btn-primary w-100">

                        Submit Profile

                    </button>

                </form>

            </div>
        </div>

        <!-- User Table -->
        <div class="col-md-8">

            <div class="card shadow-sm p-4">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <h4>User Directory</h4>

                    <!-- Search -->
                    <form action="<?= base_url('users') ?>"
                          method="get"
                          class="d-flex gap-2">

                        <input type="text"
                               name="search"
                               class="form-control form-control-sm"
                               placeholder="Search users..."
                               value="<?= esc($search ?? '') ?>">

                        <button type="submit"
                                class="btn btn-sm btn-secondary">

                            Search

                        </button>

                    </form>
                </div>

                <!-- Table -->
                <table class="table table-striped table-hover align-middle">

    <thead class="table-dark">

        <tr>

            <th>Avatar</th>

            <th>Name</th>

            <th>Email</th>

            <th>Action</th>

        </tr>

    </thead>

    <tbody>

    <?php if(!empty($users)): ?>

        <?php foreach($users as $user): ?>

            <tr>

                <!-- AVATAR -->
                <td>

                    <?php if(!empty($user['avatar'])): ?>

                        <img src="<?= base_url($user['avatar']) ?>"
                             class="rounded-circle"
                             style="width:50px;height:50px;object-fit:cover;">

                    <?php else: ?>

                        No Image

                    <?php endif; ?>

                </td>

                <!-- NAME -->
                <td>

                    <?= esc($user['name']) ?>

                </td>

                <!-- EMAIL -->
                <td>

                    <?= esc($user['email']) ?>

                </td>

                <!-- DELETE BUTTON -->
                <td>

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

                <!-- Pagination -->
                <div class="mt-3">

                    <?= $pager->links() ?>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>