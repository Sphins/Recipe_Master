<section class="bg-gray-700 text-white rounded-lg shadow-2xl p-6 my-6">
    <!-- User Info -->
    <div class="flex items-center mb-6">
        <!-- User Avatar -->
        <img src="https://source.unsplash.com/300x300/?portrait" alt="Nom de l'utilisateur" class="w-24 h-24 rounded-full border-4 border-yellow-500 mr-4" />

        <!-- User Details -->
        <div>
            <h3 class="text-2xl font-bold">Nom de l'utilisateur</h3>
            <p class="text-gray-400">Membre depuis: Date d'inscription</p>
            <p class="text-gray-400">Nombre de recettes postées: 10</p>
        </div>
    </div>

    <!-- User Actions -->
    <div class="flex justify-between items-center mb-4">
        <a href="user_recipes.html" class="bg-yellow-500 hover:bg-yellow-600 text-gray-900 rounded-full px-6 py-2">Voir mes recettes</a>
    </div>

    <!-- User's Latest Recipes -->
    <div>
        <h4 class="text-xl font-bold mb-4 border-b-2 border-yellow-500 pb-2">
            Mes dernières recettes
        </h4>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Recipe Card (Repeat for each recipe) -->
            <article class="bg-gray-800 rounded-lg overflow-hidden shadow-lg relative">
                <img src="https://source.unsplash.com/480x360/?recipe" alt="Recipe Name" class="w-full h-48 object-cover" />
                <div class="p-4">
                    <h5 class="text-lg font-bold mb-2">Nom de la recette</h5>
                    <div class="flex items-center mb-2">
                        <span class="text-yellow-500 mr-1"><i class="fas fa-star"></i></span>
                        <span>4.5</span>
                    </div>
                    <p class="text-gray-500">
                        Description courte de la recette...
                    </p>
                    <a href="recipe_detail.html" class="text-yellow-500 hover:text-yellow-600 mt-2 inline-block">Voir la recette</a>
                </div>
            </article>
            <!-- ... (autres cartes de recettes) ... -->
            <!-- Recipe Card (Repeat for each recipe) -->
            <article class="bg-gray-800 rounded-lg overflow-hidden shadow-lg relative">
                <img src="https://source.unsplash.com/480x360/?recipe" alt="Recipe Name" class="w-full h-48 object-cover" />
                <div class="p-4">
                    <h5 class="text-lg font-bold mb-2">Nom de la recette</h5>
                    <div class="flex items-center mb-2">
                        <span class="text-yellow-500 mr-1"><i class="fas fa-star"></i></span>
                        <span>4.5</span>
                    </div>
                    <p class="text-gray-500">
                        Description courte de la recette...
                    </p>
                    <a href="recipe_detail.html" class="text-yellow-500 hover:text-yellow-600 mt-2 inline-block">Voir la recette</a>
                </div>
            </article>
        </div>
    </div>
</section>