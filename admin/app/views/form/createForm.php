<div class="container mx-auto mt-12 p-6 bg-gray-700 rounded-lg shadow-lg text-center w-full">
    <h2 class="text-2xl mb-6">Ajouter un nouvel élément</h2>
    <form method="post" action="www/table/add/<?php echo $selectedTable ?>" enctype="multipart/form-data" class="w-full max-w-xl mx-auto">
        <?php foreach ($columns as $column) : ?>
            <?php
            $columnName = $column['Field'];
            $columnType = $column['Type'];
            ?>

            <?php if (!in_array($columnName, ['id', 'created_at'])) : ?>
                <div class="mb-4">
                    <label for="<?= $columnName ?>" class="block text-gray-300 text-sm font-bold mb-2 text-left"><?= ucfirst($columnName) ?>:</label>

                    <?php
                    switch (true) {
                        case isset($columsForeingnKey[$columnName]):
                            echo '<select name="' . $columnName . '" id="' . $columnName . '" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">';
                            foreach ($columsForeingnKey[$columnName] as $row) {
                                echo '<option value="' . $row['id'] . '">' . (isset($row['name']) ? $row['name'] : implode(' ', array_filter($row, function ($key) {
                                    return strpos($key, 'name') !== false;
                                }, ARRAY_FILTER_USE_KEY))) . '</option>';
                            }
                            echo '</select>';
                            break;

                        case $columnName == 'picture':
                        case $columnName == 'cover':
                            echo '<input type="file" name="' . $columnName . '" id="' . $columnName . '" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">';
                            break;

                        case strpos($columnType, 'varchar') !== false:
                            if ($columnName == 'email') {
                                echo '<input type="email" name="' . $columnName . '" id="' . $columnName . '" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="example@example.com">';
                            } else {
                                echo '<input type="text" name="' . $columnName . '" id="' . $columnName . '" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">';
                            }
                            break;

                        case strpos($columnType, 'text') !== false:
                            echo '<textarea name="' . $columnName . '" id="' . $columnName . '" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>';
                            break;

                        case strpos($columnType, 'int') !== false:
                            echo '<input type="number" name="' . $columnName . '" id="' . $columnName . '" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">';
                            break;

                        case strpos($columnType, 'date') !== false:
                            echo '<input type="date" name="' . $columnName . '" id="' . $columnName . '" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">';
                            break;

                        case strpos($columnType, 'enum') !== false:
                            echo '<select name="' . $columnName . '" id="' . $columnName . '" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">';
                            preg_match("/^enum\(\'(.*)\'\)$/", $columnType, $matches);
                            $enumValues = explode("','", $matches[1]);
                            foreach ($enumValues as $value) {
                                echo "<option value='$value'>$value</option>";
                            }
                            echo '</select>';
                            break;
                    }
                    ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php
        foreach ($nmData as $relatedTable => $rows) : ?>
            <div class="mb-4">
                <label class="block text-gray-300 text-sm font-bold mb-2 text-left"><?= ucfirst($relatedTable) ?>:</label>
                <ul class="flex flex-wrap pl-4">
                    <?php foreach ($rows as $row) : ?>
                        <li class="w-1/3 text-left">
                            <label>
                                <input type="checkbox" name="<?= $relatedTable ?>[]" value="<?= $row['id'] ?>" class="mr-2 leading-tight">
                                <?= $row['name'] ?>
                            </label>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endforeach; ?>
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" onsubmit="return confirm('Êtes-vous sûr de vouloir soumettre?');">
                Ajouter
            </button>
        </div>
    </form>
</div>