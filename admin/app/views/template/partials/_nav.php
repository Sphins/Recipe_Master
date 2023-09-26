<!-- Fixed navbar -->
<nav class="bg-gray-700 fixed top-0 w-full z-50 text-white">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <!-- Navbar Header -->
            <div class="flex items-center">
                <a href="" class="text-gray-300 font-bold text-xl hover:text-white no-underline hover:no-underline">BACKOFFICE <?php echo PROJECT_NAME ?></a>
            </div>
            <h1 class="text-white font-bold text-xl "><?php echo ucfirst($title ?? 'Untitled'); ?></h1>
            <div class="flex">

                <?php include_once '../app/views/tables/showMenuTables.php'; ?>
                <a href="www/users/logout" class="text-gray-300 hover:text-red-700 px-3 py-2 ml-4 no-underline hover:no-underline">Logout</a>
            </div>
        </div>
    </div>
</nav>