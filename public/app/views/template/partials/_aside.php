<aside class="w-full md:w-1/4 p-3">
    <div class="bg-yellow-500 text-white rounded-lg shadow-md p-4 mb-4">
        <h2 class="font-bold text-lg mb-4">Catégories</h2>
        <ul class="list-reset text-gray-100">
            <?php include_once '../app/views/categories/_listCategories.php'; ?>
        </ul>
    </div>
    <div class="bg-yellow-600 text-white rounded-lg shadow-md p-4">
        <h2 class="font-bold text-lg mb-4">Ingrédients</h2>
        <ul class="list-reset text-gray-200">
            <?php include_once '../app/views/ingredients/_listIngredients.php'; ?>
        </ul>
    </div>
</aside>