<?php

include_once '../app/models/categoriesModel.php';

use App\Models\CategoriesModel;

$categories = CategoriesModel\findAll($connexion);

foreach ($categories as $category) : ?>
    <li>
        <a class="hover:text-white hover:bg-yellow-600 px-2 block" href=""><?PHP echo $category['name'] ?></a>
    </li>
<?php endforeach; ?>