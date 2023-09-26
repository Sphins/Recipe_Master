<?php
include_once '../app/models/tablesModel.php';

use App\Models\TablesModel\Model;

$tables = (new Model($connexion))->getTables();

?>

<form action="" method="get" id="tableForm" class="flex items-center text-gray-300">
    <label for="table" class="mr-4 text-lg">Modification/Supression :</label>
    <select name="table" id="table" onchange="changeURL();" class="bg-gray-800 text-white p-2 rounded">
        <option value="default" class="bg-gray-700">Sélectionnez une table</option>

        <?php foreach ($tables as $table) : ?>
            <option value="<?php echo $table; ?>" class="bg-gray-700"><?php echo ucfirst($table); ?></option>
        <?php endforeach; ?>
    </select>
</form>