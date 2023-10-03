<?php

include_once '../core/tools.php';

use Core\Tools;

foreach ($users as $user) : ?>
    <article class="bg-white rounded-lg overflow-hidden shadow-lg relative">
        <img class="w-full h-48 object-cover" src="<?php echo IMG_FOLDER . $user['user_picture']; ?>" alt="User Profile Image" />
        <div class="p-4">
            <h3 class="text-xl font-bold mb-2"><?php echo $user['user_name']; ?></h3>

            <!-- Date d'inscription de l'utilisateur -->
            <div class="flex items-center mb-2">
                <span class="text-gray-500 mr-1"><i class="fas fa-calendar-alt"></i></span>
                <span>Inscrit le : <?php echo $user['user_registration_date']; ?></span>
            </div>

            <!-- Description ou bio de l'utilisateur -->
            <p class="text-gray-600"><?php echo Tools\truncate($user['user_biography'], 10); ?></p>

            <!-- Nombre total de recettes publiées par l'utilisateur -->
            <div class="flex items-center mt-4">
                <span class="text-gray-700 mr-2"><i class="fas fa-utensils"></i> <?php echo $user['total_recipes']; ?> recettes publiées</span>
            </div>

            <!-- Lien vers le profil de l'utilisateur ou ses recettes -->
            <a href="chefs/show/<?php echo $user['user_id']; ?>/<?php echo Core\Tools\slugify($user['user_name']) ?>" class="inline-block mt-4 bg-blue-500 hover:bg-blue-800 rounded-full px-4 py-2 text-white">
                Voir le profil
            </a>
        </div>
    </article>
<?php endforeach; ?>