<?php

include_once '../app/models/ingredientsModel.php';

use App\Models\IngredientsModel;

$ingredients = IngredientsModel\findAll($connexion);

foreach ($ingredients as $ingredient) : ?>
    <li>
        <a class="hover:text-white hover:bg-yellow-700 px-2 block" href="ingredients/<?php echo $ingredient['id']; ?>"><?php echo $ingredient['name']; ?></a>
    </li>
<?php endforeach; ?>