<?php
require_once "./controllers/book_controller.php";
require_once "./controllers/author_controller.php";
?>
<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Add Book</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-100 text-gray-900">
  <div class="max-w-5xl mx-auto p-6 space-y-6 ">
    <div class="bg-gray-50 rounded-xl shadow p-2 flex text-xl font-semibold">
      <button class="rounded-xl p-3 cursor-pointer">
        <a href="/books.php">&larr; Back</a>
      </button>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
      <h2 class="text-lg font-medium mb-4">Add Book</h2>
      <form action="/controllers/book_controller.php" method="POST" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm mb-1 text-gray-600 font-semibold">Title</label>
            <div class="flex gap-2 justify-center items-center">
              <input type="text" class="flex-1 border rounded-md px-3 py-2 text-sm bg-gray-50" name="title" required>
            </div>
          </div>
          <div>
            <label class="block text-sm mb-1 text-gray-600 font-semibold">Publication Year</label>
            <div class="flex gap-2 justify-center items-center">
              <input type="number" class="flex-1 border rounded-md px-3 py-2 text-sm bg-gray-50" min="0" step="1" name="publication_year" required>
            </div>
          </div>
          <div>
            <label class="block text-sm mb-1 text-gray-600 font-semibold">Page Count</label>
            <div class="flex gap-2 justify-center items-center">
              <input type="number" class="flex-1 border rounded-md px-3 py-2 text-sm bg-gray-50" min="0" step="1" name="page_count" required>
            </div>
          </div>
          <div>
            <label class="block text-sm mb-1 text-gray-600 font-semibold">ISBN Number</label>
            <div class="flex gap-2 justify-center items-center">
              <input type="text" class="flex-1 border rounded-md px-3 py-2 text-sm bg-gray-50" name="isbn_number" required>
            </div>
          </div>
          <div>
            <label class="block text-sm mb-1 text-gray-600 font-semibold">Author</label>
            <select class="w-full border rounded-md px-3 py-2 text-sm bg-gray-50" name="author_id">
              <?php foreach (AuthorController::getNames() as $author): ?>
                <option value="<?= htmlspecialchars($author->id) ?>">
                  <?= htmlspecialchars($author->full_name) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div>
          <label class="block text-sm mb-1 text-gray-600 font-semibold">Summary Text</label>
          <textarea name="summary_text" class="w-full border rounded-md p-3 text-sm bg-gray-50" required></textarea>
        </div>

        <button type="submit" name="button_add_book"
          class="bg-indigo-300 w-full text-white text-sm font-medium px-4 py-2 rounded-md">
          Submit
        </button>
      </form>
    </div>
  </div>
</body>
<script>
  $('input[name="publication_year"]').attr("max", new Date().getFullYear());
</script>
</html>