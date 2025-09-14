<?php
require_once "./controllers/book_controller.php";
?>
<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Books</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-100 text-gray-900">
  <div class="max-w-5xl mx-auto p-6 space-y-6 ">
    <div class="bg-gray-50 rounded-xl shadow p-2 flex text-xl font-semibold">
      <button class="flex-1 rounded-xl p-3 bg-indigo-300 text-white cursor-pointer">
        <a href="/books.php">Books</a>
      </button>
      <button class="flex-1 rounded-xl p-3 cursor-pointer">
        <a href="/authors.php">Authors</a>
      </button>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
      <h1 class="text-xl font-semibold mb-4">Books</h1>

      <div class="overflow-x-auto max-w-full">
        <table class="w-full table-auto text-sm border-collapse">
          <thead>
            <tr class="bg-gray-50 text-left text-xs text-gray-500">
              <th class="px-3 py-2 border">No.</th>
              <th class="px-3 py-2 border">Title</th>
              <th class="px-3 py-2 border">Author</th>
              <th class="px-3 py-2 border">Summary</th>
              <th class="px-3 py-2 border">Publication Year</th>
              <th class="px-3 py-2 border">Page Count</th>
              <th class="px-3 py-2 border"></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach (BookController::getAll() as $index => $b): ?>
              <tr>
                <td class="px-3 py-2 border"><?= $index + 1 ?></td>
                <td class="px-3 py-2 border"><?= htmlspecialchars($b->title) ?></td>
                <td class="px-3 py-2 border"><?= htmlspecialchars($b->author) ?></td>
                <td class="px-3 py-2 border"><?= htmlspecialchars($b->summary_text) ?></td>
                <td class="px-3 py-2 border"><?= htmlspecialchars($b->publication_year) ?></td>
                <td class="px-3 py-2 border"><?= htmlspecialchars($b->page_count) ?></td>
                <td class="px-3 py-2 border">
                  <div class="flex gap-1">
                    <a href="/edit_book.php?id=<?= htmlspecialchars($b->id) ?>">
                      <button name="button_edit" class="bg-indigo-300 py-2 px-3 text-white text-sm rounded-md font-semibold">
                        Edit
                      </button>
                    </a>
                    <form method="POST" action="/controllers/book_controller.php">
                      <input type="hidden" value="<?= htmlspecialchars($b->id) ?>" name="book_id">
                      <button type="submit" name="button_delete_book" class="bg-red-300 py-2 px-3 text-white text-sm rounded-md font-semibold">
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

    <a href="/add_book.php">
      <button class="w-full rounded-xl p-2 bg-indigo-300 text-xs sm:text-sm font-semibold text-white cursor-pointer">
        Add Book
      </button>
    </a>
  </div>
</body>
<script>
  $('form').on('submit', e => {
    if (!confirm("Are you sure you want to delete this data?")) {
      e.preventDefault();
    }
  });
</script>
</html>