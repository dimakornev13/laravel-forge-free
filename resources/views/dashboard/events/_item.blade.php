<?php
/** @var \App\Models\LogEvent $entity */
?>

<tr>
    <td class="border border-black-300">
{{--        fix for colors because tailwind plugin look for whole entries like below --}}
        <div class="hidden bg-green-400 bg-blue-400 bg-yellow-400 bg-red-400 "></div>

        <div class="block rounded-full bg-{{ $entity->getLabelColor() }}-400 w-full">&nbsp;</div>
    </td>
    <td class="border border-black-300 p-6">{!! $entity->getMessage() !!}</td>
    <td class="border border-black-300">{{ $entity->getDate() }}</td>
</tr>
