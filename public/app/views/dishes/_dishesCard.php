<?php

include_once '../core/tools.php';

use Core\Tools;

foreach ($dishes as $dish) : ?>
    <article class="bg-white rounded-lg overflow-hidden shadow-lg relative">
        <img class="w-full h-48 object-cover" src="https://source.unsplash.com/480x360/?recipe" alt="Recipe Image" />
        <div class="p-4">
            <h3 class="text-xl font-bold mb-2"><?php echo $dish['dish_name']; ?></h3>
            <div class="flex items-center mb-2">
                <span class="text-yellow-500 mr-1"><i class="fas fa-star"></i></span>
                <span><?php echo number_format($dish['average_rating'], 1); ?></span>
            </div>
            <p class="text-gray-600"><?php echo Tools\truncate($dish['description'], 75); ?></p>
            <div class="flex items-center mt-4">
                <span class="text-gray-700 mr-2">Par <?php echo $dish['user_name']; ?></span>
                <span class="text-gray-500"><i class="fas fa-comment"></i> <?php echo $dish['number_of_comments']; ?> commentaires</span>
            </div>
            <a href="recettes/show/<?php echo $dish['dish_id']; ?>/<?php echo Core\Tools\slugify($dish['dish_name']) ?>" class="inline-block mt-4 bg-red-500 hover:bg-red-800 rounded-full px-4 py-2 text-white">
                Voir la recette
            </a>
        </div>
    </article>
<?php endforeach; ?>