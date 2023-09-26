 <!-- Hero Recipe Card -->

 <?php

    include_once '../core/tools.php';

    use Core\Tools;
    ?>

 <section class="relative mb-6">
     <img class="w-full h-96 object-cover" src="https://source.unsplash.com/1600x900/?recipe" alt="Featured Recipe Image" />
     <div class="absolute bottom-0 left-0 w-full p-6 bg-gradient-to-t from-gray-900 to-transparent">
         <h1 class="text-3xl font-bold mb-2 text-white">
             <?php echo $rand['dish_name'] ?>
         </h1>
         <div class="flex items-center mb-4">
             <span class="text-yellow-500 mr-1"><i class="fas fa-star"></i></span>
             <span class="text-white"><?php echo number_format($rand['average_rating'], 1); ?></span>
         </div>
         <p class="text-gray-300 mb-4">
             <?php echo Tools\limit_words($rand['description'], 45); ?>
         </p>
         <div class="flex items-center mb-4">
             <span class="text-gray-400 mr-2">Par <?php echo $rand['user_name']; ?></span>
             <span class="text-gray-500"><i class="fas fa-comment"></i> <?php echo $rand['number_of_comments']; ?> commentaires</span>
         </div>
         <a href="recipe.html" class="inline-block bg-red-500 hover:bg-red-800 rounded-full px-4 py-2 text-white">
             Voir la recette
         </a>
     </div>
 </section>