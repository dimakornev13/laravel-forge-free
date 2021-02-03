<?php
/** @var \App\Models\LogEvent $entity */
?>

<tr>
    <div class="hidden bg-green-200 bg-blue-200 bg-yellow-200 bg-red-200"></div>

    <td class="border border-black-300 p-6 bg-{{ $entity->getLabelColor() }}-200">
        <div class="h-40 overflow-auto">{!! $entity->getMessage() !!}</div>
    </td>
    <td class="border border-black-300">{{ $entity->getDate() }}</td>
</tr>
