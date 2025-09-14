<?php
require_once "./controllers/author_controller.php";

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
  $author = AuthorController::get((int) $_GET['id']);

  if (is_null($author)) {
    return header("Location: /authors.php");
  }
}
?>
<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Edit Author</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
</head>

<body class="bg-gray-100 text-gray-900">
  <div class="max-w-5xl mx-auto p-6 space-y-6 ">
    <div class="bg-gray-50 rounded-xl shadow p-2 flex text-xl font-semibold">
      <button class="rounded-xl p-3 cursor-pointer">
        <a href="/authors.php">&larr; Back</a>
      </button>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
      <h2 class="text-lg font-medium mb-4">Edit Author</h2>
      <form action="/controllers/author_controller.php" method="POST" class="space-y-4">
        <input type="hidden" name="id" value="<?= $author->id ?>">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm mb-1 text-gray-600 font-semibold">Full Name</label>
            <div class="flex gap-2 justify-center items-center">
              <input type="text" class="flex-1 border rounded-md px-3 py-2 text-sm bg-gray-50" name="full_name" required value="<?= $author->full_name ?>">
            </div>
          </div>
          <div>
            <label class="block text-sm mb-1 text-gray-600 font-semibold">Birth Date</label>
            <div class="flex gap-2 justify-center items-center">
              <input type="date" class="flex-1 border rounded-md px-3 py-2 text-sm bg-gray-50" name="birth_date" required value="<?= $author->birth_date ?>">
            </div>
          </div>
        </div>

        <div>
          <label class="block text-sm mb-1 text-gray-600 font-semibold">Biography Summary</label>
          <textarea name="biography_summary" class="w-full border rounded-md p-3 text-sm bg-gray-50" required><?= $author->biography_summary ?></textarea>
        </div>

        <button type="submit" name="button_edit_author"
          class="bg-indigo-300 w-full text-white text-sm font-medium px-4 py-2 rounded-md">
          Submit
        </button>
      </form>
    </div>
  </div>
</body>
<script>
  $('input[type=date]').attr("max", new Date().toISOString().split("T")[0]);
</script>
</html>