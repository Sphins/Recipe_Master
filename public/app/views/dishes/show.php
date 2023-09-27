<section class="bg-white rounded-lg shadow-lg p-6 mb-6">
    <!-- Recipe Image -->
    <img class="w-full h-96 object-cover rounded-t-lg" src="<?php echo $dish['picture']; ?>" alt="<?php echo $dish['dish_name']; ?>" />

    <!-- Recipe Info -->
    <div class="p-4">
        <h1 class="text-3xl font-bold mb-4"><?php echo $dish['dish_name']; ?></h1>
        <div class="flex items-center mb-4">
            <span class="text-yellow-500 mr-1"><i class="fas fa-star"></i></span>
            <span><?php echo number_format($dish['average_rating'], 1); ?></span>
            <span class="ml-4 text-gray-700"><i class="fas fa-clock"></i> <?php echo $dish['prep_time']; ?> minutes</span>
        </div>
        <p class="text-gray-700 mb-4">
            <?php echo $dish['description']; ?>
        </p>
        <div class="flex items-center mb-4">
            <span class="text-gray-700 mr-2">Par <?php echo $dish['user_name']; ?></span>
            <span class="text-gray-500"><i class="fas fa-comment"></i> <?php echo $dish['number_of_comments']; ?> commentaires</span>
        </div>
    </div>

    <!-- Ingredients -->
    <div class="p-4 border-t">
        <h2 class="text-2xl font-bold mb-4">Ingrédients</h2>
        <ul class="list-disc pl-5">
            <?php foreach ($ingredients as $ingredient) : ?>
                <li><?php echo $ingredient['quantity'] . ' ' . $ingredient['unit'] . ' de ' . $ingredient['name']; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Steps -->
    <!-- <div class="p-4 border-t">
        <h2 class="text-2xl font-bold mb-4">Étapes</h2>
        <ol class="list-decimal pl-5">
        </ol>
    </div> -->

    <!-- Comments -->
    <div class="p-4 border-t">
        <h2 class="text-2xl font-bold mb-4">Commentaires</h2>
        <!-- Comment -->
        <?php foreach ($comments as $comment) : ?>
            <div class="mb-4">
                <div class="flex items-center mb-2">
                    <img src="<?php echo IMG_FOLDER . $comment['user_picture']; ?>" alt="<?php echo $comment['user_name']; ?>" class="w-10 h-10 rounded-full mr-2" />
                    <span class="font-bold"><?php echo $comment['user_name']; ?></span>
                </div>
                <p class="text-gray-700">
                    <?php echo $comment['content']; ?>
                </p>
            </div>
        <?php endforeach; ?>
    </div>
</section>