<?php
/** @var \App\Models\Site $site */
?>

<tr class="border-b border-gray-300 p-3">
    <td>
        <a href="{{ url(route('deploy', ['site' => $site])) }}">{{ $site->getUrl() }}</a>
    </td>
    <td class="text-center">
        <x-confirm-modal-delete :url="route('sites.delete', ['site' => $site])" :content="$site->getUrl()"></x-confirm-modal-delete>
    </td>
</tr>


