<?php
include_once '../app/models/tablesModel.php';

include_once '../app/views/tables/_addTablElementButton.php';
?>
<table class="container mx-auto mt-12 p-6 bg-gray-700 rounded-lg shadow-lg text-center w-full">
    <thead>
        <tr>
            <?php foreach ($data[0] as $key => $value) : ?>
                <th class="px-4 py-2"><?php echo $key; ?></th>
            <?php endforeach; ?>
            <th class="px-4 py-2">Modifier</th>
            <th class="px-4 py-2">Supprimer</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $row) : ?>
            <tr>
                <?php foreach ($row as $value) : ?>
                    <td class="border px-4 py-2"><?php echo $value; ?></td>
                <?php endforeach; ?>
                <td class="border px-4 py-2">
                    <a href="www/table/edit/<?php echo $title; ?>/<?php echo $row['id']; ?>" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded">Modifier</a>
                </td>
                <td class="border px-4 py-2">
                    <a href="javascript:void(0);" onclick="confirmDelete('www/table/delete/<?php echo $title; ?>/<?php echo $row['id']; ?>')" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>