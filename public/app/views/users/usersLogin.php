<div class="bg-gray-800 rounded-lg shadow-lg p-6 mb-6">
    <h2 class="text-xl font-bold mb-4 text-yellow-500">Login des users</h2>
    <form action="users/submit" method="post" class="space-y-4">
        <div>
            <label for="pseudo" class="block text-sm font-medium text-gray-400">Pseudo :</label>
            <input type="text" id="pseudo" name="pseudo" required class="mt-1 p-2 w-full rounded-md bg-gray-700 text-white border border-gray-600 focus:border-yellow-500 focus:ring focus:ring-yellow-200 focus:ring-opacity-50">
        </div>
        <div>
            <label for="mdp" class="block text-sm font-medium text-gray-400">Mot de passe :</label>
            <input type="password" id="mdp" name="mdp" required class="mt-1 p-2 w-full rounded-md bg-gray-700 text-white border border-gray-600 focus:border-yellow-500 focus:ring focus:ring-yellow-200 focus:ring-opacity-50">
        </div>
        <div>
            <input type="submit" value="Se connecter" class="mt-2 px-4 py-2 bg-yellow-500 hover:bg-yellow-700 rounded-full text-gray-900">
        </div>
    </form>
</div>