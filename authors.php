<?php
require_once "./controllers/author_controller.php";

$non_empty_author_ids = AuthorController::getNonEmptyAuthors();
?>
<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Authors</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-100 text-gray-900">
  <div class="max-w-5xl mx-auto p-6 space-y-6 ">
    <div class="bg-gray-50 rounded-xl shadow p-2 flex text-xl font-semibold">
      <a class="flex-1 rounded-xl p-3 cursor-pointer no-underline text-center" href="/books.php">Books</a>
      <a class="flex-1 rounded-xl p-3 bg-indigo-300 text-white cursor-pointer no-underline text-center" href="/authors.php">Authors</a>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
      <h1 class="text-xl font-semibold mb-4">Authors</h1>

      <div class="overflow-x-auto max-w-full">
        <table class="w-full table-auto text-sm border-collapse">
          <thead>
            <tr class="bg-gray-50 text-left text-xs text-gray-500">
              <th class="px-3 py-2 border">No.</th>
              <th class="px-3 py-2 border">Full Name</th>
              <th class="px-3 py-2 border">Birth Date</th>
              <th class="px-3 py-2 border">Biography Summary</th>
              <th class="px-3 py-2 border"></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach (AuthorController::getAll() as $index => $author): ?>
              <tr>
                <td class="px-3 py-2 border"><?= $index + 1 ?></td>
                <td class="px-3 py-2 border"><?= htmlspecialchars($author->getFullName()) ?></td>
                <td class="px-3 py-2 border"><?= htmlspecialchars($author->getBirthDate()) ?></td>
                <td class="px-3 py-2 border"><?= htmlspecialchars($author->getBiographySummary()) ?></td>
                <td class="px-3 py-2 border">
                  <div class="flex gap-1">
                    <a href="/edit_author.php?id=<?= htmlspecialchars($author->getId()) ?>">
                      <button name="button_edit" class="bg-indigo-300 py-2 px-3 text-white text-sm rounded-md font-semibold">
                        Edit
                      </button>
                    </a>
                    <form method="POST" action="/controllers/author_controller.php">
                      <input type="hidden" value="<?= htmlspecialchars($author->getId()) ?>" name="author_id">
                      <button type="submit" name="button_delete_author" class="bg-red-300 py-2 px-3 text-white text-sm rounded-md font-semibold">
                        Delete
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>

    <a href="/add_author.php">
      <button class="w-full rounded-xl p-2 bg-indigo-300 text-xs sm:text-sm font-semibold text-white cursor-pointer">
        Add Author
      </button>
    </a>
  </div>
</body>
<script>
  const nonEmptyAuthors = new Set([<?= implode(',', $non_empty_author_ids) ?>]);

  $('form').on('submit', function(e) {
    let fd = new FormData(this);

    if (nonEmptyAuthors.has(parseInt(fd.get('author_id')))) {
      e.preventDefault();
      alert("Please remove all books by this author before deleting them.");
      return;
    }

    if (!confirm("Are you sure you want to delete this data?")) {
      e.preventDefault();
    }
  });
</script>

</html>