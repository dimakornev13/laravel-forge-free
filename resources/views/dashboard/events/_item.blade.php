<?php
/** @var \App\Models\LogEvent $entity */
?>

<tr>
    <td class="border border-black-300">
        <div class="block rounded-full bg-{{ $entity->getLabelColor() }}-400 w-full">&nbsp;</div>
    </td>
    <td class="border border-black-300 p-6">{!! $entity->getMessage() !!}</td>
    <td class="border border-black-300">{{ $entity->getDate() }}</td>
</tr>
