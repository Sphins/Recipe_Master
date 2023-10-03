<div class="container mx-auto mt-12 p-6 bg-gray-700 rounded-lg shadow-lg text-center w-full">
    <h2 class="text-2xl mb-6">
        <?php echo isset($existingData) ? 'Modifier l’élément' : 'Ajouter un nouvel élément'; ?>
    </h2>
    <form method="post" action="www/table/<?php echo isset($existingData) ? 'update/' : 'add/'; ?><?php echo $selectedTable; ?><?php echo isset($existingData) ? '/' . $existingData['id'] : ''; ?>" enctype="multipart/form-data" class="w-full max-w-xl mx-auto">
        <?php foreach ($columns as $column) : ?>
            <?php
            $columnName = $column['Field'];
            $columnType = $column['Type'];
            $value = isset($existingData[$columnName]) ? $existingData[$columnName] : '';
            ?>

            <?php if (!in_array($columnName, ['id', 'created_at'])) : ?>
                <div class="mb-4">
                    <label for="<?= $columnName ?>" class="block text-gray-300 text-sm font-bold mb-2 text-left"><?= ucfirst($columnName) ?>:</label>

                    <?php
                    switch (true) {
                        case isset($columsForeingnKey[$columnName]):
                            echo '<select name="' . $columnName . '" id="' . $columnName . '" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">';
                            foreach ($columsForeingnKey[$columnName] as $row) {
                                $selected = $value == $row['id'] ? 'selected' : '';
                                echo '<option value="' . $row['id'] . '" ' . $selected . '>' . (isset($row['name']) ? $row['name'] : implode(' ', array_filter($row, function ($key) {
                                    return strpos($key, 'name') !== false;
                                }, ARRAY_FILTER_USE_KEY))) . '</option>';
                            }
                            echo '</select>';
                            break;

                        case $columnName == 'picture':
                        case $columnName == 'cover':
                            echo '<input type="file" name="' . $columnName . '" id="' . $columnName . '" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">';
                            break;

                        case $columnName == 'password':
                        case $columnName == 'Password':
                            echo '<div class="mb-4">';
                            echo '<label for="password" class="block text-gray-300 text-sm font-bold mb-2 text-left">Mot de passe :</label>';
                            echo '<input type="password" name="password" id="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>';
                            echo '</div>';
                            echo '<div class="mb-4">';
                            echo '<label for="confirm_password" class="block text-gray-300 text-sm font-bold mb-2 text-left">Confirmer le mot de passe :</label>';
                            echo '<input type="password" name="confirm_password" id="confirm_password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>';
                            echo '</div>';
                            break;

                        case strpos($columnType, 'varchar') !== false:
                        case strpos($columnType, 'text') !== false:
                        case strpos($columnType, 'int') !== false:
                        case strpos($columnType, 'date') !== false:
                            echo '<input type="' . (strpos($columnType, 'int') !== false ? 'number' : 'text') . '" name="' . $columnName . '" id="' . $columnName . '" value="' . $value . '" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">';
                            break;

                        case strpos($columnType, 'enum') !== false:
                            echo '<select name="' . $columnName . '" id="' . $columnName . '" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">';
                            preg_match("/^enum\(\'(.*)\'\)$/", $columnType, $matches);
                            $enumValues = explode("','", $matches[1]);
                            foreach ($enumValues as $enumValue) {
                                $selected = $value == $enumValue ? 'selected' : '';
                                echo "<option value='$enumValue' $selected>$enumValue</option>";
                            }
                            echo '</select>';
                            break;
                    }
                    ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>


        <?php
        // echo '<pre>';
        // // print_r($nmData);
        // print_r($existingData);
        // echo '</pre>';
        foreach ($nmData as $relatedTable => $rows) : ?>
            <div class="mb-4">
                <label class="block text-gray-300 text-sm font-bold mb-2 text-left"><?= ucfirst($relatedTable) ?>:</label>
                <ul class="flex flex-wrap pl-4">
                    <?php
                    $existingIds = [];
                    if (isset($existingData[$relatedTable]) && is_array($existingData[$relatedTable])) {
                        $existingIds = array_column($existingData[$relatedTable], 'toId');
                    }
                    foreach ($rows as $row) : ?>
                        <?php
                        $checked = '';
                        $rowId = isset($row['toId']) ? $row['toId'] : $row['id'];
                        if (in_array($rowId, $existingIds)) {
                            $checked = 'checked';
                        }

                        // Initiate addCol1Value with an empty string
                        $addCol1Value = '';
                        // Check if there are related rows in existingData and find addCol1 value
                        if (isset($existingData[$relatedTable])) {
                            foreach ($existingData[$relatedTable] as $existingRow) {
                                if ($existingRow['toId'] == $rowId && isset($existingRow['addCol1'])) {
                                    $addCol1Value = $existingRow['addCol1'];
                                    break;
                                }
                            }
                        }
                        ?>
                        <li class="w-1/3 text-left flex items-center mb-2">
                            <label class="flex items-center justify-between w-full">
                                <input type="checkbox" name="<?= $relatedTable ?>[]" value="<?= $rowId ?>" <?= $checked ?> class="mr-2 leading-tight">
                                <span class="flex-1"><?= htmlspecialchars($row['name']) ?></span>
                            </label>
                            <input type="text" name="additional[<?= $rowId ?>]" value="<?= htmlspecialchars($addCol1Value) ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="" size="3">
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